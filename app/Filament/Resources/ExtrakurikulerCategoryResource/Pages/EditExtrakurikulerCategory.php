<?php

namespace App\Filament\Resources\ExtrakurikulerCategoryResource\Pages;

use App\Filament\Resources\ExtrakurikulerCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtrakurikulerCategory extends EditRecord
{
   protected static string $resource = ExtrakurikulerCategoryResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\DeleteAction::make(),
         Actions\RestoreAction::make(),
      ];
   }

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
