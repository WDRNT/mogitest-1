<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'tony',
            'email' => 'aho@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'sony',
            'email' => 'sony@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'kony',
            'email' => 'kony@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'ony',
            'email' => 'ony@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'ny',
            'email' => 'ny@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'to',
            'email' => 'to@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'tonys',
            'email' => 'tonys@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'toney',
            'email' => 'toney@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'go',
            'email' => 'go@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'gos',
            'email' => 'gos@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);

        $param = [
            'name' => 'goss',
            'email' => 'goss@ahomail.com',
            'password' => Hash::make('0000'),
        ];
        DB::table('users')->insert($param);
    }
}
