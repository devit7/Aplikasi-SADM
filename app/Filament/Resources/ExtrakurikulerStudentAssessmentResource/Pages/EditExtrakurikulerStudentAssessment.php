<?php

namespace App\Filament\Resources\ExtrakurikulerStudentAssessmentResource\Pages;

use App\Filament\Resources\ExtrakurikulerStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtrakurikulerStudentAssessment extends EditRecord
{
   protected static string $resource = ExtrakurikulerStudentAssessmentResource::class;

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
