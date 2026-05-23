<?php
// database/seeders/FlowerSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Flower;

class FlowerSeeder extends Seeder
{
    public function run(): void
    {
        $flowers = [
            ['slug' => 'anemone',    'name' => 'Anemone',    'meaning' => 'Anticipation & protection', 'price' => 32000, 'color_primary' => '#C9B3D9', 'color_secondary' => '#E8D5E8', 'sort_order' => 1,  'image_path' => '/images/flowers/anemonen.webp'],
            ['slug' => 'carnation',  'name' => 'Carnation',  'meaning' => 'Love & admiration',         'price' => 35000, 'color_primary' => '#F4B6C2', 'color_secondary' => '#FAD5DC', 'sort_order' => 2,  'image_path' => '/images/flowers/carnationn.webp'],
            ['slug' => 'daisy',      'name' => 'Daisy',      'meaning' => 'Innocence & purity',        'price' => 28000, 'color_primary' => '#FFFFFF', 'color_secondary' => '#FFF9C4', 'sort_order' => 3,  'image_path' => '/images/flowers/daisyn.webp'],
            ['slug' => 'rose',       'name' => 'Rose',       'meaning' => 'Deep love',                 'price' => 45000, 'color_primary' => '#F44336', 'color_secondary' => '#EF9A9A', 'sort_order' => 4,  'image_path' => '/images/flowers/rosen.webp'],
            ['slug' => 'sunflower',  'name' => 'Sunflower',  'meaning' => 'Adoration & loyalty',       'price' => 30000, 'color_primary' => '#FFF9C4', 'color_secondary' => '#FFE082', 'sort_order' => 5,  'image_path' => '/images/flowers/sunflowern.webp'],
            ['slug' => 'tulip',      'name' => 'Tulip',      'meaning' => 'Perfect love',              'price' => 38000, 'color_primary' => '#FCE4EC', 'color_secondary' => '#EF9A9A', 'sort_order' => 6,  'image_path' => '/images/flowers/tulipn.webp'],
            ['slug' => 'orchid',     'name' => 'Orchid',     'meaning' => 'Luxury & elegance',         'price' => 55000, 'color_primary' => '#EDE7F6', 'color_secondary' => '#CE93D8', 'sort_order' => 7,  'image_path' => '/images/flowers/orchidn.webp'],
            ['slug' => 'peony',      'name' => 'Peony',      'meaning' => 'Romance & prosperity',      'price' => 50000, 'color_primary' => '#F8BBD9', 'color_secondary' => '#F48FB1', 'sort_order' => 8,  'image_path' => '/images/flowers/peonyn.webp'],
            ['slug' => 'lily',       'name' => 'Lily',       'meaning' => 'Purity of heart',           'price' => 40000, 'color_primary' => '#E8F5E9', 'color_secondary' => '#A5D6A7', 'sort_order' => 9,  'image_path' => '/images/flowers/lilyns.webp'],
            ['slug' => 'ranunculus', 'name' => 'Ranunculus', 'meaning' => 'New beginnings',            'price' => 42000, 'color_primary' => '#FFF3E0', 'color_secondary' => '#FFCC80', 'sort_order' => 10, 'image_path' => '/images/flowers/ranunculusn.webp'],
        ];

        foreach ($flowers as $flower) {
            Flower::updateOrCreate(['slug' => $flower['slug']], array_merge($flower, ['is_active' => true]));
        }
    }
}
