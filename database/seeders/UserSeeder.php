<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 0,
            'gender' => 1,
            'information' => 'handsome and pretty',
            'join_company_date' => date('Y-m-d g:i:s', strtotime('2021-11-13 10:21:01')),
        ]);
    }
}
