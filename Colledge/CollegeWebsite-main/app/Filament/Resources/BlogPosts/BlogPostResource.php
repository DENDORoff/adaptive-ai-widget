<?php

namespace App\Filament\Resources\BlogPosts;

use App\Filament\Resources\BlogPosts\Pages;
use App\Models\BlogPost;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;

    protected static ?string $navigationLabel = 'Блог руководителя';
    protected static ?string $modelLabel = 'Пост';
    protected static ?string $pluralModelLabel = 'Посты блога';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-document-text';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Содержание поста')
                ->schema([
                    TextInput::make('title')
                        ->label('Заголовок')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn (callable $set, ?string $state) => 
                            $set('slug', Str::slug($state))
                        ),
                    
                    TextInput::make('slug')
                        ->label('URL (slug)')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true),
                    
                    FileUpload::make('image')
                        ->label('Изображение поста')
                        ->image()
                        ->disk('public')
                        ->directory('blog-posts')
                        ->maxSize(5120)
                        ->imageEditor()
                        ->helperText('Рекомендуемый размер: 800x600px (макс. 5 МБ)')
                        ->columnSpanFull(),
                    
                    RichEditor::make('content')
                        ->label('Содержание')
                        ->required()
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'strike',
                            'link',
                            'bulletList',
                            'orderedList',
                            'blockquote',
                            'codeBlock',
                            'h2',
                            'h3',
                        ]),
                ])->columns(2),
            
            Section::make('Публикация')
                ->schema([
                    Toggle::make('is_published')
                        ->label('Опубликовано')
                        ->default(true),
                    
                    DateTimePicker::make('published_at')
                        ->label('Дата публикации')
                        ->default(now()),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Фото')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        // Если у записи есть изображение, используем его
                        if ($record?->image) {
                            return asset('storage/' . $record->image);
                        }
                        // Иначе используем изображение по умолчанию из public/storage/blog-post/
                        return asset('storage/blog-post/default-avatar.jpg');
                    }),
                
                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),
                
                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Дата публикации')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Опубликовано'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('delete')
                    ->label('Удалить выбранные')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}