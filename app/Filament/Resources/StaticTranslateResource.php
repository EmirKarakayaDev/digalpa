<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticTranslateResource\Pages;
use App\Models\StaticTranslate;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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

class StaticTranslateResource extends Resource
{
    protected static ?string $model = StaticTranslate::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-language';
    protected static string | UnitEnum | null $navigationGroup = 'Site';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string { return 'Çeviri'; }
    public static function getPluralModelLabel(): string { return 'Statik Metinler'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('key')
                    ->label('Anahtar')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Örn: hero.title, footer.phone'),

                Select::make('locale')
                    ->label('Dil')
                    ->options(['tr' => 'Türkçe', 'en' => 'İngilizce'])
                    ->default('tr')
                    ->required(),

                TextInput::make('group')
                    ->label('Grup')
                    ->maxLength(100)
                    ->helperText('Örn: hero, footer, nav — filtreleme için'),

                Textarea::make('value')
                    ->label('Değer')
                    ->rows(4)
                    ->required()
                    ->columnSpanFull(),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('key')
                    ->label('Anahtar')
                    ->searchable()
                    ->sortable()
                    ->fontFamily('mono'),

                Tables\Columns\TextColumn::make('locale')
                    ->label('Dil')
                    ->badge()
                    ->color(fn ($state) => $state === 'tr' ? 'danger' : 'info'),

                Tables\Columns\TextColumn::make('value')
                    ->label('Değer')
                    ->limit(60)
                    ->searchable(),
            ])
            ->defaultSort('group')
            ->filters([
                Tables\Filters\SelectFilter::make('locale')
                    ->label('Dil')
                    ->options(['tr' => 'Türkçe', 'en' => 'İngilizce']),

                Tables\Filters\SelectFilter::make('group')
                    ->label('Grup')
                    ->options(fn () => StaticTranslate::distinct()->orderBy('group')->pluck('group', 'group')->filter()->toArray()),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStaticTranslates::route('/'),
            'create' => Pages\CreateStaticTranslate::route('/create'),
            'edit'   => Pages\EditStaticTranslate::route('/{record}/edit'),
        ];
    }
}
