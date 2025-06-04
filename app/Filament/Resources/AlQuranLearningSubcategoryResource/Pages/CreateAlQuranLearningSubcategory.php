<?php

namespace App\Filament\Resources\AlQuranLearningSubcategoryResource\Pages;

use App\Filament\Resources\AlQuranLearningSubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAlQuranLearningSubcategory extends CreateRecord
{
   protected static string $resource = AlQuranLearningSubcategoryResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
