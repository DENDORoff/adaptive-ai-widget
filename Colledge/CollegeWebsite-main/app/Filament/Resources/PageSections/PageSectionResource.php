<?php

namespace App\Filament\Resources\PageSections;

use App\Filament\Resources\PageSections\Pages;
use App\Models\PageSection;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TagsInput;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class PageSectionResource extends Resource
{
    protected static ?string $model = PageSection::class;

    protected static ?string $navigationLabel = 'Контент страниц';
    protected static ?string $modelLabel = 'Секция страницы';
    protected static ?string $pluralModelLabel = 'Секции страниц';
    protected static ?int $navigationSort = 1;

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-document-text';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Контент';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Основная информация')
                    ->schema([
                        Select::make('page_key')
                            ->label('Страница')
                            ->required()
                            ->searchable()
                            ->options([
                                'home' => ' Главная',
                                'about' => ' О колледже',
                                'news' => ' Новости',
                                'staff' => ' Администрация',
                                'phonebook' => ' Контакты',
                                'achievements' => ' Достижения',
                                'vacancies' => 'Вакансии',
                                'footer' => 'Футер',
                                'faq' => 'Вопросы',
                                'blog' => 'Блог',
                                'library' => 'Библиотека',
                                'trade-union' => 'Профсоюз',
                                'layout' => 'Модальные окна',
                                'councils' => 'Советы при колледже',
                                'collaborations' => 'Коллаборации',
                                'curators' => 'Кураторы',
                                'government_services' => 'Гос.услуги',
                                'anticorruption' => 'Противодействие Коррупции',
                                'virtual-tour' => 'Виртуальный тур',
                                'news_show' => 'Страница новости',
                                'state_symbols' => 'Гос Символы',
                                'youth_movement' => 'Молодёжный Движ',
                                'header' => 'Шапка сайта',
                                'bug-report' => 'Отчёт об ошибке',
                                'cookies' => 'Куки',
                                'search' => 'Поиск',
                                'notifications' => 'Уведомления',
                                'weather' => 'Виджет погоды',
                                'chat' => 'Чат-бот',
                                'modals' => 'Модальные окна',
                                'navigation' => 'Навигация',
                                'global' => 'Глобальные элементы',
                                'dashboard' => 'Ситуационной центр',
                                'documents' => 'Документы',
                                'labor_protection' => 'Охрана труда',
                                'normative' => 'Нормативные документы',
                                'union_education' => 'Профсоюз',



                            ])
                            ->columnSpanFull(),

                        TextInput::make('section_key')
                            ->label('Ключ секции')
                            ->required()
                            ->helperText('Например: hero, stats, features')
                            ->placeholder('hero-section')
                            ->alphaDash()
                            ->maxLength(100),

                        TextInput::make('title')
                            ->label('Название секции')
                            ->required()
                            ->helperText('Отображается только в админке')
                            ->placeholder('Главный баннер')
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label('Описание')
                            ->helperText('Подсказка для администраторов')
                            ->placeholder('Главный баннер на странице с заголовком и кнопкой')
                            ->rows(2)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Активна')
                            ->default(true)
                            ->helperText('Отключите, чтобы скрыть секцию на сайте'),

                        Toggle::make('is_multilang')
                            ->label('Многоязычный контент')
                            ->default(true)
                            ->live()
                            ->helperText('Включите для контента на нескольких языках'),

                        TextInput::make('sort_order')
                            ->label('Порядок сортировки')
                            ->numeric()
                            ->default(0)
                            ->helperText('Чем меньше число, тем выше в списке'),
                    ]),

                Section::make('Контент')
                    ->schema([
                        Repeater::make('content')
                            ->label('Содержимое секции')
                            ->schema(function (Get $get) {
                                $isMultilang = $get('is_multilang');
                                
                                if ($isMultilang) {
                                    return [
                                        TextInput::make('key')
                                            ->label('Ключ поля')
                                            ->required()
                                            ->helperText('Например: title, description, button_text')
                                            ->disabled() 
                                            ->dehydrated() 
                                            ->afterStateHydrated(function (TextInput $component, $state) {
                                                $component->state($state);
                                            }),
                                        
                                        Tabs::make('translations')
                                            ->tabs([
                                                Tab::make('Русский')
                                                    ->icon('heroicon-o-language')
                                                    ->schema([
                                                        Textarea::make('ru')
                                                            ->label('Текст на русском')
                                                            ->rows(3)
                                                            ->required(),
                                                    ]),
                                                
                                                Tab::make('Қазақша')
                                                    ->icon('heroicon-o-language')
                                                    ->schema([
                                                        Textarea::make('kk')
                                                            ->label('Қазақ тіліндегі мәтін')
                                                            ->rows(3),
                                                    ]),
                                                
                                                Tab::make('English')
                                                    ->icon('heroicon-o-language')
                                                    ->schema([
                                                        Textarea::make('en')
                                                            ->label('Text in English')
                                                            ->rows(3),
                                                    ]),
                                            ])
                                            ->columnSpanFull(),
                                    ];
                                }
                                
                                return [
                                    TextInput::make('key')
                                        ->label('Ключ поля')
                                        ->required()
                                        ->disabled()
                                        ->dehydrated(),
                                    
                                    Textarea::make('value')
                                        ->label('Значение')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                ];
                            })
                            ->reorderable(false)
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => $state['key'] ?? null)
                            ->addActionLabel('+ Добавить поле')
                            ->columnSpanFull()
                            // УПРОЩАЕМ: просто получаем и устанавливаем состояние
                            ->afterStateHydrated(function (Repeater $component, ?array $state) {
                                Log::info('=== REPEATER afterStateHydrated ===');
                                Log::info('State:', ['state' => $state]);
                                
                                if (empty($state)) {
                                    $component->state([]);
                                    return;
                                }
                                
                                // Если данные пришли в ассоциативном формате из БД
                                $firstKey = key($state);
                                if (!is_numeric($firstKey) && is_array($state[$firstKey])) {
                                    Log::info('Detected associative array, converting...');
                                    $converted = [];
                                    foreach ($state as $key => $value) {
                                        if (is_array($value) && (isset($value['ru']) || isset($value['kk']) || isset($value['en']))) {
                                            $converted[] = [
                                                'key' => $key,
                                                'ru' => $value['ru'] ?? '',
                                                'kk' => $value['kk'] ?? '',
                                                'en' => $value['en'] ?? '',
                                            ];
                                        } else {
                                            $converted[] = [
                                                'key' => $key,
                                                'value' => $value,
                                            ];
                                        }
                                    }
                                    $component->state($converted);
                                } else {
                                    $component->state($state);
                                }
                            })
                            ->dehydrateStateUsing(function (?array $state, Get $get): array {
                                Log::info('=== REPEATER dehydrateStateUsing CORRECT ===');
                                Log::info('State:', ['state' => $state]);
                                
                                if (empty($state)) {
                                    return [];
                                }
                                
                                $result = [];
                                $isMultilang = $get('is_multilang');
                                
                                foreach ($state as $item) {
                                    $key = $item['key'] ?? null;
                                    
                                    if (!$key) {
                                        Log::warning('Item without key:', ['item' => $item]);
                                        continue;
                                    }
                                    
                                    if ($isMultilang) {
                                        $result[] = [
                                            'key' => $key,
                                            'ru' => $item['ru'] ?? '',
                                            'kk' => $item['kk'] ?? '',
                                            'en' => $item['en'] ?? '',
                                        ];
                                    } else {
                                        $result[] = [
                                            'key' => $key,
                                            'value' => $item['value'] ?? '',
                                        ];
                                    }
                                }
                                
                                Log::info('Result (Repeater format):', ['result' => $result]);
                                return $result;
                            })
                            ->default([]),
                    ]),

                Section::make('SEO')
                    ->schema([
                        TextInput::make('meta_title')
                            ->label('Meta Title')
                            ->maxLength(60)
                            ->helperText('Рекомендуется до 60 символов'),

                        Textarea::make('meta_description')
                            ->label('Meta Description')
                            ->maxLength(160)
                            ->rows(3)
                            ->helperText('Рекомендуется до 160 символов'),

                        TagsInput::make('meta_keywords')
                            ->label('Ключевые слова')
                            ->separator(',')
                            ->helperText('Через запятую'),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        Log::info('=== PageSectionResource::table() method called ===');

        $directCount = PageSection::count();
        Log::info("Direct PageSection::count() result: {$directCount} records");

        return $table
            ->query(function () {
                Log::info('--- Filament table query() closure executing ---');
                
                $query = PageSection::query();
                
                Log::info("Generated SQL: " . $query->toSql());
                
                $result = $query->get();
                Log::info("Query result count inside closure: " . $result->count());
                
                return $query;
            })
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('page_key')
                    ->label('Страница')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match($state) {
                        'home' => 'primary',
                        'about' => 'info',
                        'news' => 'success',
                        'staff' => 'warning',
                        'phonebook' => 'danger',
                        'achievements' => 'gray',
                        'vacancies' => 'secondary',
                        'footer' => 'gray',
                        'faq' => 'info',
                        'blog' => 'success',
                        'library' => 'warning',
                        'trade-union' => 'danger',
                        'layout' => 'gray',
                        'councils' => 'primary',
                        'collaborations' => 'info',
                        'curators' => 'success',
                        'government_services' => 'warning',
                        'anticorruption' => 'danger',
                        'virtual-tour' => 'gray',
                        'news_show' => 'primary',
                        'state_symbols' => 'info',
                        'youth_movement' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('section_key')
                    ->label('Секция')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Название')
                    ->searchable()
                    ->sortable()
                    ->limit(30),

                Tables\Columns\IconColumn::make('is_multilang')
                    ->label('🌍')
                    ->boolean()
                    ->tooltip('Многоязычный контент'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активна')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Порядок')
                    ->numeric()
                    ->sortable()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('content')
                    ->label('Контент')
                    ->formatStateUsing(fn ($state): string =>
                        is_array($state) ? count($state) . ' элементов' : '0 элементов'
                    )
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Обновлено')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([])
            ->defaultSort('id', 'desc')
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPageSections::route('/'),
            'create' => Pages\CreatePageSection::route('/create'),
            'edit' => Pages\EditPageSection::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('is_active', true)->count();
        Log::info("Navigation badge count (active only): {$count}");
        return (string) $count;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'success';
    }
}