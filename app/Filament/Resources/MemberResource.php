<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Member;
use BackedEnum;
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

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';
    protected static string | UnitEnum | null $navigationGroup = 'Ayarlar';
    protected static ?int $navigationSort = 91;

    public static function getModelLabel(): string { return 'Üye'; }
    public static function getPluralModelLabel(): string { return 'Üyeler'; }
    public static function getNavigationLabel(): string { return 'Bildirim Alıcıları'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()
                ->description('Panele giriş yapmazlar — sadece site üzerinden gelen taleplerde kime bildirim gideceğini belirler.')
                ->schema([
                    TextInput::make('name')
                        ->label('Ad')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('E-posta')
                        ->required()
                        ->email()
                        ->maxLength(255),

                    Toggle::make('receives_notifications')
                        ->label('Doküman Talebi Bildirimi Alsın')
                        ->helperText('Kapalıysa üye listede kalır ama mail gitmez.')
                        ->default(true),

                    Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Ad')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('E-posta')
                    ->searchable(),

                Tables\Columns\IconColumn::make('receives_notifications')
                    ->label('Bildirim Alır')
                    ->boolean(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Eklenme')
                    ->dateTime('d.m.Y')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
                Tables\Filters\TernaryFilter::make('receives_notifications')->label('Bildirim Alır'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit'   => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}
