<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Arr;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\EmbeddedSchema;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use UnitEnum;

class SiteSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static string | UnitEnum | null $navigationGroup = 'Ayarlar';
    protected static ?string $navigationLabel = 'Site Ayarları';
    protected static ?int $navigationSort = 90;

    public ?array $data = [];

    public function mount(): void
    {
        $flat = SiteSetting::all()->pluck('value', 'key')->toArray();
        $nested = [];
        foreach ($flat as $key => $value) {
            data_set($nested, $key, $value);
        }
        $this->form->fill($nested);
    }

    public function content(Schema $schema): Schema
    {
        return $schema->components([
            Form::make([EmbeddedSchema::make('form')])
                ->id('form')
                ->livewireSubmitHandler('save')
                ->footer([
                    Actions::make([
                        Action::make('save')
                            ->label('Ayarları Kaydet')
                            ->submit('save'),
                    ]),
                ]),
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Tabs::make('Ayarlar')->tabs([

                    Tab::make('Site & İletişim')->schema([
                        TextInput::make('site.company_name')->label('Şirket Adı')->required(),
                        TextInput::make('site.logo_subtitle')->label('Logo Altı (kısa)')->helperText('Nav logosunun yanındaki küçük yazı. Örn: Kimya'),
                        TextInput::make('site.phone')->label('Telefon'),
                        TextInput::make('site.email')->label('E-posta')->email(),
                        TextInput::make('site.address')->label('Adres'),
                        TextInput::make('site.footer_tagline')->label('Footer Alt Metin')->columnSpanFull(),
                    ])->columns(2),

                    Tab::make('Ana Sayfa — Hero')->schema([
                        FileUpload::make('home.hero_image')
                            ->label('Arka Plan Görseli')
                            ->image()
                            ->directory('hero')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextInput::make('home.hero_label')
                            ->label('Üst Etiket (label caps)')
                            ->helperText('Örn: YAPI KİMYASALLARI'),
                        TextInput::make('home.hero_title')
                            ->label('Başlık')
                            ->helperText('Satır sonu için \n kullanın')
                            ->columnSpanFull(),
                        Textarea::make('home.hero_body')
                            ->label('Giriş Metni')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('home.stat1_value')->label('İstatistik 1 Değer'),
                        TextInput::make('home.stat1_label')->label('İstatistik 1 Açıklama'),
                        TextInput::make('home.stat2_value')->label('İstatistik 2 Değer'),
                        TextInput::make('home.stat2_label')->label('İstatistik 2 Açıklama'),
                        TextInput::make('home.stat3_value')->label('İstatistik 3 Değer'),
                        TextInput::make('home.stat3_label')->label('İstatistik 3 Açıklama'),
                        TextInput::make('home.finder_subtitle')
                            ->label('Mini Finder Widget Alt Başlık')
                            ->helperText('Hero\'daki beyaz kutu içindeki başlık')
                            ->columnSpanFull(),
                        TextInput::make('home.finder_band_label')->label('Finder Bandı Etiket'),
                        TextInput::make('home.finder_band_title')
                            ->label('Finder Bandı Başlık')
                            ->helperText('Satır sonu için \n kullanın'),
                        Textarea::make('home.finder_band_body')
                            ->label('Finder Bandı Açıklama')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('home.trust_title')
                            ->label('"Neden Digalpa" Bölümü Başlık')
                            ->columnSpanFull(),
                        TextInput::make('home.trust1_title')->label('Güven Kartı 1 Başlık'),
                        Textarea::make('home.trust1_body')->label('Güven Kartı 1 Açıklama')->rows(2),
                        TextInput::make('home.trust2_title')->label('Güven Kartı 2 Başlık'),
                        Textarea::make('home.trust2_body')->label('Güven Kartı 2 Açıklama')->rows(2),
                        TextInput::make('home.trust3_title')->label('Güven Kartı 3 Başlık'),
                        Textarea::make('home.trust3_body')->label('Güven Kartı 3 Açıklama')->rows(2),
                    ])->columns(2),

                    Tab::make('Hakkımızda')->schema([
                        Textarea::make('about.intro')
                            ->label('Giriş Cümlesi')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('about.body')
                            ->label('Ana Metin')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('about.stat1_value')->label('İstatistik 1 Değer'),
                        TextInput::make('about.stat1_label')->label('İstatistik 1 Açıklama'),
                        TextInput::make('about.stat2_value')->label('İstatistik 2 Değer'),
                        TextInput::make('about.stat2_label')->label('İstatistik 2 Açıklama'),
                        TextInput::make('about.stat3_value')->label('İstatistik 3 Değer'),
                        TextInput::make('about.stat3_label')->label('İstatistik 3 Açıklama'),
                    ])->columns(2),

                    Tab::make('AKEMI Bölümü')->schema([
                        TextInput::make('akemi.title')
                            ->label('Başlık')
                            ->columnSpanFull(),
                        Textarea::make('akemi.body')
                            ->label('Açıklama')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('akemi.badge1')->label('Rozet 1'),
                        TextInput::make('akemi.badge2')->label('Rozet 2'),
                        TextInput::make('akemi.badge3')->label('Rozet 3'),
                    ])->columns(3),

                ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = Arr::dot($this->form->getState());

        foreach ($data as $key => $value) {
            $group = explode('.', $key)[0];
            SiteSetting::set($key, $value, $group);
        }

        SiteSetting::forgetGroup('site');
        SiteSetting::forgetGroup('home');
        SiteSetting::forgetGroup('about');
        SiteSetting::forgetGroup('akemi');

        Notification::make()
            ->title('Ayarlar kaydedildi.')
            ->success()
            ->send();
    }
}
