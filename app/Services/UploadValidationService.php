<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

class UploadValidationService
{
    /**
     * Validate the file extension against a whitelist using only the original filename.
     *
     * @param UploadedFile|UploadedFile[]|null $file
     * @param array $allowedExtensions
     * @param string $fieldName
     * @return void
     * @throws ValidationException
     */
    public static function validate(UploadedFile|array|null $file, array $allowedExtensions, string $fieldName = 'file'): void
    {
        if (! $file) {
            return;
        }

        if (is_array($file)) {
            foreach ($file as $f) {
                self::validateSingle($f, $allowedExtensions, $fieldName);
            }
            return;
        }

        self::validateSingle($file, $allowedExtensions, $fieldName);
    }

    protected static function validateSingle(UploadedFile $file, array $allowedExtensions, string $fieldName): void
    {
        if (! $file->isValid()) {
            throw ValidationException::withMessages([
                $fieldName => 'الملف المرفوع غير صالح أو حدث خطأ أثناء الرفع.',
            ]);
        }

        $filename = $file->getClientOriginalName();
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        if (! in_array($extension, $allowedExtensions, true)) {
            $allowed = implode('، ', $allowedExtensions);
            throw ValidationException::withMessages([
                $fieldName => "صيغة الملف غير مسموحة. الصيغ المسموحة هي: {$allowed}.",
            ]);
        }
    }
}
