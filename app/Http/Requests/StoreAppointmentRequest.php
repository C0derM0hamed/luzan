<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'national_id' => ['required', 'string', 'max:20'],
            'mobile' => ['required', 'string', 'max:20'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! $this->filled('doctor_id') && ! $this->filled('specialty')) {
                $validator->errors()->add('doctor_id', 'يجب اختيار الطبيب أو التخصص.');
            }

            if ($this->filled('doctor_id') && $this->filled('specialty')) {
                $validator->errors()->add('doctor_id', 'اختر إما الطبيب أو التخصص وليس كلاهما.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'الاسم الكامل مطلوب.',
            'national_id.required' => 'رقم الهوية مطلوب.',
            'mobile.required' => 'رقم الجوال مطلوب.',
            'appointment_date.required' => 'تاريخ الموعد مطلوب.',
            'appointment_date.after_or_equal' => 'يجب أن يكون تاريخ الموعد اليوم أو بعده.',
        ];
    }
}
