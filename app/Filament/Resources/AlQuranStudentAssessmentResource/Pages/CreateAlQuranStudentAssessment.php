<?php

namespace App\Filament\Resources\AlQuranStudentAssessmentResource\Pages;

use App\Filament\Resources\AlQuranStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAlQuranStudentAssessment extends CreateRecord
{
   protected static string $resource = AlQuranStudentAssessmentResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
