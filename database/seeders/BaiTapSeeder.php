<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiTapSeeder extends Seeder
{
    public function run()
    {
        DB::table('baitap')->insert([
            // --- Cardio ---
            [
                'name_exercise' => 'Chạy bộ ngoài trời',
                'mets' => 7.5,
                'image_url' => '/storage/images/chaybo.jpg',
            ],
            [
                'name_exercise' => 'Đạp xe',
                'mets' => 6.8,
                'image_url' => '/storage/images/dapxe.jpg',
            ],
            [
                'name_exercise' => 'Nhảy dây',
                'mets' => 12.3,
                'image_url' => '/storage/images/nhayday.jpg',
            ],
            [
                'name_exercise' => 'Bơi lội',
                'mets' => 8.0,
                'image_url' => '/storage/images/boiloi.jpg',
            ],
            [
                'name_exercise' => 'Leo cầu thang',
                'mets' => 9.0,
                'image_url' => '/storage/images/leocauthang.jpg',
            ],

            // --- Gym ---
            [
                'name_exercise' => 'Squat',
                'mets' => 5.0,
                'image_url' => '/storage/images/squat.jpg',
            ],
            [
                'name_exercise' => 'Deadlift',
                'mets' => 6.0,
                'image_url' => '/storage/images/deadlift.jpg',
            ],
            [
                'name_exercise' => 'Bench Press',
                'mets' => 5.5,
                'image_url' => '/storage/images/benchpress.jpg',
            ],
            [
                'name_exercise' => 'Plank',
                'mets' => 3.3,
                'image_url' => '/storage/images/plank.jpg',
            ],
            [
                'name_exercise' => 'Lunges',
                'mets' => 4.5,
                'image_url' => '/storage/images/lunges.jpg',
            ],
        ]);
    }
}
