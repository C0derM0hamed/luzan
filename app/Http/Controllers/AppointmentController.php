<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();
        $data['status'] = Appointment::STATUS_PENDING;

        if (! empty($data['doctor_id'])) {
            $data['specialty'] = null;
        } else {
            $data['doctor_id'] = null;
        }

        Appointment::query()->create($data);

        return back()->with('success', 'تم استلام طلب الحجز بنجاح. سنتواصل معك قريباً لتأكيد الموعد.');
    }
}
