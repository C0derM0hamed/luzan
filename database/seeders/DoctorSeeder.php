<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctors = [
            [
                'name' => 'د. أحمد محمد',
                'specialty' => 'الطب العام',
                'working_hours' => 'السبت - الخميس: 9 ص - 5 م',
                'sort_order' => 1,
                'photo' => 'doctors/doctor2.png'
            ],
            [
                'name' => 'د. سارة العتيبي',
                'specialty' => 'النساء والولادة',
                'working_hours' => 'السبت - الأربعاء: 10 ص - 4 م',
                'sort_order' => 2,
                'photo' => 'doctors/doctor3.png'
            ],
            [
                'name' => 'د. خالد الغامدي',
                'specialty' => 'الأطفال',
                'working_hours' => 'الأحد - الخميس: 9 ص - 3 م',
                'sort_order' => 3,
                'photo' => 'doctors/doctor4.png'
            ],
            [
                'name' => 'د. فهد الزهراني',
                'specialty' => 'الأسنان',
                'working_hours' => 'السبت - الخميس: 8 ص - 8 م',
                'sort_order' => 4,
                'photo' => 'doctors/doctor5.png'
            ],
            [
                'name' => 'د. نورة القحطاني',
                'specialty' => 'الجلدية والتجميل والليزر',
                'working_hours' => 'الأحد - الخميس: 11 ص - 7 م',
                'sort_order' => 5,
                'photo' => 'doctors/doctor6.png'
            ],
        ];

        foreach ($doctors as $doctor) {
            Doctor::query()->updateOrCreate(
                ['name' => $doctor['name']],
                [
                    'specialty' => $doctor['specialty'],
                    'working_hours' => $doctor['working_hours'],
                    'photo' => $doctor['photo'],
                    'is_active' => true,
                    'sort_order' => $doctor['sort_order'],
                ]
            );
        }
    }
}
