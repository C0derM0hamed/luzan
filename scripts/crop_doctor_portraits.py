#!/usr/bin/env python3
"""Crop full circular doctor portraits and remove the name-pill overlay."""

from __future__ import annotations

import re
from pathlib import Path

import cv2
import numpy as np
from PIL import Image

SOURCE_DIR = Path(__file__).resolve().parent.parent / "Doctor_s Pics"
OUTPUT_DIR = Path(__file__).resolve().parent.parent / "public/images/doctors"
OUTPUT_SIZE = 360

FILENAME_PATTERN = re.compile(r"^\[doctor(\d+)\]\.jpeg$", re.IGNORECASE)


def detect_circle(img: np.ndarray) -> tuple[int, int, int]:
    gray = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    circles = cv2.HoughCircles(
        gray,
        cv2.HOUGH_GRADIENT,
        dp=1,
        minDist=200,
        param1=50,
        param2=30,
        minRadius=150,
        maxRadius=220,
    )
    if circles is None:
        return 450, 770, 180

    valid = [c for c in circles[0] if 350 < c[0] < 580 and 580 < c[1] < 920]
    if not valid:
        valid = list(circles[0])

    best = max(valid, key=lambda c: c[2])
    return int(best[0]), int(best[1]), int(best[2])


def build_pill_mask(size: int, circle_mask: np.ndarray) -> np.ndarray:
    """Name pill sits on the right edge of the portrait circle."""
    pill_mask = np.zeros((size, size), dtype=np.uint8)
    center = (int(0.76 * size), int(0.43 * size))
    axes = (int(0.17 * size), int(0.095 * size))
    cv2.ellipse(pill_mask, center, axes, 0, 0, 360, 255, -1)
    return cv2.bitwise_and(pill_mask, circle_mask)


def process_image(img: np.ndarray) -> Image.Image:
    cx, cy, r = detect_circle(img)
    h, w = img.shape[:2]

    crop = img[max(0, cy - r) : cy + r, max(0, cx - r) : cx + r]
    size = 2 * r
    padded = np.zeros((size, size, 3), dtype=np.uint8)
    ch, cw = crop.shape[:2]
    y_offset = (size - ch) // 2
    x_offset = (size - cw) // 2
    padded[y_offset : y_offset + ch, x_offset : x_offset + cw] = crop

    circle_mask = np.zeros((size, size), dtype=np.uint8)
    cv2.circle(circle_mask, (r, r), r - 1, 255, -1)

    pill_mask = build_pill_mask(size, circle_mask)
    cleaned = cv2.inpaint(padded, pill_mask, 10, cv2.INPAINT_NS)

    rgba = cv2.cvtColor(cleaned, cv2.COLOR_BGR2RGBA)
    rgba[:, :, 3] = circle_mask
    rgba = cv2.resize(rgba, (OUTPUT_SIZE, OUTPUT_SIZE), interpolation=cv2.INTER_LANCZOS4)

    return Image.fromarray(rgba)


def main() -> None:
    OUTPUT_DIR.mkdir(parents=True, exist_ok=True)

    if not SOURCE_DIR.is_dir():
        raise SystemExit(f"Source directory not found: {SOURCE_DIR}")

    paths: list[tuple[int, Path]] = []
    for path in SOURCE_DIR.glob("*.jpeg"):
        match = FILENAME_PATTERN.match(path.name)
        if match:
            paths.append((int(match.group(1)), path))

    paths.sort(key=lambda item: item[0])

    for doctor_num, path in paths:
        img = cv2.imread(str(path))
        if img is None:
            print(f"Warning: could not read {path}")
            continue

        portrait = process_image(img)
        out_path = OUTPUT_DIR / f"doctor{doctor_num}.png"
        portrait.save(out_path)
        print(f"Saved {out_path}")

    print(f"Done. Processed {len(paths)} image(s).")


if __name__ == "__main__":
    main()
