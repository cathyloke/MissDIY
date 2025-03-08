<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productSmartphoneId = DB::table('product')->where('name', 'Smartphone')->value('id');
        $productTShirtId = DB::table('product')->where('name', 'T-shirt')->value('id');
        $userId = DB::table('user')->where('name', 'Cathy')->value('id');
        $user2Id = DB::table('user')->where('name', 'Shirley')->value('id');
        
        DB::table('sales_details')->insert([
            [
                'id' => uniqid(),
                'quantity' => 2,
                'productId' => $productTShirtId,
                'salesId' => 'salesAAAAA11111111111',
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 1,
                'productId' => $productSmartphoneId,
                'salesId' => 'salesAAAAA11111111111',
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 2,
                'productId' => $productTShirtId,
                'salesId' => 'salesAAAAA22222222222',
                'userId' => $user2Id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 5,
                'productId' => $productSmartphoneId,
                'salesId' => 'salesAAAAA22222222222',
                'userId' => $user2Id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
