<?php

namespace App\Filament\Resources\AlQuranLearningSubcategoryResource\Pages;

use App\Filament\Resources\AlQuranLearningSubcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlQuranLearningSubcategories extends ListRecords
{
   protected static string $resource = AlQuranLearningSubcategoryResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
