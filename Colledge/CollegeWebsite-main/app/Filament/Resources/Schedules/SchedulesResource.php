<?php

namespace App\Filament\Resources\Schedules;

use App\Filament\Resources\Schedules\Pages;
use App\Models\Schedule;
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

class SchedulesResource extends Resource
{
    protected static ?string $model = Schedule::class;

    protected static ?string $navigationLabel = 'Расписание занятий';
    protected static ?string $modelLabel = 'Расписание';
    protected static ?string $pluralModelLabel = 'Расписания';
    
    protected static ?int $navigationSort = 3;

    public static function getNavigationIcon(): string|null
    {
        return 'heroicon-o-calendar';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Информация о расписании')
                ->schema([
                    TextInput::make('title')
                        ->label('Название')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Например: Расписание занятий на осенний семестр 2025')
                        ->columnSpanFull(),
                    
                    Select::make('type')
                        ->label('Тип расписания')
                        ->options([
                            'lessons' => 'Расписание занятий',
                            'bells' => 'Расписание звонков',
                        ])
                        ->required()
                        ->default('lessons')
                        ->helperText('Выберите тип расписания')
                        ->columnSpanFull(),
                    
                    FileUpload::make('file_path')
                        ->label('PDF файл расписания')
                        ->disk('public_files')
                        ->directory('schedules')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(10240)
                        ->required()
                        ->helperText('Загрузите PDF файл (макс. 10 МБ)')
                        ->columnSpanFull(),
                    
                    Toggle::make('is_active')
                        ->label('Активно (отображать на сайте)')
                        ->default(true)
                        ->helperText('Только одно активное расписание будет отображаться на главной странице')
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
                        'lessons' => 'Занятия',
                        'bells' => 'Звонки',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'lessons',
                        'success' => 'bells',
                    ]),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активно')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата загрузки')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активно'),
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
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSchedules::route('/'),
            'create' => Pages\CreateSchedules::route('/create'),
            'edit' => Pages\EditSchedules::route('/{record}/edit'),
        ];
    }
}