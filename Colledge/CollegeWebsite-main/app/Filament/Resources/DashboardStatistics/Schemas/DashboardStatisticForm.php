<?php

namespace App\Filament\Resources\DashboardStatistics\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DashboardStatisticForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->required(),
                TextInput::make('value')
                    ->required(),
                TextInput::make('category')
                    ->required(),
                TextInput::make('label')
                    ->required(),
                TextInput::make('description'),
                TextInput::make('type')
                    ->required()
                    ->default('number'),
                TextInput::make('calculation_formula'),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('auto_update')
                    ->required(),
                TextInput::make('update_source'),
                TextInput::make('previous_value'),
                TextInput::make('growth_percentage')
                    ->numeric(),
                DateTimePicker::make('last_updated_at'),
            ]);
    }
}
