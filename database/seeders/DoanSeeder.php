<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DoanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('doan')->insert([
            [
                'name_food' => 'Cơm trắng',
                'calories_per_100g' => 130.00,
                'image_url' => 'com_trang',
            ],
            [
                'name_food' => 'Thịt gà',
                'calories_per_100g' => 165.00,
                'image_url' => 'thit_ga',
            ],
            [
                'name_food' => 'Trứng luộc',
                'calories_per_100g' => 155.00,
                'image_url' => 'trung_luoc',
            ],
            [
                'name_food' => 'Rau luộc',
                'calories_per_100g' => 35.00,
                'image_url' => 'rau_luoc',
            ],
            [
                'name_food' => 'Cá hồi',
                'calories_per_100g' => 208.00,
                'image_url' => 'ca_hoi',
            ],
            [
                'name_food' => 'Thịt bò',
                'calories_per_100g' => 250.00,
                'image_url' => 'thit_bo',
            ],
            [
                'name_food' => 'Sữa chua',
                'calories_per_100g' => 60.00,
                'image_url' => 'sua_chua',
            ],
            [
                'name_food' => 'Chuối',
                'calories_per_100g' => 89.00,
                'image_url' => 'chuoi',
            ],
            [
                'name_food' => 'Táo',
                'calories_per_100g' => 52.00,
                'image_url' => 'tao',
            ],
            [
                'name_food' => 'Khoai lang',
                'calories_per_100g' => 86.00,
                'image_url' => 'khoai_lang',
            ],
            [
                'name_food' => 'Yến mạch',
                'calories_per_100g' => 389.00,
                'image_url' => 'yen_mach',
            ],
            [
                'name_food' => 'Sữa tươi không đường',
                'calories_per_100g' => 42.00,
                'image_url' => 'sua_tuoi_khong_duong',
            ],
            [
                'name_food' => 'Phô mai',
                'calories_per_100g' => 402.00,
                'image_url' => 'pho_mai',
            ],
            [
                'name_food' => 'Trà xanh',
                'calories_per_100g' => 1.00,
                'image_url' => 'tra_xanh',
            ],
            [
                'name_food' => 'Nước lọc',
                'calories_per_100g' => 0.00,
                'image_url' => 'nuoc_loc',
            ],
            [
                'name_food' => 'Bánh mì',
                'calories_per_100g' => 265.00,
                'image_url' => 'banh_my',
            ],
            [
                'name_food' => 'Bơ đậu phộng',
                'calories_per_100g' => 588.00,
                'image_url' => 'bo_dau_phong',
            ],
            [
                'name_food' => 'Hạt hạnh nhân',
                'calories_per_100g' => 576.00,
                'image_url' => 'hanh_nhan',
            ],
            [
                'name_food' => 'Đậu hũ',
                'calories_per_100g' => 76.00,
                'image_url' => 'dau_hu',
            ],
            [
                'name_food' => 'Bún tươi',
                'calories_per_100g' => 110.00,
                'image_url' => 'bun_tuoi',
            ],
        ]);
    }
}
