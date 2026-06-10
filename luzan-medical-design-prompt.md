# Luzan Medical Center — Laravel Design Prompt for Cursor Agent

## Overview
Build the **frontend design only** for **Luzan Specialized Medical Center** using **Laravel Blade + Tailwind CSS + Alpine.js**.
- All data (doctors, appointments, services, branches) must come from the **controller via the database** — no static/hardcoded data in Blade templates.
- All Blade templates should use `{{ $variable }}` and `@foreach` loops over whatever the controller passes in.
- This prompt is **design and structure only** — do not create migrations, seeders, or models. Just wire the views to expect the right variables.

---

## Design Tokens

```
Primary Color:      #00A99D  (teal)
Primary Dark:       #007A72
White:              #FFFFFF
Light Background:   #F9F9F9
Border Color:       #E0E0E0
Body Text:          #444444
Muted Text:         #888888
Accent Red:         #E53E3E  (section title underline only)
```

**Typography:**
- Font: `Cairo` (Google Fonts) — weights 400, 600, 700, 800
- All pages: `dir="rtl"` on `<html lang="ar">`
- Base font-size: 16px

**Spacing & Radius:**
- Section padding: `py-16`
- Card border-radius: `rounded-xl`
- Button border-radius: `rounded`
- Global card shadow: `shadow-md`

---

## Project Structure

```
resources/views/
├── layouts/
│   └── app.blade.php          ← master layout
├── components/
│   ├── navbar.blade.php
│   ├── hero.blade.php
│   ├── services.blade.php
│   ├── doctors.blade.php
│   ├── branches.blade.php
│   └── footer.blade.php
└── home.blade.php             ← assembles all components

public/images/
├── logo.png
└── hero.png
```

---

## Layout: `layouts/app.blade.php`

- `<html lang="ar" dir="rtl">`
- In `<head>`:
  - Google Fonts: Cairo
  - Tailwind CSS (via CDN or Vite — use whichever is configured)
  - Alpine.js CDN
  - `<style>* { font-family: 'Cairo', sans-serif; }</style>`
- Body: `bg-white text-gray-800`
- `@include('components.navbar')`
- `@yield('content')`
- `@include('components.footer')`

---

## Component 1: Navbar

**Structure:** single horizontal bar, `height: 64px`, white background, bottom border `1px solid #E0E0E0`.

**Right side:**
- `<img src="{{ asset('images/logo.png') }}"` height `40px`
- Clinic name text next to logo: `مجمع لوزان التخصصي الطبي`, `font-weight: 700`, `font-size: 16px`, color `#222`

**Center:**
- Nav links (RTL order, right to left): الرئيسية / الخدمات / الأطباء / حجز موعد / الفروع / من نحن / اتصل بنا
- Active link (`الرئيسية`): color `#00A99D`, `font-weight: 600`
- Other links: color `#444`, hover color `#00A99D`, transition `150ms`

**Left side:**
- Phone button: border `1.5px solid #00A99D`, color `#00A99D`, `border-radius: 20px`, padding `8px 18px`
- Content: phone icon (SVG) + number `017 722 1892`
- Hover: background `#00A99D`, color white

**Mobile (< 768px):**
- Hamburger icon replaces center links
- Alpine.js `x-show` toggle for mobile menu dropdown

---

## Component 2: Hero Section

**Container:** full-width, `height: 420px`, background gradient `linear-gradient(to left, #007A72, #00A99D)`

**Three-column layout (CSS Grid, `grid-cols-3`):**

### Column 1 — Text (right):
- Headline: `مجمع لوزان / التخصصي الطبي`, `font-size: 48px`, `font-weight: 800`, color `white`, line-height tight
- Subtext below headline, `font-size: 17px`, color `rgba(255,255,255,0.85)`:
  > مجمع طبي متكامل يضم نخبة من الأطباء والاستشاريين وأحدث الأجهزة الطبية لخدمة صحتك وراحة بالك
- Three icon badges below subtext (horizontal flex row):
  - Each badge: SVG icon (white, 24px) + label below it (white, 13px)
  - Badge 1: group-of-people icon + `أطباء متخصصون`
  - Badge 2: medical-cross icon + `خدمات متكاملة`
  - Badge 3: star/shield icon + `رعاية عالية الجودة`

### Column 2 — Doctor Image (center):
- `<img src="{{ asset('images/hero.png') }}"`, `object-fit: contain`, full column height
- No background, no border, no shadow

