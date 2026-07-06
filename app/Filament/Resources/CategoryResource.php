<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use App\Models\Segment;
use BackedEnum;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-folder';
    protected static string | UnitEnum | null $navigationGroup = 'Katalog';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string { return 'Kategori'; }
    public static function getPluralModelLabel(): string { return 'Kategoriler'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                Select::make('segment_id')
                    ->label('Segment')
                    ->required()
                    ->options(Segment::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id'))
                    ->live(),

                Select::make('parent_id')
                    ->label('Üst Kategori')
                    ->placeholder('Yok (ana kategori)')
                    ->options(fn ($get) => Category::where('segment_id', $get('segment_id'))
                        ->whereNull('parent_id')
                        ->orderBy('sort_order')
                        ->pluck('name', 'id')
                    )
                    ->searchable(),

                TextInput::make('name')
                    ->label('Ad')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                        $set('slug', Str::slug($state ?? ''))
                    ),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Açıklama')
                    ->rows(3)
                    ->columnSpanFull(),

                FileUpload::make('image')
                    ->label('Görsel')
                    ->image()
                    ->directory('categories')
                    ->columnSpanFull(),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),

                TextInput::make('sort_order')
                    ->label('Sıra')
                    ->numeric()
                    ->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('name')
                    ->label('Ad')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('segment.name')
                    ->label('Segment')
                    ->badge()
                    ->color(fn ($record) => match ($record->segment?->color_key) {
                        'amber'  => 'warning',
                        'stone'  => 'gray',
                        'marine' => 'info',
                        default  => 'primary',
                    }),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Üst Kategori')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('products_count')
                    ->label('Ürün')
                    ->counts('products'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->filters([
                Tables\Filters\SelectFilter::make('segment_id')
                    ->label('Segment')
                    ->options(Segment::orderBy('sort_order')->pluck('name', 'id')),

                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit'   => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
