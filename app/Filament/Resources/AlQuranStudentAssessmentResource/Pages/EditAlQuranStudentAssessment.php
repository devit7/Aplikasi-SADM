<?php

namespace App\Filament\Resources\AlQuranStudentAssessmentResource\Pages;

use App\Filament\Resources\AlQuranStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAlQuranStudentAssessment extends EditRecord
{
   protected static string $resource = AlQuranStudentAssessmentResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\DeleteAction::make(),
      ];
   }

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
