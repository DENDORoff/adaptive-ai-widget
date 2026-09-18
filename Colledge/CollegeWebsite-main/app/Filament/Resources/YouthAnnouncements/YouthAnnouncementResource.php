<?php

namespace App\Filament\Resources\YouthAnnouncements;

use App\Filament\Resources\YouthAnnouncements\Pages;
use App\Models\YouthAnnouncement;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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

class YouthAnnouncementResource extends Resource
{
    protected static ?string $model = YouthAnnouncement::class;

    protected static ?string $navigationLabel = 'Объявления молодежи';
    protected static ?string $modelLabel = 'Объявление';
    protected static ?string $pluralModelLabel = 'Объявления';
    
    protected static ?int $navigationSort = 21;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-megaphone';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Молодежное движение';
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            $active = static::getModel()::where('is_published', true)
                ->where(function ($query) {
                    $query->whereNull('expires_at')
                        ->orWhere('expires_at', '>', now());
                })
                ->count();
            return $active > 0 ? (string)$active : null;
        } catch (\Exception $e) {
            return null;
        }
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

            Section::make('Содержание объявления')
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
                                                ->placeholder('Например: Открыта регистрация на студенческий конкурс')
                                                ->columnSpanFull(),

                                            Textarea::make('content_ru')
                                                ->label('Текст объявления на русском')
                                                ->required()
                                                ->rows(4)
                                                ->maxLength(2000)
                                                ->placeholder('Подробная информация об объявлении')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('Қазақша')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_kk')
                                                ->label('Қазақша тақырыбы')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('Мысалы: Студенттік байқауға тіркелу ашылды')
                                                ->columnSpanFull(),

                                            Textarea::make('content_kk')
                                                ->label('Қазақша мәлімдеме мәтіні')
                                                ->required()
                                                ->rows(4)
                                                ->maxLength(2000)
                                                ->placeholder('Мәлімдеме туралы егжей-тегжейлі ақпарат')
                                                ->columnSpanFull(),
                                        ]),
                                    
                                    Tab::make('English')
                                        ->icon('heroicon-o-language')
                                        ->schema([
                                            TextInput::make('title_en')
                                                ->label('Title in English')
                                                ->required()
                                                ->maxLength(255)
                                                ->placeholder('For example: Registration for student competition is open')
                                                ->columnSpanFull(),

                                            Textarea::make('content_en')
                                                ->label('Announcement text in English')
                                                ->required()
                                                ->rows(4)
                                                ->maxLength(2000)
                                                ->placeholder('Detailed information about the announcement')
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
                            ->placeholder('Например: Открыта регистрация на студенческий конкурс')
                            ->columnSpanFull(),

                        Textarea::make('content')
                            ->label('Текст объявления')
                            ->required()
                            ->rows(4)
                            ->maxLength(2000)
                            ->placeholder('Подробная информация об объявлении')
                            ->columnSpanFull(),
                    ];
                }),

            Section::make('Оформление')
                ->schema([
                    Select::make('type')
                        ->label('Тип объявления')
                        ->options([
                            'info' => '💙 Информация (синий)',
                            'warning' => '⚠️ Предупреждение (желтый)',
                            'success' => '✅ Успех (зеленый)',
                            'danger' => '🔴 Важно (красный)',
                        ])
                        ->required()
                        ->default('info')
                        ->helperText('Определяет цвет объявления'),

                    Select::make('icon')
                        ->label('Иконка')
                        ->options([
                            '📢' => '📢 Мегафон',
                            '❗' => '❗ Восклицательный знак',
                            'ℹ️' => 'ℹ️ Информация',
                            '🔔' => '🔔 Звонок',
                            '⭐' => '⭐ Звезда',
                            '📅' => '📅 Календарь',
                            '🏆' => '🏆 Кубок',
                            '🔥' => '🔥 Огонь',
                        ])
                        ->default('📢')
                        ->searchable(),
                ])->columns(2),

            Section::make('Действие')
                ->schema(function (Get $get) {
                    $isMultilang = $get('is_multilang');
                    
                    $schema = [
                        TextInput::make('action_url')
                            ->label('Ссылка кнопки')
                            ->url()
                            ->maxLength(500)
                            ->placeholder('https://example.com')
                            ->helperText('Куда ведет кнопка')
                            ->columnSpanFull(),
                    ];
                    
                    if ($isMultilang) {
                        $schema[] = TextInput::make('action_text_ru')
                            ->label('Текст кнопки на русском')
                            ->maxLength(50)
                            ->placeholder('Например: Подробнее');
                            
                        $schema[] = TextInput::make('action_text_kk')
                            ->label('Түйменің мәтіні қазақша')
                            ->maxLength(50)
                            ->placeholder('Мысалы: Толығырақ');
                            
                        $schema[] = TextInput::make('action_text_en')
                            ->label('Button text in English')
                            ->maxLength(50)
                            ->placeholder('For example: Details');
                    } else {
                        array_unshift($schema, 
                            TextInput::make('action_text')
                                ->label('Текст кнопки')
                                ->maxLength(50)
                                ->placeholder('Например: Подробнее')
                                ->helperText('Если указан, появится кнопка в объявлении')
                                ->columnSpanFull()
                        );
                    }
                    
                    return $schema;
                })
                ->columns(function (Get $get) {
                    return $get('is_multilang') ?? false ? 3 : 2;
                }),

            Section::make('Приоритет и видимость')
                ->schema([
                    Select::make('priority')
                        ->label('Приоритет')
                        ->options([
                            'urgent' => '🔴 Срочно',
                            'high' => '🟠 Высокий',
                            'normal' => '🟢 Обычный',
                            'low' => '🔵 Низкий',
                        ])
                        ->required()
                        ->default('normal')
                        ->helperText('Влияет на порядок отображения'),

                    Toggle::make('is_pinned')
                        ->label('Закрепить')
                        ->helperText('Закрепленные объявления всегда вверху списка'),

                    Toggle::make('is_published')
                        ->label('Опубликовано')
                        ->default(false)
                        ->helperText('Отображать на сайте'),
                ])->columns(3),

            Section::make('Сортировка')
                ->schema([
                    TextInput::make('order')
                        ->label('Порядок сортировки')
                        ->numeric()
                        ->default(0)
                        ->helperText('Чем меньше число, тем выше в списке'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('Иконка')
                    ->formatStateUsing(fn ($state) => is_string($state) ? $state : '')
                    ->alignCenter()
                    ->size('lg'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Заголовок')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
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
                        return $state ?? 'Без заголовка';
                    }),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Тип')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'info' => 'Информация',
                        'warning' => 'Предупреждение',
                        'success' => 'Успех',
                        'danger' => 'Важно',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'info',
                        'warning' => 'warning',
                        'success' => 'success',
                        'danger' => 'danger',
                    ]),

                Tables\Columns\BadgeColumn::make('priority')
                    ->label('Приоритет')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'urgent' => 'Срочно',
                        'high' => 'Высокий',
                        'normal' => 'Обычный',
                        'low' => 'Низкий',
                        default => $state,
                    })
                    ->colors([
                        'danger' => 'urgent',
                        'warning' => 'high',
                        'success' => 'normal',
                        'secondary' => 'low',
                    ]),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->toggleable()
                    ->width(80)
                    ->tooltip('Многоязычный'),

                Tables\Columns\IconColumn::make('is_pinned')
                    ->label('Закреплено')
                    ->boolean()
                    ->trueIcon('heroicon-o-bookmark')
                    ->falseIcon('heroicon-o-bookmark')
                    ->trueColor('warning')
                    ->falseColor('gray')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Опубликовано')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Создано')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('expires_at')
                    ->label('Истекает')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->color(fn ($state) => $state && $state < now() ? 'danger' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип')
                    ->options([
                        'info' => 'Информация',
                        'warning' => 'Предупреждение',
                        'success' => 'Успех',
                        'danger' => 'Важно',
                    ]),

                Tables\Filters\SelectFilter::make('priority')
                    ->label('Приоритет')
                    ->options([
                        'urgent' => 'Срочно',
                        'high' => 'Высокий',
                        'normal' => 'Обычный',
                        'low' => 'Низкий',
                    ]),

                Tables\Filters\TernaryFilter::make('is_multilang')
                    ->label('Многоязычный')
                    ->placeholder('Все')
                    ->trueLabel('Только многоязычные')
                    ->falseLabel('Только одноязычные'),

                Tables\Filters\TernaryFilter::make('is_pinned')
                    ->label('Закрепленные'),

                Tables\Filters\TernaryFilter::make('is_published')
                    ->label('Публикация'),

                Tables\Filters\Filter::make('active')
                    ->label('Активные (не истекшие)')
                    ->query(fn ($query) => $query->where('is_published', true)
                        ->where(function ($q) {
                            $q->whereNull('expires_at')
                                ->orWhere('expires_at', '>', now());
                        })),

                Tables\Filters\Filter::make('expired')
                    ->label('Истекшие')
                    ->query(fn ($query) => $query->whereNotNull('expires_at')->where('expires_at', '<', now())),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('publish')
                    ->label('Опубликовать')
                    ->icon('heroicon-o-check-circle')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_published' => true])
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('success'),

                BulkAction::make('unpublish')
                    ->label('Снять с публикации')
                    ->icon('heroicon-o-x-circle')
                    ->action(fn (Collection $records) => 
                        $records->each->update(['is_published' => false])
                    )
                    ->deselectRecordsAfterCompletion()
                    ->color('warning'),

                BulkAction::make('delete')
                    ->label('Удалить выбранные')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete())
                    ->deselectRecordsAfterCompletion()
                    ->color('danger'),
            ])
            ->defaultSort('is_pinned', 'desc')
            ->reorderable('order');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListYouthAnnouncements::route('/'),
            'create' => Pages\CreateYouthAnnouncement::route('/create'),
            'edit' => Pages\EditYouthAnnouncement::route('/{record}/edit'),
        ];
    }
}