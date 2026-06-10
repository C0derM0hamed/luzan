<?php

namespace App\View\Composers;

use App\Models\Appointment;
use App\Services\SettingService;
use Illuminate\View\View;

class AdminViewComposer
{
    public function __construct(private SettingService $settings) {}

    public function compose(View $view): void
    {
        $view->with([
            'clinicName' => $this->settings->get('clinic_name', 'مجمع لوزان التخصصي الطبي'),
            'createLabel' => 'إضافة جديد',
            'editLabel' => 'تعديل',
            'deleteLabel' => 'حذف',
            'saveLabel' => 'حفظ',
            'cancelLabel' => 'إلغاء',
            'backLabel' => 'رجوع',
            'viewActionLabel' => 'عرض',
            'approveLabel' => 'موافقة',
            'cancelActionLabel' => 'إلغاء',
            'cancelConfirm' => 'هل تريد إلغاء هذا الموعد؟',
            'deleteConfirm' => 'هل أنت متأكد من الحذف؟',
            'activeLabel' => 'نشط',
            'inactiveLabel' => 'غير نشط',
            'totalLabel' => 'سجل',
            'appointmentStatusLabels' => Appointment::statusLabels(),
            'appointmentStatusClasses' => [
                Appointment::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
                Appointment::STATUS_APPROVED => 'bg-green-100 text-green-800',
                Appointment::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            ],
            'fieldLabels' => [
                'name' => 'الاسم',
                'specialty' => 'التخصص',
                'working_hours' => 'ساعات العمل',
                'photo' => 'الصورة',
                'sort_order' => 'ترتيب العرض',
                'is_active' => 'نشط',
                'icon_svg' => 'أيقونة SVG',
                'address' => 'العنوان',
                'phone' => 'الهاتف',
                'email' => 'البريد الإلكتروني',
                'map_url' => 'رابط الخريطة',
                'full_name' => 'الاسم الكامل',
                'national_id' => 'رقم الهوية',
                'mobile' => 'رقم الجوال',
                'doctor_id' => 'الطبيب',
                'doctor_none' => '— بدون طبيب (تخصص فقط) —',
                'appointment_date' => 'تاريخ الموعد',
                'status' => 'الحالة',
                'notes' => 'ملاحظات',
            ],
        ]);
    }
}
