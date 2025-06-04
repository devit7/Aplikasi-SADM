<?php

namespace App\Filament\Resources\AlQuranLearningCategoryResource\Pages;

use App\Filament\Resources\AlQuranLearningCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlQuranLearningCategory extends EditRecord
{
   protected static string $resource = AlQuranLearningCategoryResource::class;

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
