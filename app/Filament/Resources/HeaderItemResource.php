<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeaderItemResource\Pages;
use App\Models\HeaderItem;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class HeaderItemResource extends Resource
{
    protected static ?string $model = HeaderItem::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-bars-3';
    protected static string | UnitEnum | null $navigationGroup = 'Site';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string { return 'Menü Öğesi'; }
    public static function getPluralModelLabel(): string { return 'Navigasyon Menüsü'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Menü Öğesi')->schema([
                TextInput::make('label')
                    ->label('Etiket')
                    ->required()
                    ->maxLength(255),

                TextInput::make('url')
                    ->label('URL')
                    ->maxLength(500)
                    ->helperText('Dahili: /urunler — Harici: https://...'),

                Select::make('type')
                    ->label('Tür')
                    ->options([
                        'link'       => 'Bağlantı',
                        'mega_menu'  => 'Mega Menü',
                        'button'     => 'Buton',
                    ])
                    ->required()
                    ->default('link'),

                Select::make('target')
                    ->label('Hedef')
                    ->options([
                        '_self'   => 'Aynı sekme',
                        '_blank'  => 'Yeni sekme',
                    ])
                    ->default('_self'),

                Select::make('parent_id')
                    ->label('Üst Öğe')
                    ->options(fn () => HeaderItem::whereNull('parent_id')->orderBy('sort_order')->pluck('label', 'id'))
                    ->searchable()
                    ->nullable()
                    ->helperText('Ana menü öğesi için boş bırakın.'),

                Toggle::make('is_active')->label('Aktif')->default(true),
                TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')->label('#')->sortable()->width(50),

                Tables\Columns\TextColumn::make('label')
                    ->label('Etiket')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Üst')
                    ->placeholder('— Ana öğe —'),

                Tables\Columns\TextColumn::make('type')
                    ->label('Tür')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'link' => 'Bağlantı', 'mega_menu' => 'Mega Menü', 'button' => 'Buton', default => $state,
                    })
                    ->color(fn ($state) => match ($state) {
                        'mega_menu' => 'info', 'button' => 'success', default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(40)
                    ->placeholder('—'),

                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListHeaderItems::route('/'),
            'create' => Pages\CreateHeaderItem::route('/create'),
            'edit'   => Pages\EditHeaderItem::route('/{record}/edit'),
        ];
    }
}
