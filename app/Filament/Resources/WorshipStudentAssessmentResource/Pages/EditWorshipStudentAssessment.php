<?php

namespace App\Filament\Resources\WorshipStudentAssessmentResource\Pages;

use App\Filament\Resources\WorshipStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWorshipStudentAssessment extends EditRecord
{
   protected static string $resource = WorshipStudentAssessmentResource::class;

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
