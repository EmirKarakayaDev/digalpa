<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use BackedEnum;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-document-text';
    protected static string | UnitEnum | null $navigationGroup = 'Blog';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string { return 'Blog Yazısı'; }
    public static function getPluralModelLabel(): string { return 'Blog Yazıları'; }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Temel Bilgiler')->schema([
                Select::make('blog_category_id')
                    ->label('Kategori')
                    ->required()
                    ->options(BlogCategory::where('is_active', true)->orderBy('sort_order')->pluck('name', 'id'))
                    ->searchable(),

                TextInput::make('author')
                    ->label('Yazar')
                    ->maxLength(100),

                TextInput::make('title')
                    ->label('Başlık')
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

                Textarea::make('excerpt')
                    ->label('Özet')
                    ->rows(3)
                    ->helperText('Listede ve meta açıklama olarak kullanılır.')
                    ->columnSpanFull(),
            ])->columns(2),

            Section::make('İçerik')->schema([
                RichEditor::make('content')
                    ->label('İçerik')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline',
                        'bulletList', 'orderedList',
                        'h2', 'h3',
                        'link', 'blockquote', 'strike',
                    ])
                    ->columnSpanFull(),
            ]),

            Section::make('Görsel & Yayın')->schema([
                FileUpload::make('image')
                    ->label('Öne Çıkan Görsel')
                    ->image()
                    ->directory('blog'),

                DateTimePicker::make('published_at')
                    ->label('Yayın Tarihi')
                    ->helperText('Boş bırakılırsa taslak olarak kaydedilir.')
                    ->displayFormat('d.m.Y H:i'),

                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ])->columns(3),

            Section::make('İlgili Ürünler')->schema([
                Select::make('relatedProducts')
                    ->label('Bu yazıyla ilişkilendirilecek ürünler')
                    ->multiple()
                    ->relationship('relatedProducts', 'name')
                    ->searchable()
                    ->preload()
                    ->helperText('Boş bırakılırsa sidebar\'da öne çıkan ürünler gösterilir.')
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('')->width(60)->height(60),

                Tables\Columns\TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->limit(60),

                Tables\Columns\TextColumn::make('blogCategory.name')
                    ->label('Kategori')
                    ->badge(),

                Tables\Columns\TextColumn::make('author')
                    ->label('Yazar')
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime('d.m.Y')
                    ->sortable()
                    ->placeholder('Taslak'),

                Tables\Columns\IconColumn::make('is_active')->label('Aktif')->boolean(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('blog_category_id')
                    ->label('Kategori')
                    ->options(BlogCategory::orderBy('sort_order')->pluck('name', 'id')),

                Tables\Filters\TernaryFilter::make('is_active')->label('Aktif'),
            ])
            ->actions([EditAction::make(), DeleteAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit'   => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
