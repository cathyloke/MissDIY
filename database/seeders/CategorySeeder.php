<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            [
                'id' => uniqid(),
                'name' => 'Crafting Tools',
                'description' => 'A wide range of essential materials and decorative items to bring your creative ideas to life.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Painting & Drawing',
                'description' => 'High-quality sketching tools to help artists of all skill levels express their creativity.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Woodworking',
                'description' => 'Essential tools for furniture making and home projects.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Sewing and Fabric',
                'description' => 'Everything from sewing machines to accessories for fashion design and DIY textile projects.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Home Decoration',
                'description' => 'DIY kits, wallpapers, stickers, and decorative materials to personalize and enhance your living spaces.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
