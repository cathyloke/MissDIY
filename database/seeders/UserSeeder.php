<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            [
                'name' => 'Admin 1',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('admin123'),
                'address' => '123 Admin Street',
                'gender' => 'male',
                'type' => 'admin',
                'contact_number' => '0123456789',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Admin 2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('admin123'),
                'address' => '234 Admin Street',
                'gender' => 'female',
                'type' => 'admin',
                'contact_number' => '0129876543',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Cathy',
                'email' => 'cathy@gmail.com',
                'password' => Hash::make('cus123'),
                'address' => '345 Customer Road',
                'gender' => 'female',
                'type' => 'customer',
                'contact_number' => '0128765439',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Shirley',
                'email' => 'shirley@gmail.com',
                'password' => Hash::make('cus123'),
                'address' => '345 Customer Road',
                'gender' => 'female',
                'type' => 'customer',
                'contact_number' => '0127654398',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Joely',
                'email' => 'joely@gmail.com',
                'password' => Hash::make('cus123'),
                'address' => '345 Customer Road',
                'gender' => 'female',
                'type' => 'customer',
                'contact_number' => '0126543987',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'lsq',
                'email' => 'lsq@gmail.com',
                'password' => Hash::make('cus123'),
                'address' => '345 Customer Road',
                'gender' => 'female',
                'type' => 'customer',
                'contact_number' => '0125439876',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
