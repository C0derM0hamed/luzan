<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Doctor;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query()->with(['doctor', 'branch'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('date')) {
            $query->whereDate('appointment_date', $request->date('date'));
        }

        $appointments = $query->paginate(20)->withQueryString();

        return view('admin.appointments.index', [
            'pageTitle' => 'إدارة المواعيد',
            'appointments' => $appointments,
            'statusOptions' => Appointment::statusLabels(),
            'tableHeaders' => ['#', 'الاسم', 'رقم الهوية', 'الجوال', 'الفرع', 'الطبيب/التخصص', 'التاريخ', 'الحالة', 'إجراءات'],
            'filterLabels' => [
                'status' => 'الحالة',
                'date' => 'التاريخ',
                'all' => 'الكل',
                'apply' => 'تصفية',
            ],
        ]);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['doctor', 'branch']);

        $fieldLabels = [
            'full_name' => 'الاسم الكامل',
            'national_id' => 'رقم الهوية',
            'mobile' => 'رقم الجوال',
            'branch_id' => 'الفرع',
            'doctor_id' => 'الطبيب / التخصص',
            'appointment_date' => 'تاريخ الموعد',
            'status' => 'الحالة',
            'notes' => 'ملاحظات',
            'created_at' => 'تاريخ الطلب',
        ];

        $appointmentDetails = [
            $fieldLabels['full_name'] => $appointment->full_name,
            $fieldLabels['national_id'] => $appointment->national_id,
            $fieldLabels['mobile'] => $appointment->mobile,
            $fieldLabels['branch_id'] => $appointment->branch?->name ?? '—',
            $fieldLabels['doctor_id'] => $appointment->bookingTargetLabel(),
            $fieldLabels['appointment_date'] => $appointment->appointment_date->format('Y-m-d'),
            $fieldLabels['status'] => Appointment::statusLabels()[$appointment->status] ?? $appointment->status,
            $fieldLabels['notes'] => $appointment->notes ?: '—',
            $fieldLabels['created_at'] => $appointment->created_at->format('Y-m-d H:i'),
        ];

        return view('admin.appointments.show', [
            'pageTitle' => 'تفاصيل الموعد',
            'appointment' => $appointment,
            'appointmentDetails' => $appointmentDetails,
        ]);
    }

    public function edit(Appointment $appointment)
    {
        $appointment->load(['doctor', 'branch']);
        $doctors = Doctor::query()->where('is_active', true)->orderBy('name')->get();
        $branches = Branch::query()->where('is_active', true)->orderBy('name')->get();

        return view('admin.appointments.edit', [
            'pageTitle' => 'تعديل الموعد',
            'appointment' => $appointment,
            'doctors' => $doctors,
            'branches' => $branches,
            'statusOptions' => Appointment::statusLabels(),
        ]);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'national_id' => ['required', 'string', 'max:20'],
            'mobile' => ['required', 'string', 'max:20'],
            'branch_id' => ['nullable', 'exists:branches,id'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'appointment_date' => ['required', 'date'],
            'status' => ['required', 'in:'.implode(',', array_keys(Appointment::statusLabels()))],
            'notes' => ['nullable', 'string'],
        ], [
            'full_name.required' => 'الاسم الكامل مطلوب.',
            'status.required' => 'حالة الموعد مطلوبة.',
        ]);

        if (! empty($data['doctor_id'])) {
            $data['specialty'] = null;
        }

        $appointment->update($data);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'تم تحديث الموعد بنجاح.');
    }

    public function approve(Appointment $appointment)
    {
        $appointment->update(['status' => Appointment::STATUS_APPROVED]);

        return back()->with('success', 'تمت الموافقة على الموعد.');
    }

    public function cancel(Appointment $appointment)
    {
        $appointment->update(['status' => Appointment::STATUS_CANCELLED]);

        return back()->with('success', 'تم إلغاء الموعد.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'تم حذف الموعد بنجاح.');
    }
}
