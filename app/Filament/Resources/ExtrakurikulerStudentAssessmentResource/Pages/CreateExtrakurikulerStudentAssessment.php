<?php

namespace App\Filament\Resources\ExtrakurikulerStudentAssessmentResource\Pages;

use App\Filament\Resources\ExtrakurikulerStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExtrakurikulerStudentAssessment extends CreateRecord
{
   protected static string $resource = ExtrakurikulerStudentAssessmentResource::class;

   protected function getRedirectUrl(): string
   {
      return $this->getResource()::getUrl('index');
   }
}
