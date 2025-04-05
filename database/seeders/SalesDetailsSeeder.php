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
        $glueId = DB::table('product')->where('name', 'Multi-Purpose Craft Glue')->value('id');
        $paintId = DB::table('product')->where('name', 'Acrylic Paint Set')->value('id');
        $diyBirdhouseId = DB::table('product')->where('name', 'DIY Wooden Birdhouse Kit')->value('id');
        $userId = DB::table('users')->where('name', 'Cathy')->value('id');
        $user2Id = DB::table('users')->where('name', 'Shirley')->value('id');
        
        DB::table('sales_details')->insert([
            [
                'id' => uniqid(),
                'quantity' => 2,
                'productId' => $glueId,
                'salesId' => 'salesAAAAA11111111111',
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 1,
                'productId' => $paintId,
                'salesId' => 'salesAAAAA11111111111',
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 2,
                'productId' => $diyBirdhouseId,
                'salesId' => 'salesAAAAA22222222222',
                'userId' => $user2Id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 5,
                'productId' => $glueId,
                'salesId' => 'salesAAAAA22222222222',
                'userId' => $user2Id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
