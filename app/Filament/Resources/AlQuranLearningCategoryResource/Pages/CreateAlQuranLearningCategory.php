<?php

namespace App\Filament\Resources\AlQuranLearningCategoryResource\Pages;

use App\Filament\Resources\AlQuranLearningCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAlQuranLearningCategory extends CreateRecord
{
   protected static string $resource = AlQuranLearningCategoryResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
