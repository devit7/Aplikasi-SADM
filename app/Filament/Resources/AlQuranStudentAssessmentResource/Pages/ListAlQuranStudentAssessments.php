<?php

namespace App\Filament\Resources\AlQuranStudentAssessmentResource\Pages;

use App\Filament\Resources\AlQuranStudentAssessmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAlQuranStudentAssessments extends ListRecords
{
   protected static string $resource = AlQuranStudentAssessmentResource::class;

   protected function getHeaderActions(): array
   {
      return [
         Actions\CreateAction::make(),
      ];
   }
}
