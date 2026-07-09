<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Product;
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

        $teknik   = BlogCategory::where('slug', 'teknik-bilgi')->first();
        $uygulama = BlogCategory::where('slug', 'uygulama')->first();
        $sektor   = BlogCategory::where('slug', 'sektor-haberleri')->first();

        $posts = [
            // Doğal Taş rehberi
            [
                'category'     => $teknik,
                'title'        => 'Doğal Taş Yüzeylerde Su Yalıtımı Nasıl Yapılır?',
                'excerpt'      => 'Mermer ve granit yüzeylerde uzun ömürlü su yalıtımı için doğru ürün seçimi ve uygulama adımları.',
                'content'      => '<p>Mermer ve granit gibi doğal taşlar gözenekli yapıları nedeniyle suyu ve içindeki mineralleri emer; zamanla lekelenme, donma-çözülme çatlakları ve renk kaybı ortaya çıkar. Doğru emprenye uygulaması bu sorunların önüne geçer.</p><h2>Yüzey Hazırlığı</h2><p>Uygulamadan önce yüzey iyice kurutulmalı, toz ve gevşek parçacıklardan arındırılmalıdır. Nemli veya kirli bir zemine yapılan emprenye, ürünün taşa nüfuz etmesini engeller ve performansı düşürür.</p><h2>Ürün Seçimi</h2><p>Su bazlı emprenye ürünleri iç mekan ve az trafikli alanlar için, çözücü bazlı ürünler ise dış mekan ve yüksek performans beklenen zeminler için tercih edilir. Taşın gözenek yapısına göre doğru ürün seçimi, kalıcılığı doğrudan etkiler.</p><h2>Uygulama ve Kürlenme Süresi</h2><p>Ürün ince ve eşit bir tabaka halinde sürülmeli, taşın fazla emdiği bölgeler varsa ikinci kat uygulanmalıdır. Tam kürlenme genellikle 24-48 saat sürer; bu süre boyunca yüzey su ile temas ettirilmemelidir.</p>',
                'published_at' => now()->subDays(5),
                'author'       => 'Digalpa Teknik Ekip',
                'products'     => ['stoneguard-pro-100', 'marbleshield-50'],
            ],
            [
                'category'     => $teknik,
                'title'        => 'pH Dengesinin Taş Koruma Ürünlerine Etkisi',
                'excerpt'      => 'Asit-baz dengesi, taş yüzeylerde kullanılan kimyasal ürünlerin performansını doğrudan etkiler.',
                'content'      => '<p>Doğal taş temizliğinde kullanılan ürünlerin pH değeri, taşın yüzeyine ve önceden uygulanmış koruma katmanına zarar verebilir ya da tam tersi koruyabilir.</p><h2>Asidik Ürünlerin Riski</h2><p>Mermer ve traverten gibi kalker bazlı taşlar asidik temizleyicilere karşı hassastır; pH 5 altındaki ürünler yüzeyde donuklaşma ve leke bırakabilir.</p><h2>Nötr pH Neden Önemli</h2><p>pH 6-8 aralığındaki nötr temizleyiciler, hem taşın parlaklığını korur hem de önceden uygulanmış emprenye katmanını bozmaz — bu yüzden düzenli bakımda her zaman nötr ürün tercih edilmelidir.</p>',
                'published_at' => now()->subDays(12),
                'author'       => 'Digalpa Teknik Ekip',
                'products'     => ['cleanstone-ac', 'biocleaner-plus'],
            ],
            // Marine rehberi
            [
                'category'     => $uygulama,
                'title'        => 'Marine Ortamda Pas Önleme: Adım Adım Uygulama',
                'excerpt'      => 'Yüksek nem ve tuz içeren ortamlarda metal yüzeylerin korunması için uygulama rehberi.',
                'content'      => '<p>Deniz ortamında metal yüzeyler, tuzlu su ve yüksek nem nedeniyle kara ortamına göre çok daha hızlı korozyona uğrar. Doğru koruma sistemi ömrü kat kat uzatır.</p><h2>Yüzey Hazırlığı</h2><p>Mevcut pas ve gevşek boya tabakaları tamamen temizlenmeli, yüzey yağdan arındırılmalıdır. Hazırlık aşaması atlanırsa en kaliteli ürün bile kısa sürede kalkar.</p><h2>Astar ve Son Kat Uygulaması</h2><p>Pas önleyici astar ince ve eşit uygulanmalı, üzerine üretici talimatlarındaki bekleme süresine uyularak koruyucu son kat sürülmelidir. Gövde ve güverte gibi farklı bölgeler farklı aşınma seviyelerine sahiptir, buna göre kat sayısı artırılabilir.</p><h2>Bakım Periyodu</h2><p>Tuzlu su ile sürekli temas eden yüzeylerde yıllık kontrol ve gerekirse rötuş önerilir.</p>',
                'published_at' => now()->subDays(20),
                'author'       => 'Digalpa Teknik Ekip',
                'products'     => ['marinecoat-3000', 'ruststop-marine'],
            ],
            // İnşaat rehberi (Brief §07: 3 segmentten 1'er rehber)
            [
                'category'     => $uygulama,
                'title'        => 'Teras ve Temel Su Yalıtımında Doğru Ürün Seçimi: Adım Adım Uygulama',
                'excerpt'      => 'Çatı, teras ve temel bölgelerinde kalıcı su yalıtımı için tek bileşenli ve iki bileşenli ürünler arasında doğru seçim ve uygulama adımları.',
                'content'      => '<p>Su yalıtımı hatası, bir yapıda en pahalıya mal olan sorunlardan biridir — çünkü genellikle yıllar sonra, iç mekân hasarı olarak ortaya çıkar. Bölgeye uygun ürün ve doğru uygulama bu riski ortadan kaldırır.</p><h2>Bölgeye Göre Ürün Seçimi</h2><p>Temel ve bodrum gibi sürekli neme maruz kalan, hareket riski düşük yüzeylerde iki bileşenli çimento esaslı sistemler tercih edilir. Çatı ve teras gibi hareket payı gereken, UV\'ye açık yüzeylerde ise esnek, tek bileşenli poliüretan esaslı sistemler daha uzun ömürlü sonuç verir.</p><h2>Uygulama Adımları</h2><p>Yüzey önce yapısal olarak sağlam ve temiz hale getirilir, köşe ve detaylar (drenaj ağzı, duvar birleşimi) fitil bantla desteklenir. Ürün en az iki kat halinde, çapraz yönlerde uygulanır — tek kat uygulama membran sürekliliğini garanti etmez.</p><h2>Kürlenme ve Test</h2><p>Tam kürlenme sonrası su tutma testi yapılmadan üzeri kapatılmamalıdır; bu adım, gizli bir uygulama hatasının inşaat bittikten sonra ortaya çıkmasını önler.</p>',
                'published_at' => now()->subDays(3),
                'author'       => 'Digalpa Teknik Ekip',
                'products'     => ['aquastop-2k', 'hydroflex-500'],
            ],
            // Ürün karşılaştırması
            [
                'category'     => $teknik,
                'title'        => 'Tek Bileşenli mi İki Bileşenli mi? Su Yalıtım Ürünlerinde Doğru Seçim',
                'excerpt'      => 'AquaStop 2K ve HydroFlex 500 örneğinde tek ve iki bileşenli su yalıtım sistemlerinin artıları, eksileri ve doğru kullanım alanları.',
                'content'      => '<p>Su yalıtım ürünü seçerken en sık karşılaşılan soru budur: tek bileşenli mi, iki bileşenli mi? Cevap uygulamanın yapıldığı yüzeye ve maruz kalacağı harekete göre değişir.</p><h2>İki Bileşenli Sistemler (örn. AquaStop 2K)</h2><p>Toz ve sıvı bileşenin şantiyede karıştırılmasıyla hazırlanır. Yüksek mekanik dayanım ve kimyasal direnç sunar; temel, bodrum ve su deposu gibi hareketsiz, sürekli ıslak kalan yüzeylerde ilk tercihtir. Dezavantajı karışım oranına bağımlılık ve daha kısa açıkta bekleme (pot-life) süresidir.</p><h2>Tek Bileşenli Sistemler (örn. HydroFlex 500)</h2><p>Kutudan çıktığı gibi kullanılır, karışım hatası riski yoktur. Yüksek esnekliği sayesinde çatlak köprüleme kapasitesi daha yüksektir — bu da onu çatı, teras ve hareket payı olan yüzeyler için uygun kılar.</p><h2>Karar Tablosu</h2><p>Kısacası: yüzey hareketsiz ve sürekli ıslaksa iki bileşenli, yüzey hareketli ve hava koşullarına açıksa tek bileşenli sistem tercih edilmelidir. Emin değilseniz teknik ekibimizden uygulama öncesi görüş almanızı öneririz.</p>',
                'published_at' => now()->subDays(8),
                'author'       => 'Digalpa Teknik Ekip',
                'products'     => ['aquastop-2k', 'hydroflex-500'],
            ],
            // SSS
            [
                'category'     => $teknik,
                'title'        => 'Doğal Taş Bakımı Hakkında En Çok Sorulan Sorular',
                'excerpt'      => 'Emprenye ne sıklıkla yenilenmeli, hangi temizleyici hangi taşa uygun? Doğal taş bakımında en sık sorulan sorulara kısa ve net cevaplar.',
                'content'      => '<p>Doğal taş bakımıyla ilgili müşterilerimizden en sık aldığımız soruları bir araya getirdik.</p><h2>Emprenye ne sıklıkla yenilenmeli?</h2><p>Dış mekân ve yoğun trafikli iç mekân zeminlerinde yılda bir, az kullanılan iç mekânlarda 2-3 yılda bir yenileme genellikle yeterlidir. Su damlacıklarının artık taşa nüfuz etmeyip yüzeyde boncuklanması, emprenyenin hâlâ etkili olduğunun işaretidir.</p><h2>Her taş için aynı temizleyici kullanılabilir mi?</h2><p>Hayır. Mermer ve traverten gibi kalker bazlı taşlar asidik ürünlerden zarar görür; granit gibi daha dayanıklı taşlarda bile uzun vadede nötr pH\'lı ürünler tercih edilmelidir.</p><h2>Lekeler nasıl önlenir?</h2><p>Yağ, kahve ve şarap gibi sıvılar döküldüğünde hemen silinmeli, kurumaya bırakılmamalıdır. Düzenli emprenye, lekelerin taşın gözeneklerine işlemesini büyük ölçüde engeller.</p><h2>Cilalı yüzeyde matlaşma neden olur?</h2><p>Yanlış pH\'lı temizleyici kullanımı veya aşındırıcı bez/fırça, cila katmanını zamanla matlaştırır. Yumuşak bez ve nötr temizleyici en güvenli kombinasyondur.</p>',
                'published_at' => now()->subDays(1),
                'author'       => 'Digalpa Teknik Ekip',
                'products'     => ['stoneguard-pro-100', 'cleanstone-ac', 'diapol-k'],
            ],
            // AKEMI marka içeriği (Brief §07: 4. kategori)
            [
                'category'     => $sektor,
                'title'        => 'AKEMI Nedir? Digalpa\'nın Almanya Menşeli Global Ortağı',
                'excerpt'      => 'Digalpa\'nın Türkiye distribütörü olduğu AKEMI markası kimdir, doğal taş kimyasalları alanında neden referans kabul edilir?',
                'content'      => '<p>Digalpa, Türkiye pazarında AKEMI markasının resmi distribütörüdür. Bu ortaklık, ürün kataloğumuzun teknik omurgasını oluşturuyor.</p><h2>AKEMI Kimdir?</h2><p>Almanya merkezli AKEMI, onlarca yıldır doğal taş yapıştırıcıları, emprenye ürünleri ve bakım kimyasalları geliştiren, Avrupa\'da sektörün referans markalarından biri.</p><h2>Digalpa ile Ortaklığın Anlamı</h2><p>Bu distribütörlük sayesinde AKEMI\'nin Avrupa\'da test edilmiş formülasyonları, Digalpa\'nın yerel teknik destek ve stok altyapısıyla birleşerek Türkiye pazarına ulaşıyor. Katalogdaki StoneGuard ve MarblePol serisi ürünler bu teknolojik iş birliğinin ürünüdür.</p><h2>Neden Önemli?</h2><p>Uluslararası bir markanın teknik dokümantasyon standartları (TDS/SDS) ve laboratuvar testleri, projelerde öngörülebilir ve tutarlı sonuç almanızı sağlar.</p>',
                'published_at' => now()->subDays(15),
                'author'       => 'Digalpa Kurumsal',
                'products'     => ['stoneguard-ultra-200', 'marblepol-hp'],
            ],
        ];

        foreach ($posts as $data) {
            if (!$data['category']) continue;

            $slug = Str::slug($data['title']);

            $post = BlogPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'blog_category_id' => $data['category']->id,
                    'title'            => $data['title'],
                    'slug'             => $slug,
                    'excerpt'          => $data['excerpt'],
                    'content'          => $data['content'] ?? ('<p>' . $data['excerpt'] . '</p><p>Detaylı teknik bilgi ve uygulama kılavuzu için ekibimizle iletişime geçin.</p>'),
                    'author'           => $data['author'] ?? 'Digalpa Teknik Ekip',
                    'published_at'     => $data['published_at'],
                    'is_active'        => true,
                ]
            );

            if (!empty($data['products'])) {
                $productIds = Product::whereIn('slug', $data['products'])->pluck('id', 'slug');
                $sorted = collect($data['products'])
                    ->values()
                    ->mapWithKeys(fn ($slug, $i) => [$productIds[$slug] => ['sort_order' => $i]])
                    ->filter(fn ($v, $id) => $id !== null);
                $post->relatedProducts()->sync($sorted);
            }
        }
    }
}
