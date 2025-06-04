<?php

namespace App\Filament\Resources\AlQuranLearningSubcategoryResource\Pages;

use App\Filament\Resources\AlQuranLearningSubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlQuranLearningSubcategory extends EditRecord
{
   protected static string $resource = AlQuranLearningSubcategoryResource::class;

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
