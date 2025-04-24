<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('voucher')->insert([
            [
                'id' => uniqid(),
                'code' => 'WELCOME10',
                'discount' => 10.00,
                'type' => 'percentage',
                'minimumSpend' => 50.00,
                'expiration_date' => Carbon::now()->addDays(30),
                'validity' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'code' => 'FIXED50',
                'discount' => 50.00,
                'type' => 'fixed',
                'minimumSpend' => 200.00,
                'expiration_date' => Carbon::now()->addDays(60),
                'validity' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'code' => 'SUMMERSALE',
                'discount' => 15.00,
                'type' => 'percentage',
                'minimumSpend' => 100.00,
                'expiration_date' => Carbon::now()->addDays(90),
                'validity' => 'inactive',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
