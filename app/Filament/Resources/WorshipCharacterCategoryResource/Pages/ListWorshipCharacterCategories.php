<?php

namespace App\Filament\Resources\WorshipCharacterCategoryResource\Pages;

use App\Filament\Resources\WorshipCharacterCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorshipCharacterCategories extends ListRecords
{
   protected static string $resource = WorshipCharacterCategoryResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
