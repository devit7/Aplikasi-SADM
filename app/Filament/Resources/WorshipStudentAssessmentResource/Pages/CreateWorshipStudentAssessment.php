<?php

namespace App\Filament\Resources\WorshipStudentAssessmentResource\Pages;

use App\Filament\Resources\WorshipStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorshipStudentAssessment extends CreateRecord
{
   protected static string $resource = WorshipStudentAssessmentResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
