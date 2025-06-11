<?php

namespace App\Filament\Resources\StudentCourseEnrollmentResource\Pages;

use App\Filament\Resources\StudentCourseEnrollmentResource;
use Filament\Resources\Pages\ListRecords;

class ListStudentCourseEnrollments extends ListRecords
{
    protected static string $resource = StudentCourseEnrollmentResource::class;

    protected function getTableEmptyStateHeading(): ?string
    {
        return 'No students found';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'You need to assign students to courses.';
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'heroicon-o-academic-cap';
    }
}
