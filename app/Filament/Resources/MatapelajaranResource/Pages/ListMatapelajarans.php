<?php

namespace App\Filament\Resources\MatapelajaranResource\Pages;

use App\Filament\Resources\MatapelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMatapelajarans extends ListRecords
{
    protected static string $resource = MatapelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
