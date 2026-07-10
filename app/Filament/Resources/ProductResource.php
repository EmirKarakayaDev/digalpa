<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Category;
use App\Models\Product;
use App\Models\Segment;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-cube';
    protected static string | UnitEnum | null $navigationGroup = 'Katalog';
    protected static ?int $navigationSort = 3;

    public static function getModelLabel(): string { return 'Ürün'; }
    public static function getPluralModelLabel(): string { return 'Ürünler'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Temel Bilgiler')->schema([
                TextInput::make('name')
                    ->label('Ürün Adı')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                        $set('slug', Str::slug($state ?? ''))
                    )
                    ->columnSpan(2),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpan(2),

                Textarea::make('short_description')
                    ->label('Kısa Açıklama')
                    ->rows(3)
                    ->helperText('Ürün kartlarında görünür, max ~200 karakter.')
                    ->columnSpanFull(),
            ])->columns(4),

            Section::make('İçerik')->schema([
                RichEditor::make('description')
                    ->label('Tam Açıklama')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline',
                        'bulletList', 'orderedList',
                        'h2', 'h3',
                        'link', 'blockquote',
                    ])
                    ->columnSpanFull(),
            ]),

            Section::make('Teknik Özellikler')->schema([
                Repeater::make('technical_specs')
                    ->label('')
                    ->schema([
                        TextInput::make('label')
                            ->label('Özellik')
                            ->required()
                            ->placeholder('Yoğunluk'),
                        TextInput::make('value')
                            ->label('Değer')
                            ->required()
                            ->placeholder('1,45 g/cm³'),
                    ])
                    ->columns(2)
                    ->addActionLabel('Özellik Ekle')
                    ->reorderable()
                    ->collapsible()
                    ->columnSpanFull(),
            ]),

            Section::make('Hesaplayıcı & Ambalaj')->schema([
                TextInput::make('coverage_min')
                    ->label('Min Tüketim')
                    ->numeric()
                    ->step(0.01)
                    ->suffix('m²/kg'),

                TextInput::make('coverage_max')
                    ->label('Max Tüketim')
                    ->numeric()
                    ->step(0.01)
                    ->suffix('m²/kg'),

                TagsInput::make('package_sizes')
                    ->label('Ambalaj Boyutları')
                    ->placeholder('5 kg, 20 kg...')
                    ->helperText('Enter ile ekle')
                    ->columnSpanFull(),

                Select::make('stock_status')
                    ->label('Stok Durumu')
                    ->options([
                        'in_stock'     => 'Stokta Var',
                        'limited'      => 'Sınırlı Stok',
                        'out_of_stock' => 'Stokta Yok',
                    ])
                    ->default('in_stock')
                    ->required()
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Uygulama Adımları')
                ->description('Ürün sayfasında kapalı başlayan accordion bölümü (Brief §05).')
                ->schema([
                    Repeater::make('application_steps')
                        ->label('')
                        ->schema([
                            TextInput::make('title')
                                ->label('Adım Başlığı')
                                ->required()
                                ->placeholder('Yüzey Hazırlığı'),
                            Textarea::make('description')
                                ->label('Açıklama')
                                ->rows(2)
                                ->required(),
                        ])
                        ->addActionLabel('Adım Ekle')
                        ->reorderable()
                        ->collapsible()
                        ->columnSpanFull(),
                ]),

            Section::make('Dokümanlar')->schema([
                FileUpload::make('tds_file')
                    ->label('TDS (Teknik Veri Sayfası)')
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf']),

                FileUpload::make('sds_file')
                    ->label('SDS (Güvenlik Veri Sayfası)')
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf']),

                FileUpload::make('ce_file')
                    ->label('CE (Uygunluk Belgesi)')
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf']),
            ])->columns(3),

            Section::make('Görseller')->schema([
                FileUpload::make('image')
                    ->label('Ana Görsel')
                    ->image()
                    ->directory('products'),

                FileUpload::make('gallery')
                    ->label('Galeri')
                    ->image()
                    ->multiple()
                    ->directory('products/gallery')
                    ->reorderable(),
            ])->columns(2),

            Section::make('Kategoriler')->schema([
                Select::make('categories')
                    ->label('Kategoriler')
                    ->multiple()
                    ->relationship('categories', 'name')
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
            ]),

            Section::make('İlgili Projeler')
                ->description('Ürün sayfasında "varsa" gösterilen İlgili Projeler accordion\'u (Brief §05).')
                ->schema([
                    Select::make('referenceProjects')
                        ->label('İlgili Projeler')
                        ->multiple()
                        ->relationship('referenceProjects', 'title')
                        ->searchable()
                        ->preload()
                        ->columnSpanFull(),
                ]),

            Section::make('Tamamlayıcı Ürünler')
                ->description('Ürün sayfasında "Tamamlayıcı Ürünler" accordion\'unda gösterilecek ürünler (Brief §05) — otomatik hesaplanmaz, burada seçilir.')
                ->schema([
                    Select::make('complementaryProducts')
                        ->label('Tamamlayıcı Ürünler')
                        ->multiple()
                        ->relationship('complementaryProducts', 'name')
                        ->searchable()
                        ->preload()
                        ->columnSpanFull(),
                ]),

            Section::make('SEO')->schema([
                TextInput::make('meta_title')
                    ->label('Meta Başlık')
                    ->maxLength(60)
                    ->columnSpanFull(),

                Textarea::make('meta_description')
                    ->label('Meta Açıklama')
                    ->rows(2)
                    ->maxLength(160)
                    ->columnSpanFull(),
            ]),

            Section::make('Yayın')->schema([
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

                Toggle::make('is_featured')
                    ->label('Öne Çıkan'),

                TextInput::make('sort_order')
                    ->label('Sıra')
                    ->numeric()
                    ->default(0),
            ])->columns(3),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('')
                    ->width(60)
                    ->height(60),

                Tables\Columns\TextColumn::make('name')
                    ->label('Ürün Adı')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('categories.name')
                    ->label('Kategoriler')
                    ->badge()
                    ->separator(','),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Öne Çıkan')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Güncelleme')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('categories')
                    ->label('Kategori')
                    ->relationship('categories', 'name'),

                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Öne Çıkan'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit'   => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
