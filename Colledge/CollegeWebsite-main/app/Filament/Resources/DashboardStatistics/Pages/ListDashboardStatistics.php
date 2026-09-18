<?php

namespace App\Filament\Resources\DashboardStatistics\Pages;

use App\Filament\Resources\DashboardStatistics\DashboardStatisticResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDashboardStatistics extends ListRecords
{
    protected static string $resource = DashboardStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
