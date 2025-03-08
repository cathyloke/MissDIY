<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesSeeder extends Seeder
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
        
        DB::table('sales')->insert([
            [
                'id' => 'salesAAAAA11111111111',
                'date' => Carbon::now(),
                'totalAmount' => 150.00,
                'netTotalAmount' => 140.00,
                'status' => 'pending',
                'userId' => $userId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 'salesAAAAA22222222222',
                'date' => Carbon::now()->subDays(3),
                'totalAmount' => 75.00,
                'netTotalAmount' => 65.00,
                'status' => 'completed',
                'userId' => $user2Id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
