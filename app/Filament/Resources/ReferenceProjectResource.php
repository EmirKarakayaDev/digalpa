<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReferenceProjectResource\Pages;
use App\Models\ReferenceProject;
use App\Models\Segment;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
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

class ReferenceProjectResource extends Resource
{
    protected static ?string $model = ReferenceProject::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-office-2';
    protected static string | UnitEnum | null $navigationGroup = 'İçerik';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string { return 'Referans Proje'; }
    public static function getPluralModelLabel(): string { return 'Referans Projeler'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Temel Bilgiler')->schema([
                Select::make('segment_id')
                    ->label('Segment')
                    ->required()
                    ->options(Segment::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id')),

                TextInput::make('year')
                    ->label('Yıl')
                    ->numeric()
                    ->minValue(2000)
                    ->maxValue(2099),

                TextInput::make('title')
                    ->label('Proje Adı')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                        $set('slug', Str::slug($state ?? ''))
                    )
                    ->columnSpanFull(),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->columnSpanFull(),

                TextInput::make('client')
                    ->label('Müşteri / Yapı Adı')
                    ->maxLength(255),

                TextInput::make('location')
                    ->label('Konum')
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Kısa Açıklama')
                    ->rows(3)
                    ->helperText('Listede görünür.')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('Detay İçeriği')->schema([
                RichEditor::make('content')
                    ->label('Proje Detayı')
                    ->toolbarButtons(['bold', 'italic', 'bulletList', 'orderedList', 'h2', 'h3', 'link'])
                    ->columnSpanFull(),
            ]),

            Section::make('Kullanılan Ürünler')->schema([
                TagsInput::make('used_products')
                    ->label('Ürün Adları')
                    ->placeholder('Ürün adı yazıp Enter...')
                    ->columnSpanFull(),
            ]),

            Section::make('Görseller')->schema([
                FileUpload::make('image')
                    ->label('Kapak Görseli')
                    ->image()
                    ->directory('projects'),

                FileUpload::make('gallery')
                    ->label('Galeri')
                    ->image()
                    ->multiple()
                    ->directory('projects/gallery')
                    ->reorderable(),
            ])->columns(2),

            Section::make('SEO & Yayın')->schema([
                TextInput::make('meta_title')->label('Meta Başlık')->maxLength(60),
                Textarea::make('meta_description')->label('Meta Açıklama')->rows(2)->maxLength(160),
                Select::make('source')
                    ->label('Kaynak')
                    ->options(['digalpa' => 'Digalpa', 'akemi' => 'AKEMI Referans'])
                    ->default('digalpa')
                    ->required(),
                Toggle::make('is_active')->label('Aktif')->default(true),
                Toggle::make('is_featured')->label('Ana Sayfada Göster'),
                TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('')->width(60)->height(60),
                Tables\Columns\TextColumn::make('title')->label('Proje Adı')->searchable()->sortable()->limit(50),
                Tables\Columns\TextColumn::make('segment.name')->label('Segment')->badge()
                    ->color(fn ($record) => match ($record->segment?->color_key) {
                        'amber' => 'warning', 'stone' => 'gray', 'marine' => 'info', default => 'primary',
                    }),
                Tables\Columns\TextColumn::make('client')->label('Müşteri')->placeholder('—'),
                Tables\Columns\TextColumn::make('year')->label('Yıl')->sortable(),
                Tables\Columns\TextColumn::make('source')->label('Kaynak')
                    ->badge()
                    ->color(fn (string $state) => $state === 'akemi' ? 'danger' : 'primary')
                    ->formatStateUsing(fn (string $state) => $state === 'akemi' ? 'AKEMI' : 'Digalpa'),
                Tables\Columns\IconColumn::make('is_featured')->label('Ana Sayfa')->boolean(),
                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('segment_id')->label('Segment')
                    ->options(Segment::orderBy('sort_order')->pluck('name', 'id')),
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Öne Çıkan'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListReferenceProjects::route('/'),
            'create' => Pages\CreateReferenceProject::route('/create'),
            'edit'   => Pages\EditReferenceProject::route('/{record}/edit'),
        ];
    }
}
