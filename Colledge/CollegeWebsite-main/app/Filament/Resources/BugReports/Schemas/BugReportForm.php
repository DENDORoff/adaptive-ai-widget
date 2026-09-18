<?php

namespace App\Filament\Resources\BugReports\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class BugReportForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->numeric(),
                TextInput::make('full_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('page_url')
                    ->url(),
                TextInput::make('browser'),
                TextInput::make('os'),
                TextInput::make('device'),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('steps_to_reproduce'),
                Textarea::make('expected_result')
                    ->columnSpanFull(),
                Textarea::make('actual_result')
                    ->columnSpanFull(),
                TextInput::make('priority')
                    ->required()
                    ->default('medium'),
                TextInput::make('status')
                    ->required()
                    ->default('new'),
                Textarea::make('admin_comment')
                    ->columnSpanFull(),
                DateTimePicker::make('resolved_at'),
            ]);
    }
}
