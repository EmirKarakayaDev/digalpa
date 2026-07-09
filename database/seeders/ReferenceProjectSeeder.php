<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ReferenceProject;
use App\Models\Segment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ReferenceProjectSeeder extends Seeder
{
    public function run(): void
    {
        $dogalTas = Segment::where('slug', 'dogal-tas')->first();
        $insaat   = Segment::where('slug', 'insaat')->first();
        $marine   = Segment::where('slug', 'marine')->first();

        $projects = [
            [
                'segment'     => $dogalTas,
                'title'       => 'İstanbul Büyük Saray Oteli Restorasyon',
                'client'      => 'Büyük Saray Oteli',
                'location'    => 'İstanbul',
                'year'        => 2023,
                'description' => 'Tarihi otelin mermer zeminleri ve cephesinde kapsamlı taş koruma ve restorasyon çalışması.',
                'is_featured' => true,
                'products'    => ['stoneguard-pro-100', 'cleanstone-ac'],
            ],
            [
                'segment'     => $insaat,
                'title'       => 'Ataşehir Rezidans Kompleksi Su Yalıtımı',
                'client'      => 'ABC İnşaat A.Ş.',
                'location'    => 'İstanbul',
                'year'        => 2024,
                'description' => '450 daireli rezidans projesinin bodrum katı ve teras alanlarında tam su yalıtım sistemi.',
                'is_featured' => true,
                'products'    => ['aquastop-2k', 'hydroflex-500'],
            ],
            [
                'segment'     => $marine,
                'title'       => 'Bodrum Marina Koruma Projesi',
                'client'      => 'Bodrum Marina İşletmesi',
                'location'    => 'Bodrum',
                'year'        => 2023,
                'description' => 'Marina iskelesi ve depolama alanlarında deniz koşullarına dayanıklı anti-pas ve kaplama uygulaması.',
                'is_featured' => true,
                'products'    => ['marinecoat-3000', 'ruststop-marine'],
            ],
            [
                'segment'     => $dogalTas,
                'title'       => 'Ankara AVM Granit Zemin Bakımı',
                'client'      => 'Varlık AVM',
                'location'    => 'Ankara',
                'year'        => 2024,
                'description' => '8.000 m² granit zemininin koruma ve parlatma uygulaması.',
                'is_featured' => false,
                'products'    => ['diapol-k', 'marblepol-hp'],
            ],
        ];

        foreach ($projects as $i => $data) {
            if (!$data['segment']) continue;

            $slug = Str::slug($data['title']);
            $productModels = Product::whereIn('slug', $data['products'])->get();

            $project = ReferenceProject::updateOrCreate(
                ['slug' => $slug],
                [
                    'segment_id'    => $data['segment']->id,
                    'title'         => $data['title'],
                    'slug'          => $slug,
                    'client'        => $data['client'],
                    'location'      => $data['location'],
                    'year'          => $data['year'],
                    'description'   => $data['description'],
                    'content'       => '<p>' . $data['description'] . '</p>',
                    // Gerçek ürün ilişkisi kurulamayan durumlar için yedek
                    // serbest metin (Brief §09: sidebar linkli olmalı — bkz. products() pivotu).
                    'used_products' => $productModels->pluck('name')->all(),
                    'is_active'     => true,
                    'is_featured'   => $data['is_featured'],
                    'sort_order'    => $i + 1,
                ]
            );

            $project->products()->sync(
                $productModels->values()->mapWithKeys(fn ($p, $i) => [$p->id => ['sort_order' => $i]])
            );
        }
    }
}
