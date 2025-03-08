<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesVoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $voucherId = DB::table('voucher')->where('code', 'WELCOME10')->value('id');

        DB::table('sales_voucher')->insert([
            [
                'id' => uniqid(),
                'salesId' => 'salesAAAAA11111111111',
                'voucherId' => $voucherId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'salesId' => 'salesAAAAA22222222222',
                'voucherId' => $voucherId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
