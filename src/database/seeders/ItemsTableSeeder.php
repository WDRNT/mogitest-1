<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'name' => '腕時計',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
            'brand' => 'Rolax',
            'condition_id' => '1',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => '15000',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'name' => 'HDD',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
            'brand' => '西芝',
            'condition_id' => '2',
            'description' => '高速で信頼性の高いハードディスク',
            'price' => '5000',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 1,
            'name' => '玉ねぎ3束',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
            'brand' => 'なし',
            'condition_id' => '3',
            'description' => '新鮮な玉ねぎ3束のセット',
            'price' => '300',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 2,
            'name' => '革靴',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
            'brand' => '',
            'condition_id' => '4',
            'description' => 'クラシックなデザインの革靴',
            'price' => '4000',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 3,
            'name' => 'ノートPC',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
            'brand' => '',
            'condition_id' => '1',
            'description' => '高性能なノートパソコン',
            'price' => '45000',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 4,
            'name' => 'マイク',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
            'brand' => 'なし',
            'condition_id' => '2',
            'description' => '高音質のレコーディング用マイク',
            'price' => '8000',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 5,
            'name' => 'ショルダーバッグ',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
            'brand' => '',
            'condition_id' => '3',
            'description' => 'おしゃれなショルダーバッグ',
            'price' => '3500',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 5,
            'name' => 'タンブラー',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
            'brand' => '',
            'condition_id' => '4',
            'description' => '使いやすいタンブラー',
            'price' => '500',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 6,
            'name' => 'コーヒーミル',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
            'brand' => 'Starbacks',
            'condition_id' => '1',
            'description' => '手動のコーヒーミル',
            'price' => '4000',
            'status' => '0',
        ];
        DB::table('items')->insert($param);

        $param = [
            'user_id' => 7,
            'name' => 'メイクセット',
            'image' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
            'brand' => '',
            'condition_id' => '2',
            'description' => '便利なメイクアップセット',
            'price' => '2500',
            'status' => '0',
        ];
        DB::table('items')->insert($param);
    }
}
