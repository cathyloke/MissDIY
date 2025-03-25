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
        
        $glueId = DB::table('product')->where('name', 'Multi-Purpose Craft Glue')->value('id');
        $paintId = DB::table('product')->where('name', 'Acrylic Paint Set')->value('id');
        $diyBirdhouseId = DB::table('product')->where('name', 'DIY Wooden Birdhouse Kit')->value('id');

        DB::table('cart')->insert([
            [
                'id' => uniqid(),
                'quantity' => 2,
                'userId' => $userId,
                'productId' => $glueId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 6,
                'userId' => $userId,
                'productId' => $paintId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'quantity' => 3,
                'userId' => $user2Id,
                'productId' => $diyBirdhouseId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