### Column 3 — Booking Form (left):
White card, `border-radius: 12px`, padding `24px`, `box-shadow: 0 4px 20px rgba(0,0,0,0.12)`

**Form header:**
- Title: `احجز موعدك الآن`, `font-size: 18px`, bold, color `#222`
- Subtitle: `احجز موعدك بكل سهولة`, color `#00A99D`, `font-size: 13px`

**Four form fields (stacked):**
All inputs: `border: 1px solid #ddd`, `height: 44px`, `border-radius: 6px`, `padding: 0 12px`, width 100%, RTL text

1. **ID Number** — placeholder `رقم الهوية`, icon: ID card SVG on the right inside input
2. **Mobile Number** — placeholder `رقم الجوال`, icon: phone SVG
3. **Doctor / Specialty** — `<select>` with placeholder option `اختر الطبيب أو التخصص`, icon: stethoscope SVG — **options populated dynamically from `$doctors` and `$specialties` passed by controller**
4. **Date** — `<input type="date">`, placeholder `اختر التاريخ`, icon: calendar SVG

**Submit button:**
- Text: `احجز الآن`
- Background `#00A99D`, color white, width 100%, height `48px`, `border-radius: 6px`, `font-weight: 700`
- Hover: background `#007A72`
- `@csrf` token inside form

> The form `action` should point to a bookings route. The controller handles submission — this is design only.

---

## Component 3: Services Section

**Container:** white background, `padding: 64px 0`

**Section header (right-aligned):**
- Title text: `خدماتنا`, `font-size: 22px`, `font-weight: 700`, color `#222`
- Below title: short red bar `width: 40px`, `height: 3px`, `background: #E53E3E` (accent underline)

**Services grid:**
- Horizontal scrollable row of service cards
- Each card: `border: 1px solid #eee`, `border-radius: 10px`, padding `16px`, width `90px`, text-align center
  - SVG icon top (teal, `32px`) — use outline medical icons (Heroicons or similar)
  - Service name below, `font-size: 12px`, color `#444`
  - Hover: `border-color: #00A99D`, `box-shadow: 0 2px 8px rgba(0,169,157,0.15)`

**Data binding:**
```blade
@foreach($services as $service)
  <div class="service-card ...">
    {!! $service->icon_svg !!}
    <p>{{ $service->name }}</p>
  </div>
@endforeach
```

**"Show All Services" button:**
- Centered below the grid
- Background `#00A99D`, color white, padding `10px 32px`, `border-radius: 4px`
- Hover: `#007A72`

---

## Component 4: Branches & Doctors (Side by Side)

**Container:** background `#F9F9F9`, `padding: 64px 0`
**Two-column grid:** `grid-cols-[35%_65%]` — Branches on right, Doctors on left

---

### Right Column — Branches (`فروعنا`)

**Section header:** same style as Services (title + red underline)

**Each branch card:**
- White background, `border-radius: 10px`, padding `20px`, `box-shadow: shadow-sm`, `margin-bottom: 16px`
- Branch name as heading: color `#00A99D`, `font-size: 16px`, `font-weight: 700`
- Three info rows with icons:
  - 📍 Address — location pin SVG + `{{ $branch->address }}`
  - 📞 Phone — phone SVG + `{{ $branch->phone }}`
  - ✉️ Email — envelope SVG + `{{ $branch->email }}`

**Data binding:**
```blade
@foreach($branches as $branch)
  <div class="branch-card ...">
    <h3>{{ $branch->name }}</h3>
    <p>📍 {{ $branch->address }}</p>
    <p>📞 {{ $branch->phone }}</p>
    <p>✉️ {{ $branch->email }}</p>
  </div>
@endforeach
```

**"View on Map" button:** background `#00A99D`, color white, full width of column

---

### Left Column — Doctors (`أطباؤنا`)

**Section header:** same style

**Slider (Alpine.js):**
```html
<div x-data="{ offset: 0, total: {{ $doctors->count() }} }">
  <!-- Left arrow button -->
  <button @click="offset = Math.max(0, offset - 1)"> ← </button>

  <div class="overflow-hidden">
    <div class="flex gap-4 transition-transform duration-300"
         :style="`transform: translateX(calc(${offset} * -25%))`">

      @foreach($doctors as $doctor)
        <!-- Doctor Card -->
      @endforeach

    </div>
  </div>

  <!-- Right arrow button -->
  <button @click="offset = Math.min(total - 4, offset + 1)"> → </button>
</div>
```

