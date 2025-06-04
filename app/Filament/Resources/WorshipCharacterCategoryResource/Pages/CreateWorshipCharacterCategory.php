<?php

namespace App\Filament\Resources\WorshipCharacterCategoryResource\Pages;

use App\Filament\Resources\WorshipCharacterCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorshipCharacterCategory extends CreateRecord
{
   protected static string $resource = WorshipCharacterCategoryResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
