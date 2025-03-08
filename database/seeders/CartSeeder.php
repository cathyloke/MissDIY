<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = DB::table('user')->where('name', 'Cathy')->value('id');
        $user2Id = DB::table('user')->where('name', 'Shirley')->value('id');
        
        $productSmartphoneId = DB::table('product')->where('name', 'Smartphone')->value('id');
        $productTShirtId = DB::table('product')->where('name', 'T-shirt')->value('id');

        DB::table('cart')->insert([
            [
                'id' => uniqid(),
                'quantity' => 2,
                'userId' => $userId,
                'productId' => $productSmartphoneId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 6,
                'userId' => $userId,
                'productId' => $productTShirtId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 3,
                'userId' => $user2Id,
                'productId' => $productTShirtId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
