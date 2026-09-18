<?php

namespace App\Filament\Resources\HistoryTimelines;

use App\Filament\Resources\HistoryTimelines\Pages;
use App\Models\HistoryTimeline;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class HistoryTimelineResource extends Resource
{
    protected static ?string $model = HistoryTimeline::class;

    protected static ?string $navigationLabel = 'Таймлайн';
    protected static ?string $modelLabel = 'Событие таймлайна';
    protected static ?string $pluralModelLabel = 'События таймлайна';

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-clock';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Основная информация')
                ->schema([
                    Toggle::make('is_multilang')
                        ->label('Многоязычный контент')
                        ->default(true)
                        ->live()
                        ->helperText('Включите для контента на нескольких языках')
                        ->columnSpanFull(),
                ]),

            Section::make('Заголовок и описание')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    if ($isMultilang) {
                        return [
                            Tabs::make('translations')
                                ->tabs([
                                    Tab::make('Русский')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_ru')
                                                ->label('Заголовок на русском')
                                                ->required()
                                                ->maxLength(255)
                                                ->reactive()
                                                ->afterStateUpdated(function ($state, callable $set) {
                                                    $set('slug', Str::slug($state));
                                                })
                                                ->placeholder('Например: Основание колледжа')
                                                ->columnSpanFull(),
                                            
                                            RichEditor::make('description_ru')
                                                ->label('Описание на русском')
                                                ->nullable()
                                                ->placeholder('Подробное описание события...')
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'bulletList',
                                                    'orderedList',
                                                ])
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Атауы қазақша')
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Колледждің негізін қалау')
                                                ->columnSpanFull(),
                                            
                                            RichEditor::make('description_kk')
                                                ->label('Сипаттамасы қазақша')
                                                ->nullable()
                                                ->placeholder('Оқиғаның егжей-тегжейлі сипаттамасы...')
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'bulletList',
                                                    'orderedList',
                                                ])
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Title in English')
                                                ->maxLength(255)
                                                ->placeholder('For example: Foundation of the college')
                                                ->columnSpanFull(),
                                            
                                            RichEditor::make('description_en')
                                                ->label('Description in English')
                                                ->nullable()
                                                ->placeholder('Detailed description of the event...')
                                                ->toolbarButtons([
                                                    'bold',
                                                    'italic',
                                                    'link',
                                                    'bulletList',
                                                    'orderedList',
                                                ])
                                                ->columnSpanFull(),
                                        ]),
                                ])
                                ->columnSpanFull(),
                        ];
                    }
                    
                    return [
                        TextInput::make('title')
                            ->label('Заголовок')
                            ->required()
                            ->maxLength(255)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('slug', Str::slug($state));
                            })
                            ->placeholder('Например: Основание колледжа')
                            ->columnSpanFull(),

                        RichEditor::make('description')
                            ->label('Описание')
                            ->nullable()
                            ->placeholder('Подробное описание события...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'link',
                                'bulletList',
                                'orderedList',
                            ])
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Параметры события')
                ->schema([
                    TextInput::make('slug')
                        ->label('URL (слаг)')
                        ->required()
                        ->maxLength(255)
                        ->unique(HistoryTimeline::class, 'slug', ignoreRecord: true)
                        ->placeholder('osnovanie-kolledzha'),

                    DatePicker::make('date')
                        ->label('Дата события')
                        ->required()
                        ->displayFormat('d.m.Y')
                        ->native(false),

                    Select::make('position')
                        ->label('Позиция блока')
                        ->required()
                        ->default('left')
                        ->options([
                            'left' => 'Слева',
                            'right' => 'Справа',
                        ])
                        ->helperText('На какой стороне будет отображаться блок на таймлайне'),

                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->placeholder('0')
                        ->helperText('Чем меньше число, тем выше в списке'),
                ])->columns(2),

            Section::make('Настройки отображения')
                ->schema([
                    Toggle::make('is_active')
                        ->label('Активно')
                        ->default(true)
                        ->helperText('Отображать событие на сайте'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('№')
                    ->sortable()
                    ->toggleable()
                    ->width(50)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('date')
                    ->label('Дата')
                    ->date('d.m.Y')
                    ->sortable()
                    ->toggleable()
                    ->width(100),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->limit(50)
                    ->toggleable()
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        if ($record->is_multilang) {
                            $rawTitle = $record->getRawOriginal('title');
                            if (is_string($rawTitle)) {
                                try {
                                    $data = json_decode($rawTitle, true);
                                    return $data['ru'] ?? $state;
                                } catch (\Exception $e) {
                                    return $state;
                                }
                            }
                        }
                        return $state ?? 'Без названия';
                    }),

                Tables\Columns\TextColumn::make('position')
                    ->label('Позиция')
                    ->formatStateUsing(function ($state) {
                        return $state === 'left' ? 'Слева' : 'Справа';
                    })
                    ->badge()
                    ->color(function ($state) {
                        return $state === 'left' ? 'success' : 'warning';
                    })
                    ->toggleable()
                    ->width(100)
                    ->alignCenter(),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Статус')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->toggleable()
                    ->width(100)
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Статус')
                    ->placeholder('Все')
                    ->trueLabel('Активные')
                    ->falseLabel('Скрытые'),
                    
                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),
                    
                Tables\Filters\SelectFilter::make('position')
                    ->label('Позиция')
                    ->options([
                        'left' => 'Слева',
                        'right' => 'Справа',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkAction::make('delete')
                    ->label('Удалить выбранных')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion(),
                    
                BulkAction::make('activate')
                    ->label('Активировать')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['is_active' => true])))
                    ->deselectRecordsAfterCompletion(),
                    
                BulkAction::make('deactivate')
                    ->label('Скрыть')
                    ->icon('heroicon-o-eye-slash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each(fn ($record) => $record->update(['is_active' => false])))
                    ->deselectRecordsAfterCompletion(),
            ])
            ->defaultSort('order', 'asc')
            ->reorderable('order')
            ->striped();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHistoryTimelines::route('/'),
            'create' => Pages\CreateHistoryTimeline::route('/create'),
            'edit' => Pages\EditHistoryTimeline::route('/{record}/edit'),
        ];
    }
}