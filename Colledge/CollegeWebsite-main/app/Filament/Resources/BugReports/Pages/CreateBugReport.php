<?php

namespace App\Filament\Resources\BugReports\Pages;

use App\Filament\Resources\BugReports\BugReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBugReport extends CreateRecord
{
    protected static string $resource = BugReportResource::class;
}
