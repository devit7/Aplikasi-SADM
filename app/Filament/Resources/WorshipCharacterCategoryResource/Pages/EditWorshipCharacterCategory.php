<?php

namespace App\Filament\Resources\WorshipCharacterCategoryResource\Pages;

use App\Filament\Resources\WorshipCharacterCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorshipCharacterCategory extends EditRecord
{
   protected static string $resource = WorshipCharacterCategoryResource::class;

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