**Each doctor card:**
- White background, `border-radius: 10px`, padding `16px`, `box-shadow: shadow-sm`, min-width `calc(25% - 12px)`
- **Top:** circular doctor photo, `width: 70px`, `height: 70px`, `border-radius: 50%`, `object-fit: cover`
  - Use `{{ asset('storage/' . $doctor->photo) }}` or a gray placeholder if no photo
- Doctor name: `font-size: 16px`, `font-weight: 700`, color `#222` — `{{ $doctor->name }}`
- Specialty: `font-size: 13px`, color `#00A99D` — `{{ $doctor->specialty }}`
- Working hours: `font-size: 12px`, color `#888` — `{{ $doctor->working_hours }}`
- **Book button:**
  - Border `1.5px solid #00A99D`, color `#00A99D`, full width, `border-radius: 4px`, padding `8px`
  - Hover: background `#00A99D`, color white, transition `150ms`

**"Show All Doctors" button:** background `#00A99D`, color white, centered below slider

---

## Component 5: Footer

**Container:** background `#00A99D`, color white, `padding: 48px 0 0`

**Four-column grid:**

### Column 1 (right) — Logo & Tagline:
- `<img src="{{ asset('images/logo.png') }}"` — use CSS `filter: brightness(0) invert(1)` to make logo white
- Clinic name: `مجمع لوزان التخصصي الطبي`, `font-weight: 700`, `font-size: 16px`, white
- Tagline: `رعايتك... أولويتنا`, `font-size: 14px`, `color: rgba(255,255,255,0.8)`

### Column 2 — Our Services (`خدماتنا`):
- Column heading: `font-weight: 700`, white
- List of links (white, `font-size: 14px`, hover underline):
  - جميع التخصصات الطبية
  - أحدث الأجهزة الطبية
  - فريق طبي متخصص
  - رعاية على مدار الساعة

### Column 3 — Quick Links (`روابط سريعة`):
- Column heading: `font-weight: 700`, white
- Links: الرئيسية / الخدمات / الأطباء / حجز موعد / اتصل بنا

### Column 4 (left) — Follow Us (`تابعنا`):
- Column heading: `font-weight: 700`, white
- Four social icon circles (Snapchat, Instagram, Twitter/X, Facebook):
  - Circle: `width: 36px`, `height: 36px`, `border-radius: 50%`, background `white`
  - Icon inside: color `#00A99D`, `font-size: 16px`
  - Hover: background `rgba(255,255,255,0.85)`

**Copyright bar (bottom of footer):**
- `border-top: 1px solid rgba(255,255,255,0.2)`, `margin-top: 32px`, `padding: 16px 0`
- Text: `جميع الحقوق محفوظة © 2024 مجمع لوزان التخصصي الطبي`
- `text-align: center`, `font-size: 14px`, `color: rgba(255,255,255,0.8)`

---

## Responsive Breakpoints

### Mobile (< 768px):
- Navbar: hamburger button replaces center links; Alpine.js toggles dropdown
- Hero: single column stack — text → form → image hidden
- Services: wrap into 3 columns per row
- Branches & Doctors: stack vertically, full width each
- Footer: single column, center-aligned

### Tablet (768px – 1024px):
- Hero: 2 columns (text + form), image hidden
- Services: 5 items per row
- Branches & Doctors: keep side by side but adjust ratios to `50%/50%`

---

## Variables Expected from Controller

The Blade views should expect these variables — controller and DB logic is not your concern:

| Variable | Type | Used In |
|---|---|---|
| `$services` | Collection | Services section |
| `$doctors` | Collection | Doctors slider |
| `$specialties` | Collection | Booking form select |
| `$branches` | Collection | Branches section |

Each model will have relevant fields (name, photo, specialty, working_hours, address, phone, email, etc.) — use them via dot notation in Blade.

---

## Final Rules for the Agent

- **No static data** in any Blade file — all content via `{{ }}` and `@foreach`
- **No Bootstrap** — Tailwind CSS only
- **No jQuery** — Alpine.js for all interactivity
- Use `asset()` helper for all image paths
- Use `@csrf` in all forms
- Use `route()` helper for all `href` and `action` attributes
- Every section must be a separate Blade component (`<x-component-name />` or `@include`)
- RTL must be enforced at the `<html>` level and verified on every flex/grid layout
- Icons: use inline SVG from Heroicons (outline style), teal color `#00A99D`
