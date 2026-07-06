<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $fakeProducts = [
            // Doğal Taş - Taş Koruyucular
            ['name' => 'StoneGuard Pro 100', 'category' => 'tas-koruyucular', 'coverage_min' => 8, 'coverage_max' => 12],
            ['name' => 'StoneGuard Ultra 200', 'category' => 'tas-koruyucular', 'coverage_min' => 10, 'coverage_max' => 15],
            ['name' => 'MarbleShield 50', 'category' => 'tas-koruyucular', 'coverage_min' => 6, 'coverage_max' => 10],

            // Doğal Taş - Temizleyiciler
            ['name' => 'CleanStone AC', 'category' => 'tas-temizleyiciler', 'coverage_min' => 20, 'coverage_max' => 30],
            ['name' => 'BioCleaner Plus', 'category' => 'tas-temizleyiciler', 'coverage_min' => 15, 'coverage_max' => 25],

            // Doğal Taş - Cila
            ['name' => 'DiaPol K', 'category' => 'cila-parlaticillar', 'coverage_min' => 5, 'coverage_max' => 8],
            ['name' => 'MarblePol HP', 'category' => 'cila-parlaticillar', 'coverage_min' => 4, 'coverage_max' => 7],

            // İnşaat - Su Yalıtımı
            ['name' => 'AquaStop 2K', 'category' => 'su-yalitimi', 'coverage_min' => 1.5, 'coverage_max' => 2],
            ['name' => 'HydroFlex 500', 'category' => 'su-yalitimi', 'coverage_min' => 1.2, 'coverage_max' => 1.8],
            ['name' => 'CrystalSeal WB', 'category' => 'su-yalitimi', 'coverage_min' => 2, 'coverage_max' => 3],

            // İnşaat - Yapıştırıcılar
            ['name' => 'TileFix Premium', 'category' => 'yapistiricilar', 'coverage_min' => 3, 'coverage_max' => 5],
            ['name' => 'StoneAdhesive Pro', 'category' => 'yapistiricilar', 'coverage_min' => 2.5, 'coverage_max' => 4],

            // Marine - Tekne Koruma
            ['name' => 'MarineCoat 3000', 'category' => 'tekne-yuzey-koruma', 'coverage_min' => 8, 'coverage_max' => 12],
            ['name' => 'OceanShield UV', 'category' => 'tekne-yuzey-koruma', 'coverage_min' => 10, 'coverage_max' => 14],

            // Marine - Anti-Pas
            ['name' => 'RustStop Marine', 'category' => 'anti-pas', 'coverage_min' => 5, 'coverage_max' => 8],
            ['name' => 'IronGuard 500', 'category' => 'anti-pas', 'coverage_min' => 6, 'coverage_max' => 9],
        ];

        foreach ($fakeProducts as $i => $data) {
            $category = Category::where('slug', $data['category'])->first();
            if (!$category) continue;

            $product = Product::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'name'              => $data['name'],
                    'slug'              => Str::slug($data['name']),
                    'short_description' => 'Yüksek performanslı, profesyonel kullanıma uygun formül.',
                    'description'       => '<p>Bu ürün, ' . $category->name . ' kategorisinde profesyonel uygulamalar için geliştirilmiştir. Uzun ömürlü koruma ve kolay uygulama özellikleriyle öne çıkar.</p>',
                    'technical_specs'   => [
                        ['label' => 'Baz',          'value' => 'Su Bazlı'],
                        ['label' => 'Renk',         'value' => 'Şeffaf'],
                        ['label' => 'pH',           'value' => '7.0 – 8.0'],
                        ['label' => 'Kuruma Süresi','value' => '2 – 4 saat (20°C)'],
                    ],
                    'package_sizes'     => ['1 L', '5 L', '20 L'],
                    'coverage_min'      => $data['coverage_min'],
                    'coverage_max'      => $data['coverage_max'],
                    'coverage_unit'     => 'm²/L',
                    'is_active'         => true,
                    'is_featured'       => $i < 4,
                    'sort_order'        => $i + 1,
                ]
            );

            $product->categories()->syncWithoutDetaching([$category->id]);
        }
    }
}
