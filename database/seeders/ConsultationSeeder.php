<?php

namespace Database\Seeders;

use App\Models\Consultation;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConsultationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $consultationValue = [
            // 1st Year
            [
                'admin_admin_id' => 1,
                'title' => 'BSIT 1st Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSCS 1st Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSHM 1st Year',
                'status' => 'Upcoming',
            ],

            // 2nd Year
            [
                'admin_admin_id' => 1,
                'title' => 'BSIT 2nd Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSCS 2nd Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSHM 2nd Year',
                'status' => 'Upcoming',
            ],

            // 3rd Year
            [
                'admin_admin_id' => 1,
                'title' => 'BSIT 3rd Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSCS 3rd Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSHM 3rd Year',
                'status' => 'Upcoming',
            ],

            // 4th Year
            [
                'admin_admin_id' => 1,
                'title' => 'BSIT 4th Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSCS 4th Year',
                'status' => 'Upcoming',
            ],
            [
                'admin_admin_id' => 1,
                'title' => 'BSHM 4th Year',
                'status' => 'Upcoming',
            ],
        ];

        foreach ($consultationValue as $item) {
            Consultation::create($item);
        }
    }
}
