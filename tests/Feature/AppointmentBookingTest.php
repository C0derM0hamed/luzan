<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentBookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_loads_successfully(): void
    {
        $this->seed();

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('مجمع لوزان');
        $response->assertSee('خدماتنا');
    }

    public function test_patient_can_book_appointment_with_doctor(): void
    {
        $this->seed();

        $branch = Branch::query()->first();
        $doctor = Doctor::query()->first();
        $doctor->branches()->syncWithoutDetaching([$branch->id]);

        $response = $this->post('/book', [
            'full_name' => 'محمد أحمد',
            'national_id' => '1234567890',
            'mobile' => '0500000000',
            'booking_type' => 'doctor',
            'doctor_id' => $doctor->id,
            'branch_id' => $branch->id,
            'appointment_date' => now()->addDay()->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'full_name' => 'محمد أحمد',
            'doctor_id' => $doctor->id,
            'branch_id' => $branch->id,
            'status' => Appointment::STATUS_PENDING,
        ]);
    }

    public function test_patient_can_book_appointment_with_specialty(): void
    {
        $this->seed();

        $branch = Branch::query()->first();
        $service = Service::query()->first();

        $response = $this->post('/book', [
            'full_name' => 'سارة علي',
            'national_id' => '9876543210',
            'mobile' => '0550000000',
            'booking_type' => 'specialty',
            'specialty' => $service->name,
            'branch_id' => $branch->id,
            'appointment_date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('appointments', [
            'full_name' => 'سارة علي',
            'specialty' => $service->name,
            'doctor_id' => null,
            'branch_id' => $branch->id,
            'status' => Appointment::STATUS_PENDING,
        ]);
    }

    public function test_admin_can_approve_appointment(): void
    {
        $this->seed();

        $admin = User::factory()->create(['is_admin' => true]);
        $branch = Branch::query()->first();

        $appointment = Appointment::query()->create([
            'full_name' => 'Test Patient',
            'national_id' => '1111111111',
            'mobile' => '0501111111',
            'specialty' => 'الطب العام',
            'branch_id' => $branch->id,
            'appointment_date' => now()->addDay(),
            'status' => Appointment::STATUS_PENDING,
        ]);

        $response = $this->actingAs($admin)->patch(route('admin.appointments.approve', $appointment));

        $response->assertRedirect();
        $this->assertEquals(Appointment::STATUS_APPROVED, $appointment->fresh()->status);
    }
}
