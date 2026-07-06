<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Segment;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $dogalTas = Segment::where('slug', 'dogal-tas')->first();
        $insaat   = Segment::where('slug', 'insaat')->first();
        $marine   = Segment::where('slug', 'marine')->first();

        $categories = [
            // Doğal Taş
            ['segment' => $dogalTas, 'name' => 'Taş Koruyucular',    'slug' => 'tas-koruyucular',    'sort_order' => 1],
            ['segment' => $dogalTas, 'name' => 'Taş Temizleyiciler', 'slug' => 'tas-temizleyiciler', 'sort_order' => 2],
            ['segment' => $dogalTas, 'name' => 'Cila & Parlatıcılar','slug' => 'cila-parlaticillar', 'sort_order' => 3],
            ['segment' => $dogalTas, 'name' => 'Derz Ürünleri',      'slug' => 'dogal-tas-derz',     'sort_order' => 4],

            // İnşaat
            ['segment' => $insaat, 'name' => 'Su Yalıtımı',          'slug' => 'su-yalitimi',        'sort_order' => 1],
            ['segment' => $insaat, 'name' => 'Yapıştırıcılar',       'slug' => 'yapistiricilar',     'sort_order' => 2],
            ['segment' => $insaat, 'name' => 'Sıva & Şap',           'slug' => 'siva-sap',           'sort_order' => 3],
            ['segment' => $insaat, 'name' => 'Derz & Fugalar',       'slug' => 'insaat-derz',        'sort_order' => 4],

            // Marine
            ['segment' => $marine, 'name' => 'Tekne & Yüzey Koruma', 'slug' => 'tekne-yuzey-koruma', 'sort_order' => 1],
            ['segment' => $marine, 'name' => 'Anti-Pas',             'slug' => 'anti-pas',           'sort_order' => 2],
            ['segment' => $marine, 'name' => 'Boya & Vernik',        'slug' => 'marine-boya',        'sort_order' => 3],
        ];

        foreach ($categories as $data) {
            $segment = $data['segment'];
            if (!$segment) continue;

            Category::updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'segment_id'  => $segment->id,
                    'parent_id'   => null,
                    'name'        => $data['name'],
                    'slug'        => $data['slug'],
                    'is_active'   => true,
                    'sort_order'  => $data['sort_order'],
                ]
            );
        }
    }
}
