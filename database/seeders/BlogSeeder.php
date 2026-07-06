<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Teknik Bilgi',  'slug' => 'teknik-bilgi',  'sort_order' => 1],
            ['name' => 'Uygulama',      'slug' => 'uygulama',      'sort_order' => 2],
            ['name' => 'Sektör Haberleri', 'slug' => 'sektor-haberleri', 'sort_order' => 3],
        ];

        foreach ($categories as $data) {
            BlogCategory::updateOrCreate(['slug' => $data['slug']], array_merge($data, ['is_active' => true]));
        }

        $teknik = BlogCategory::where('slug', 'teknik-bilgi')->first();
        $uygulama = BlogCategory::where('slug', 'uygulama')->first();

        $posts = [
            [
                'category'     => $teknik,
                'title'        => 'Doğal Taş Yüzeylerde Su Yalıtımı Nasıl Yapılır?',
                'excerpt'      => 'Mermer ve granit yüzeylerde uzun ömürlü su yalıtımı için doğru ürün seçimi ve uygulama adımları.',
                'published_at' => now()->subDays(5),
                'is_featured'  => true,
            ],
            [
                'category'     => $teknik,
                'title'        => 'pH Dengesinin Taş Koruma Ürünlerine Etkisi',
                'excerpt'      => 'Asit-baz dengesi, taş yüzeylerde kullanılan kimyasal ürünlerin performansını doğrudan etkiler.',
                'published_at' => now()->subDays(12),
                'is_featured'  => false,
            ],
            [
                'category'     => $uygulama,
                'title'        => 'Marine Ortamda Pas Önleme: Adım Adım Uygulama',
                'excerpt'      => 'Yüksek nem ve tuz içeren ortamlarda metal yüzeylerin korunması için uygulama rehberi.',
                'published_at' => now()->subDays(20),
                'is_featured'  => false,
            ],
        ];

        foreach ($posts as $data) {
            if (!$data['category']) continue;

            $slug = Str::slug($data['title']);

            BlogPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'blog_category_id' => $data['category']->id,
                    'title'            => $data['title'],
                    'slug'             => $slug,
                    'excerpt'          => $data['excerpt'],
                    'content'          => '<p>' . $data['excerpt'] . '</p><p>Detaylı teknik bilgi ve uygulama kılavuzu için ekibimizle iletişime geçin.</p>',
                    'author'           => 'Digalpa Teknik Ekip',
                    'published_at'     => $data['published_at'],
                    'is_active'        => true,
                ]
            );
        }
    }
}
