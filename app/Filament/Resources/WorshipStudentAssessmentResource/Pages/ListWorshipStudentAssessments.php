<?php

namespace App\Filament\Resources\WorshipStudentAssessmentResource\Pages;

use App\Filament\Resources\WorshipStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWorshipStudentAssessments extends ListRecords
{
   protected static string $resource = WorshipStudentAssessmentResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
