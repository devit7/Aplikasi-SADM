<?php

namespace App\Filament\Resources\MatapelajaranResource\Pages;

use App\Filament\Resources\MatapelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMatapelajaran extends CreateRecord
{
    protected static string $resource = MatapelajaranResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
