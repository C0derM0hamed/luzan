<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            ['label' => 'الأطباء', 'value' => Doctor::query()->count()],
            ['label' => 'الخدمات', 'value' => Service::query()->count()],
            ['label' => 'الفروع', 'value' => Branch::query()->count()],
            ['label' => 'المواعيد المعلقة', 'value' => Appointment::query()->where('status', Appointment::STATUS_PENDING)->count()],
        ];

        $recentAppointments = Appointment::query()
            ->with('doctor')
            ->latest()
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'pageTitle' => 'لوحة التحكم',
            'stats' => $stats,
            'recentAppointments' => $recentAppointments,
            'recentAppointmentsTitle' => 'أحدث المواعيد',
            'appointmentTableHeaders' => ['الاسم', 'الجوال', 'الطبيب', 'التاريخ', 'الحالة', 'إجراء'],
        ]);
    }
}
