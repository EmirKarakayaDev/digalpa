<?php

namespace Database\Seeders;

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
            ],
            [
                'segment'     => $insaat,
                'title'       => 'Ataşehir Rezidans Kompleksi Su Yalıtımı',
                'client'      => 'ABC İnşaat A.Ş.',
                'location'    => 'İstanbul',
                'year'        => 2024,
                'description' => '450 daireli rezidans projesinin bodrum katı ve teras alanlarında tam su yalıtım sistemi.',
                'is_featured' => true,
            ],
            [
                'segment'     => $marine,
                'title'       => 'Bodrum Marina Koruma Projesi',
                'client'      => 'Bodrum Marina İşletmesi',
                'location'    => 'Bodrum',
                'year'        => 2023,
                'description' => 'Marina iskelesi ve depolama alanlarında deniz koşullarına dayanıklı anti-pas ve kaplama uygulaması.',
                'is_featured' => true,
            ],
            [
                'segment'     => $dogalTas,
                'title'       => 'Ankara AVM Granit Zemin Bakımı',
                'client'      => 'Varlık AVM',
                'location'    => 'Ankara',
                'year'        => 2024,
                'description' => '8.000 m² granit zemininin koruma ve parlatma uygulaması.',
                'is_featured' => false,
            ],
        ];

        foreach ($projects as $i => $data) {
            if (!$data['segment']) continue;

            $slug = Str::slug($data['title']);

            ReferenceProject::updateOrCreate(
                ['slug' => $slug],
                [
                    'segment_id'   => $data['segment']->id,
                    'title'        => $data['title'],
                    'slug'         => $slug,
                    'client'       => $data['client'],
                    'location'     => $data['location'],
                    'year'         => $data['year'],
                    'description'  => $data['description'],
                    'content'      => '<p>' . $data['description'] . '</p>',
                    'used_products' => ['StoneGuard Pro 100', 'CleanStone AC'],
                    'is_active'    => true,
                    'is_featured'  => $data['is_featured'],
                    'sort_order'   => $i + 1,
                ]
            );
        }
    }
}
