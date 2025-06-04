<?php

namespace App\Filament\Resources\ExtrakurikulerStudentAssessmentResource\Pages;

use App\Filament\Resources\ExtrakurikulerStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtrakurikulerStudentAssessments extends ListRecords
{
   protected static string $resource = ExtrakurikulerStudentAssessmentResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
