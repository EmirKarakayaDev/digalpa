<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
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

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-envelope';
    protected static string | UnitEnum | null $navigationGroup = 'Talepler';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string { return 'İletişim Mesajı'; }
    public static function getPluralModelLabel(): string { return 'İletişim Mesajları'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Mesaj Bilgileri')->schema([
                Placeholder::make('full_name')->label('Ad Soyad')
                    ->content(fn ($record) => $record?->full_name ?? '—'),

                Placeholder::make('email')->label('E-posta')
                    ->content(fn ($record) => $record?->email ?? '—'),

                Placeholder::make('phone')->label('Telefon')
                    ->content(fn ($record) => $record?->phone ?? '—'),

                Placeholder::make('company')->label('Firma')
                    ->content(fn ($record) => $record?->company ?? '—'),

                Placeholder::make('subject')->label('Konu')
                    ->content(fn ($record) => $record?->subject ?? '—')
                    ->columnSpanFull(),

                Placeholder::make('message')->label('Mesaj')
                    ->content(fn ($record) => $record?->message ?? '—')
                    ->columnSpanFull(),

                Placeholder::make('created_at')->label('Tarih')
                    ->content(fn ($record) => $record?->created_at?->format('d.m.Y H:i') ?? '—'),
            ])->columns(2),

            Section::make('Durum')->schema([
                Select::make('status')
                    ->label('Durum')
                    ->options([
                        'unread'  => 'Okunmadı',
                        'read'    => 'Okundu',
                        'replied' => 'Yanıtlandı',
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
                Tables\Columns\TextColumn::make('subject')->label('Konu')->limit(40)->placeholder('—'),

                Tables\Columns\TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'unread' => 'danger', 'read' => 'warning', 'replied' => 'success', default => 'gray',
                    })
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'unread' => 'Okunmadı', 'read' => 'Okundu', 'replied' => 'Yanıtlandı', default => $state,
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Durum')->options([
                    'unread' => 'Okunmadı', 'read' => 'Okundu', 'replied' => 'Yanıtlandı',
                ]),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'edit'  => Pages\EditContact::route('/{record}/edit'),
        ];
    }
}
