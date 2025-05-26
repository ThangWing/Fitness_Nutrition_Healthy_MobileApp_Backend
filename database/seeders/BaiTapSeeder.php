<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaiTapSeeder extends Seeder
{
    public function run()
    {
        DB::table('baitap')->insert([
            [
                'name_exercise' => 'Chạy bộ ngoài trời',
                'mets' => 7.5,
                'image_url' => 'chaybo',   // tên ảnh drawable
            ],
            [
                'name_exercise' => 'Đạp xe',
                'mets' => 6.8,
                'image_url' => 'dapxe',
            ],
            [
                'name_exercise' => 'Nhảy dây',
                'mets' => 12.3,
                'image_url' => 'nhayday',
            ],
            [
                'name_exercise' => 'Bơi lội',
                'mets' => 8.0,
                'image_url' => 'boiloi',
            ],
            [
                'name_exercise' => 'Leo cầu thang',
                'mets' => 9.0,
                'image_url' => 'leocauthang',
            ],

            [
                'name_exercise' => 'Squat',
                'mets' => 5.0,
                'image_url' => 'squat',
            ],
            [
                'name_exercise' => 'Deadlift',
                'mets' => 6.0,
                'image_url' => 'deadlift',
            ],
            [
                'name_exercise' => 'Bench Press',
                'mets' => 5.5,
                'image_url' => 'benchpress',
            ],
            [
                'name_exercise' => 'Plank',
                'mets' => 3.3,
                'image_url' => 'plank',
            ],
            [
                'name_exercise' => 'Lunges',
                'mets' => 4.5,
                'image_url' => 'lunges',
            ],
        ]);
    }
}
