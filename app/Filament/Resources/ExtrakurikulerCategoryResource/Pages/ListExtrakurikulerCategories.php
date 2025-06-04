<?php

namespace App\Filament\Resources\ExtrakurikulerCategoryResource\Pages;

use App\Filament\Resources\ExtrakurikulerCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtrakurikulerCategories extends ListRecords
{
   protected static string $resource = ExtrakurikulerCategoryResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
