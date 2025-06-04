<?php

namespace App\Filament\Resources\AlQuranLearningCategoryResource\Pages;

use App\Filament\Resources\AlQuranLearningCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlQuranLearningCategories extends ListRecords
{
   protected static string $resource = AlQuranLearningCategoryResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
