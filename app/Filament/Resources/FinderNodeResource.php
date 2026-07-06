<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FinderNodeResource\Pages;
use App\Models\FinderNode;
use App\Models\Segment;
use BackedEnum;
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

class FinderNodeResource extends Resource
{
    protected static ?string $model = FinderNode::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-map-pin';
    protected static string | UnitEnum | null $navigationGroup = 'Katalog';
    protected static ?int $navigationSort = 4;

    public static function getModelLabel(): string { return 'Finder Düğümü'; }
    public static function getPluralModelLabel(): string { return 'Product Finder'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Konum')->schema([
                Select::make('depth')
                    ->label('Derinlik (Seviye)')
                    ->options([
                        1 => 'Seviye 1 — Uygulama Alanı',
                        2 => 'Seviye 2 — Alt Uygulama',
                        3 => 'Seviye 3 — Yapı Detayı (Yaprak)',
                    ])
                    ->required()
                    ->live(),

                Select::make('parent_id')
                    ->label('Üst Düğüm')
                    ->options(fn () => FinderNode::whereIn('depth', [1, 2])->orderBy('depth')->orderBy('sort_order')->get()
                        ->mapWithKeys(fn ($n) => [$n->id => "[Seviye {$n->depth}] {$n->label}"])
                    )
                    ->searchable()
                    ->nullable()
                    ->helperText('Seviye 1 için boş bırakın.'),

                Select::make('segment_id')
                    ->label('Segment')
                    ->options(Segment::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id'))
                    ->nullable()
                    ->helperText('Opsiyonel — hangi segmentle ilişkili?'),
            ])->columns(2),

            Section::make('İçerik')->schema([
                TextInput::make('label')
                    ->label('Etiket')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) =>
                        $set('slug', Str::slug($state ?? ''))
                    ),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('Açıklama')
                    ->rows(2)
                    ->columnSpanFull(),

                Toggle::make('is_active')->label('Aktif')->default(true),
                TextInput::make('sort_order')->label('Sıra')->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('depth')
                    ->label('Seviye')
                    ->badge()
                    ->formatStateUsing(fn ($state) => "Seviye $state")
                    ->color(fn ($state) => match ($state) {
                        1 => 'primary', 2 => 'warning', 3 => 'success', default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('label')
                    ->label('Etiket')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent.label')
                    ->label('Üst')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('segment.name')
                    ->label('Segment')
                    ->badge()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->defaultSort('depth')
            ->filters([
                Tables\Filters\SelectFilter::make('depth')
                    ->label('Seviye')
                    ->options([1 => 'Seviye 1', 2 => 'Seviye 2', 3 => 'Seviye 3']),

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
            'index'  => Pages\ListFinderNodes::route('/'),
            'create' => Pages\CreateFinderNode::route('/create'),
            'edit'   => Pages\EditFinderNode::route('/{record}/edit'),
        ];
    }
}
