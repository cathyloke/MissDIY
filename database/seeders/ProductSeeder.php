<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $electronicsId = DB::table('category')->where('name', 'Electronics')->value('id');
        $clothingId = DB::table('category')->where('name', 'Clothing')->value('id');

        DB::table('product')->insert([
            [
                'id' => uniqid(),
                'name' => 'Smartphone',
                'image' => 'https://cdn.pixabay.com/photo/2017/04/03/15/52/mobile-phone-2198770_1280.png',
                'price' => 599.99,
                'quantity' => 50,
                'categoryId' => $electronicsId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Laptop',
                'image' => 'https://cdn.pixabay.com/photo/2024/01/10/16/21/laptop-8499942_1280.jpg',
                'price' => 999.99,
                'quantity' => 30,
                'categoryId' => $electronicsId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'T-shirt',
                'image' => 'https://cdn.pixabay.com/photo/2017/05/23/10/53/t-shirt-design-2336850_1280.jpg',
                'price' => 19.99,
                'quantity' => 100,
                'categoryId' => $clothingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
