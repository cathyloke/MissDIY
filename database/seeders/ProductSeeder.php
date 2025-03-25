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
        $craftingId = DB::table('category')->where('name', 'Crafting Tools')->value('id');
        $paintAndDrawId = DB::table('category')->where('name', 'Painting & Drawing')->value('id');
        $woodworkingId = DB::table('category')->where('name', 'Woodworking')->value('id');
        $sewingId = DB::table('category')->where('name', 'Sewing and Fabric')->value('id');
        $homeDecoId = DB::table('category')->where('name', 'Home Decoration')->value('id');

        DB::table('product')->insert([
            [
                'id' => uniqid(),
                'name' => 'Origami Paper Set',
                'image' => 'products/ColorfulOrigamiPaperSet.jpeg',
                'price' => 9.99,
                'quantity' => 50,
                'categoryId' => $craftingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Multi-Purpose Craft Glue',
                'image' => 'products/Glue.jpeg',
                'price' => 12.00,
                'quantity' => 50,
                'categoryId' => $craftingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'DIY Scrapbook Kit',
                'image' => 'products/DIY-ScrapbookKit.jpeg',
                'price' => 25.40,
                'quantity' => 50,
                'categoryId' => $craftingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Acrylic Paint Set',
                'image' => 'products/AcrylicPaintSet.jpeg',
                'price' => 25.40,
                'quantity' => 50,
                'categoryId' => $paintAndDrawId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Sketchbook',
                'image' => 'products/Sketchbook.jpeg',
                'price' => 21.80,
                'quantity' => 50,
                'categoryId' => $paintAndDrawId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Artist Brush Set',
                'image' => 'products/ArtistPaintBrushSet.jpeg',
                'price' => 32.00,
                'quantity' => 50,
                'categoryId' => $paintAndDrawId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Mini Hand Saw',
                'image' => 'products/150mmJuniorHacksaw.jpeg',
                'price' => 7.30,
                'quantity' => 50,
                'categoryId' => $woodworkingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Electric Engraving Pen for Wood & Metal',
                'image' => 'products/EngravingPenSet.jpeg',
                'price' => 108.00,
                'quantity' => 50,
                'categoryId' => $woodworkingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'DIY Wooden Birdhouse Kit',
                'image' => 'products/DIY-BirdhouseWoodworkingKit.jpeg',
                'price' => 158.90,
                'quantity' => 50,
                'categoryId' => $woodworkingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Cotton Fabric Bundle',
                'image' => 'products/CottonFabricBundle.jpeg',
                'price' => 6.50,
                'quantity' => 50,
                'categoryId' => $sewingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Sewing Kit with Needles & Threads',
                'image' => 'products/SewingKit.jpeg',
                'price' => 52.00,
                'quantity' => 50,
                'categoryId' => $sewingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Quilting Ruler Set',
                'image' => 'products/QuiltingRulerSet.jpeg',
                'price' => 26.80,
                'quantity' => 50,
                'categoryId' => $sewingId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'Peel-and-Stick Wall Decals (150cm x 60cm)',
                'image' => 'products/Peel-and-StickWallDecals.jpeg',
                'price' => 80.80,
                'quantity' => 50,
                'categoryId' => $homeDecoId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'DIY Macrame Plant Hanger Kit',
                'image' => 'products/DIY-MacramePlantHangerKit.jpeg',
                'price' => 66.00,
                'quantity' => 50,
                'categoryId' => $homeDecoId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => uniqid(),
                'name' => 'LED String Lights',
                'image' => 'products/LED-StringLights.jpeg',
                'price' => 1.99,
                'quantity' => 50,
                'categoryId' => $homeDecoId,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
