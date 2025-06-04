<?php

namespace App\Filament\Resources\ExtrakurikulerCategoryResource\Pages;

use App\Filament\Resources\ExtrakurikulerCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExtrakurikulerCategory extends CreateRecord
{
   protected static string $resource = ExtrakurikulerCategoryResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
