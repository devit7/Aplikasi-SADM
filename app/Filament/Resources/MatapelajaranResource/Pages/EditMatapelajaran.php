<?php

namespace App\Filament\Resources\MatapelajaranResource\Pages;

use App\Filament\Resources\MatapelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMatapelajaran extends EditRecord
{
    protected static string $resource = MatapelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
