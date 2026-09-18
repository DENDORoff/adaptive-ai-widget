<?php

namespace App\Filament\Resources\CollegeDocuments;

use App\Filament\Resources\CollegeDocuments\Pages;
use App\Models\CollegeDocument;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class CollegeDocumentResource extends Resource
{
    protected static ?string $model = CollegeDocument::class;

    protected static ?string $navigationLabel = 'Документы колледжа';
    protected static ?string $modelLabel = 'Документ';
    protected static ?string $pluralModelLabel = 'Документы колледжа';
    
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-document-text';
    }

    // Раскомментируйте если нужна группа
    public static function getNavigationGroup(): ?string
    {
        return 'Документы';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Информация о документе')
                ->schema([
                    TextInput::make('title')
                        ->label('Название документа')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Например: Устав колледжа 2024')
                        ->columnSpanFull(),
                    
                    Select::make('type')
                        ->label('Тип документа')
                        ->options([
                            'charter' => 'Устав колледжа',
                            'license' => 'Лицензия на образовательную деятельность',
                            'rules' => 'Правила внутреннего распорядка',
                        ])
                        ->required()
                        ->helperText('Выберите тип документа для отображения в меню')
                        ->columnSpanFull(),
                    
                    FileUpload::make('pdf_file')
                        ->label('PDF файл документа')
                        ->disk('public_files')
                        ->directory('college-documents')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(20480) // 20MB
                        ->required()
                        ->helperText('Загрузите PDF файл (макс. 20 МБ)')
                        ->columnSpanFull(),
                    
                    Toggle::make('is_active')
                        ->label('Активен (отображать в меню)')
                        ->default(true)
                        ->helperText('Только активный документ будет отображаться в меню для каждого типа')
                        ->columnSpanFull(),
                    
                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке')
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'charter' => 'Устав',
                        'license' => 'Лицензия',
                        'rules' => 'Правила',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'charter',
                        'success' => 'license',
                        'warning' => 'rules',
                    ]),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('Порядок')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата загрузки')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип документа')
                    ->options([
                        'charter' => 'Устав',
                        'license' => 'Лицензия',
                        'rules' => 'Правила',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активен'),
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
            ->defaultSort('order', 'asc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCollegeDocuments::route('/'),
            'create' => Pages\CreateCollegeDocument::route('/create'),
            'edit' => Pages\EditCollegeDocument::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;
    }

    public static function canAccess(): bool
    {
        return true; 
    }
}