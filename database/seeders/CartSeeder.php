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
        $userId = DB::table('users')->where('name', 'Cathy')->value('id');
        $user2Id = DB::table('users')->where('name', 'Shirley')->value('id');

        $glue = DB::table('product')->where('name', 'Multi-Purpose Craft Glue');
        $paint = DB::table('product')->where('name', 'Acrylic Paint Set');
        $diyBirdhouse = DB::table('product')->where('name', 'DIY Wooden Birdhouse Kit');

        DB::table('cart')->insert([
            [
                'id' => uniqid(),
                'userId' => $userId,
                'productId' => $glue->value('id'),
                'productImg' => $glue->value('image'),
                'productName' => $glue->value('name'),
                'productPrice' => $glue->value('price'),
                'productQty' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'userId' => $userId,
                'productId' => $paint->value('id'),
                'productImg' => $paint->value('image'),
                'productName' => $paint->value('name'),
                'productPrice' => $paint->value('price'),
                'productQty' => 3,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'userId' => $userId,
                'productId' => $diyBirdhouse->value('id'),
                'productImg' => $diyBirdhouse->value('image'),
                'productName' => $diyBirdhouse->value('name'),
                'productPrice' => $diyBirdhouse->value('price'),
                'productQty' => 2,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
