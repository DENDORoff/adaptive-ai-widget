<?php

namespace App\Filament\Resources\DashboardStatistics\Pages;

use App\Filament\Resources\DashboardStatistics\DashboardStatisticResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDashboardStatistic extends EditRecord
{
    protected static string $resource = DashboardStatisticResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
