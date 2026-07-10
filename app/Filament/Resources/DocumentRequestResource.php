<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentRequestResource\Pages;
use App\Models\DocumentRequest;
use BackedEnum;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class DocumentRequestResource extends Resource
{
    protected static ?string $model = DocumentRequest::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-arrow-down';
    protected static string | UnitEnum | null $navigationGroup = 'Talepler';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string { return 'Doküman Talebi'; }
    public static function getPluralModelLabel(): string { return 'Doküman Talepleri'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Talep Bilgileri')->schema([
                Placeholder::make('product_display')
                    ->label('Ürün')
                    ->content(fn ($record) => $record?->product?->name ?? $record?->product_name ?? '—'),

                Placeholder::make('document_type')
                    ->label('Doküman Türü')
                    ->content(fn ($record) => $record ? static::formatDocumentTypes($record->document_type, long: true) : '—'),

                Placeholder::make('full_name')->label('Ad Soyad')
                    ->content(fn ($record) => $record?->full_name ?? '—'),

                Placeholder::make('email')->label('E-posta')
                    ->content(fn ($record) => $record?->email ?? '—'),

                Placeholder::make('phone')->label('Telefon')
                    ->content(fn ($record) => $record?->phone ?? '—'),

                Placeholder::make('company')->label('Firma')
                    ->content(fn ($record) => $record?->company ?? '—'),

                Placeholder::make('message')->label('Not')
                    ->content(fn ($record) => $record?->message ?? '—')
                    ->columnSpanFull(),

                Placeholder::make('created_at')->label('Talep Tarihi')
                    ->content(fn ($record) => $record?->created_at?->format('d.m.Y H:i') ?? '—'),
            ])->columns(2),

            Section::make('Durum')->schema([
                Select::make('status')
                    ->label('Durum')
                    ->options([
                        'pending'  => 'Bekliyor',
                        'sent'     => 'Gönderildi',
                        'rejected' => 'Reddedildi',
                    ])
                    ->required(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tarih')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('full_name')->label('Ad Soyad')->searchable(),
                Tables\Columns\TextColumn::make('email')->label('E-posta')->searchable(),
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Ürün')
                    ->limit(40)
                    ->formatStateUsing(fn ($state, $record) => $state ?? $record->product_name ?? '—'),

                Tables\Columns\TextColumn::make('document_type')
                    ->label('Tür')
                    ->badge()
                    ->formatStateUsing(fn ($state) => static::formatDocumentTypes($state))
                    ->color(fn ($state) => str_contains($state, ',') ? 'success' : match ($state) {
                        'tds' => 'info', 'sds' => 'warning', 'ce' => 'gray', default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'pending' => 'warning', 'sent' => 'success', 'rejected' => 'danger', default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending' => 'Bekliyor', 'sent' => 'Gönderildi', 'rejected' => 'Reddedildi', default => $state,
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options([
                    'pending' => 'Bekliyor', 'sent' => 'Gönderildi', 'rejected' => 'Reddedildi',
                ]),
                Tables\Filters\SelectFilter::make('document_type')
                    ->label('Tür')
                    ->options(['tds' => 'TDS', 'sds' => 'SDS', 'ce' => 'CE'])
                    ->query(fn ($query, array $data) => filled($data['value'] ?? null)
                        ? $query->where('document_type', 'like', '%' . $data['value'] . '%')
                        : $query),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    private static function formatDocumentTypes(string $documentType, bool $long = false): string
    {
        $labels = $long
            ? ['tds' => 'TDS (Teknik Veri Sayfası)', 'sds' => 'SDS (Güvenlik Veri Sayfası)', 'ce' => 'CE (Uygunluk Belgesi)']
            : ['tds' => 'TDS', 'sds' => 'SDS', 'ce' => 'CE'];

        $selected = array_intersect_key($labels, array_flip(explode(',', $documentType)));

        return $selected ? implode(' + ', $selected) : '—';
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocumentRequests::route('/'),
            'edit'  => Pages\EditDocumentRequest::route('/{record}/edit'),
        ];
    }
}
