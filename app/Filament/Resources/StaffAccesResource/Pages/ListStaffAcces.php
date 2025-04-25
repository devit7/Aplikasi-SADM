<?php

namespace App\Filament\Resources\StaffAccesResource\Pages;

use App\Filament\Resources\StaffAccesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaffAcces extends ListRecords
{
    protected static string $resource = StaffAccesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
