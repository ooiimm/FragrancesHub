<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────
        User::create([
            'name'     => 'Admin FragrancesHub',
            'email'    => 'admin@fragranceshub.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // ── Sample User ────────────────────────────────────
        User::create([
            'name'     => 'customer1',
            'email'    => 'user@fragranceshub.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
            'phone'    => '08123456789',
            'address'  => 'Jl. Contoh No. 123, Jakarta',
        ]);

        // ── Kategori ───────────────────────────────────────
        $categories = [
            ['name' => 'Parfum Pria',    'description' => 'Koleksi parfum eksklusif untuk pria modern'],
            ['name' => 'Parfum Wanita',  'description' => 'Koleksi parfum elegan untuk wanita'],
            ['name' => 'Parfum Unisex',  'description' => 'Parfum yang cocok untuk semua gender'],
            ['name' => 'Parfum Mewah',   'description' => 'Koleksi parfum premium dan eksklusif'],
            ['name' => 'Parfum Lokal',   'description' => 'Parfum berkualitas dari brand lokal Indonesia'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        // ── Produk ─────────────────────────────────────────
        $products = [
            [
                'category_id' => 1,
                'name'        => 'Sauvage Dior',
                'description' => 'Aroma maskulin dengan nuansa kayu cedar dan bergamot yang menyegarkan. Cocok untuk pria modern yang penuh percaya diri.',
                'price'       => 850000,
                'stock'       => 25,
            ],
            [
                'category_id' => 1,
                'name'        => 'Bleu de Chanel',
                'description' => 'Parfum woody aromatic yang memancarkan karakter pria kuat dan elegan. Perpaduan citrus dengan vetiver yang memukau.',
                'price'       => 920000,
                'stock'       => 18,
            ],
            [
                'category_id' => 2,
                'name'        => 'Chanel No. 5',
                'description' => 'Ikon parfum wanita sepanjang masa dengan aroma floral yang timeless dan mewah. Perpaduan ylang-ylang dan rose yang sempurna.',
                'price'       => 1200000,
                'stock'       => 15,
            ],
            [
                'category_id' => 2,
                'name'        => 'Miss Dior Blooming Bouquet',
                'description' => 'Aroma floral segar yang feminin dan romantis. Kombinasi peony, rose, dan white musks yang indah.',
                'price'       => 780000,
                'stock'       => 22,
            ],
            [
                'category_id' => 3,
                'name'        => 'CK One Calvin Klein',
                'description' => 'Parfum unisex ikonik dengan aroma citrus segar yang cocok untuk semua gender. Ringan dan menyegarkan.',
                'price'       => 450000,
                'stock'       => 30,
            ],
            [
                'category_id' => 4,
                'name'        => 'Tom Ford Black Orchid',
                'description' => 'Parfum mewah dengan aroma oriental yang gelap dan sensual. Kombinasi black truffle, ylang-ylang, dan bergamot.',
                'price'       => 2500000,
                'stock'       => 8,
            ],
            [
                'category_id' => 5,
                'name'        => 'Elsha 1889',
                'description' => 'Parfum lokal premium dengan aroma oriental woody yang khas Indonesia. Kualitas setara internasional.',
                'price'       => 250000,
                'stock'       => 40,
            ],
            [
                'category_id' => 5,
                'name'        => 'Tresno Joyo Parfum Jawa',
                'description' => 'Parfum lokal dengan aroma kembang setaman yang khas dan romantis. Terinspirasi dari tradisi Jawa yang kaya.',
                'price'       => 180000,
                'stock'       => 50,
            ],
        ];

        foreach ($products as $prod) {
            Product::create(array_merge($prod, [
                'slug'      => \Illuminate\Support\Str::slug($prod['name']) . '-' . uniqid(),
                'is_active' => true,
            ]));
        }
    }
}
