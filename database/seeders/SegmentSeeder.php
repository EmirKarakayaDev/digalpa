<?php

namespace Database\Seeders;

use App\Models\Segment;
use Illuminate\Database\Seeder;

class SegmentSeeder extends Seeder
{
    public function run(): void
    {
        $segments = [
            [
                'name'        => 'Doğal Taş',
                'slug'        => 'dogal-tas',
                'color_key'   => 'amber',
                'icon'        => 'heroicon-o-cube',
                'description' => 'Mermer, granit, traverten ve tüm doğal taş yüzeyler için koruma, temizlik ve bakım ürünleri.',
                'is_active'   => true,
                'sort_order'  => 1,
            ],
            [
                'name'        => 'İnşaat',
                'slug'        => 'insaat',
                'color_key'   => 'stone',
                'icon'        => 'heroicon-o-building-office',
                'description' => 'Yapıştırıcılar, derz dolgu malzemeleri, su yalıtımı ve yapı kimyasalları.',
                'is_active'   => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Marine',
                'slug'        => 'marine',
                'color_key'   => 'marine',
                'icon'        => 'heroicon-o-beaker',
                'description' => 'Deniz ortamı ve yüksek nem koşulları için özel formüle edilmiş koruyucu kimyasallar.',
                'is_active'   => true,
                'sort_order'  => 3,
            ],
        ];

        foreach ($segments as $data) {
            Segment::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
