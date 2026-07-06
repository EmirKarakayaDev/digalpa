<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // --- site ---
            ['key' => 'site.company_name',   'group' => 'site', 'value' => 'Digalpa Kimya Sanayi A.Ş.'],
            ['key' => 'site.logo_subtitle',  'group' => 'site', 'value' => 'Kimya'],
            ['key' => 'site.phone',          'group' => 'site', 'value' => '+90 212 000 00 00'],
            ['key' => 'site.email',          'group' => 'site', 'value' => 'info@digalpa.com'],
            ['key' => 'site.address',        'group' => 'site', 'value' => 'İstanbul, Türkiye'],
            ['key' => 'site.footer_tagline', 'group' => 'site', 'value' => 'Yapı kimyasallarında güvenilir çözüm ortağınız.'],

            // --- home ---
            ['key' => 'home.hero_label',          'group' => 'home', 'value' => 'YAPI KİMYASALLARI'],
            ['key' => 'home.hero_title',          'group' => 'home', 'value' => "Uzman Formülasyon,\nKalıcı Sonuç"],
            ['key' => 'home.hero_body',           'group' => 'home', 'value' => 'Doğal taş, inşaat ve marine sektörlerine özel geliştirilmiş yüksek performanslı yapı kimyasalları.'],
            ['key' => 'home.stat1_value',         'group' => 'home', 'value' => '20+'],
            ['key' => 'home.stat1_label',         'group' => 'home', 'value' => 'Yıllık Deneyim'],
            ['key' => 'home.stat2_value',         'group' => 'home', 'value' => '150+'],
            ['key' => 'home.stat2_label',         'group' => 'home', 'value' => 'Ürün Çeşidi'],
            ['key' => 'home.stat3_value',         'group' => 'home', 'value' => '500+'],
            ['key' => 'home.stat3_label',         'group' => 'home', 'value' => 'Referans Proje'],
            ['key' => 'home.finder_subtitle',     'group' => 'home', 'value' => 'Uygulamanız için doğru ürünü seçin'],
            ['key' => 'home.finder_band_label',   'group' => 'home', 'value' => 'Doğru Ürünü Bul'],
            ['key' => 'home.finder_band_title',   'group' => 'home', 'value' => "Uygulamanıza Özel\nÜrün Seçimi"],
            ['key' => 'home.finder_band_body',    'group' => 'home', 'value' => 'Uygulama alanınızı ve yüzey tipini seçin — size en uygun ürünleri adım adım listeleyelim.'],
            ['key' => 'home.trust_title',         'group' => 'home', 'value' => 'Güvenilir Çözüm Ortağınız'],
            ['key' => 'home.trust1_title',        'group' => 'home', 'value' => 'AKEMI Yetkili Distribütörü'],
            ['key' => 'home.trust1_body',         'group' => 'home', 'value' => "Almanya'nın önde gelen yapı kimyasalları markası AKEMI'nin Türkiye'deki yetkili distribütörüyüz. Orijinal ürün, orijinal kalite."],
            ['key' => 'home.trust2_title',        'group' => 'home', 'value' => 'Tam Teknik Dokümantasyon'],
            ['key' => 'home.trust2_body',         'group' => 'home', 'value' => 'Her ürün için TDS (Teknik Veri Sayfası), SDS (Güvenlik Bilgi Formu) ve CE sertifikaları talep üzerine anında ulaşılabilir.'],
            ['key' => 'home.trust3_title',        'group' => 'home', 'value' => "Türkiye'de Hızlı Lojistik"],
            ['key' => 'home.trust3_body',         'group' => 'home', 'value' => 'Yurt içi depo ağımız ve lojistik altyapımız sayesinde Türkiye genelinde zamanında ve güvenli teslimat sağlıyoruz.'],

            // --- about ---
            ['key' => 'about.intro',         'group' => 'about', 'value' => 'Doğal taş, inşaat ve marine sektörlerine özel formüle edilmiş yüksek performanslı yapı kimyasalları alanında güvenilir çözüm ortağınız.'],
            ['key' => 'about.body',          'group' => 'about', 'value' => 'Almanya\'nın önde gelen yapı kimyasalları markası AKEMI\'nin Türkiye resmi distribütörü olarak, orijinal ürünleri profesyonel teknik destek ve hızlı lojistik altyapısıyla Türkiye geneline ulaştırıyoruz.'],
            ['key' => 'about.stat1_value',   'group' => 'about', 'value' => '20+'],
            ['key' => 'about.stat1_label',   'group' => 'about', 'value' => 'Yıllık Sektör Deneyimi'],
            ['key' => 'about.stat2_value',   'group' => 'about', 'value' => '150+'],
            ['key' => 'about.stat2_label',   'group' => 'about', 'value' => 'Ürün Çeşidi'],
            ['key' => 'about.stat3_value',   'group' => 'about', 'value' => '500+'],
            ['key' => 'about.stat3_label',   'group' => 'about', 'value' => 'Referans Proje'],

            // --- akemi ---
            ['key' => 'akemi.title',         'group' => 'akemi', 'value' => 'AKEMI Resmi Türkiye Distribütörü'],
            ['key' => 'akemi.body',          'group' => 'akemi', 'value' => 'Almanya\'nın önde gelen yapı kimyasalları markası AKEMI\'nin orijinal ürünlerini profesyonel teknik destek ve hızlı lojistik altyapısıyla Türkiye geneline ulaştırıyoruz.'],
            ['key' => 'akemi.badge1',        'group' => 'akemi', 'value' => 'Orijinal Ürün'],
            ['key' => 'akemi.badge2',        'group' => 'akemi', 'value' => 'Teknik Destek'],
            ['key' => 'akemi.badge3',        'group' => 'akemi', 'value' => 'Hızlı Teslimat'],
        ];

        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], ['value' => $s['value'], 'group' => $s['group']]);
        }
    }
}
