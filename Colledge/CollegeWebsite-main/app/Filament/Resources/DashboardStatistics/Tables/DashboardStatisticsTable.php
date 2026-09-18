<?php

namespace App\Filament\Resources\DashboardStatistics\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DashboardStatisticsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable(),
                TextColumn::make('value')
                    ->searchable(),
                TextColumn::make('category')
                    ->searchable(),
                TextColumn::make('label')
                    ->searchable(),
                TextColumn::make('description')
                    ->searchable(),
                TextColumn::make('type')
                    ->searchable(),
                TextColumn::make('calculation_formula')
                    ->searchable(),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('auto_update')
                    ->boolean(),
                TextColumn::make('update_source')
                    ->searchable(),
                TextColumn::make('previous_value')
                    ->searchable(),
                TextColumn::make('growth_percentage')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('last_updated_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
