<?php

namespace App\Filament\Resources\StudentCourseEnrollmentResource\Pages;

use App\Filament\Resources\StudentCourseEnrollmentResource;
use Filament\Resources\Pages\EditRecord;
use App\Models\AlQuranLearningSubcategory;
use App\Models\ExtrakurikulerCategory;
use App\Models\WorshipCharacterCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditStudentCourseEnrollment extends EditRecord
{
    protected static string $resource = StudentCourseEnrollmentResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $siswa = $this->record;

        // Initialize arrays
        $data['alquran_courses'] = [];
        $data['extrakurikuler_courses'] = [];
        $data['worship_courses'] = [];

        // Al-Quran Courses
        foreach ($siswa->alQuranCourses as $subcategory) {
            $data['alquran_courses'][] = [
                'category_id' => $subcategory->category_id,
                'subcategory_id' => $subcategory->id,
            ];
        }

        // Extrakurikuler Courses
        foreach ($siswa->extrakurikulerCourses as $category) {
            $data['extrakurikuler_courses'][] = [
                'category_id' => $category->id,
            ];
        }

        // Worship Courses
        foreach ($siswa->worshipCourses as $category) {
            $data['worship_courses'][] = [
                'category_id' => $category->id,
            ];
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove course data from main record as they will be handled separately
        unset($data['alquran_courses']);
        unset($data['extrakurikuler_courses']);
        unset($data['worship_courses']);

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        DB::beginTransaction();
        
        try {
            // Update basic siswa data first
            $siswaData = $data;
            unset($siswaData['alquran_courses']);
            unset($siswaData['extrakurikuler_courses']);
            unset($siswaData['worship_courses']);
            
            $record->update($siswaData);

            // Process course enrollments with original data
            $this->processAlQuranCourses($record, $this->data);
            $this->processExtrakurikulerCourses($record, $this->data);
            $this->processWorshipCourses($record, $this->data);

            DB::commit();
            
            return $record;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function processAlQuranCourses($siswa, array $data): void
    {
        $alQuranSubcategoryIds = [];
        $userId = Auth::id();

        foreach ($data['alquran_courses'] ?? [] as $course) {
            if (isset($course['subcategory_id'])) {
                $alQuranSubcategoryIds[$course['subcategory_id']] = [
                    'assigned_by' => $userId
                ];
            }
        }

        $siswa->alQuranCourses()->sync($alQuranSubcategoryIds);
    }

    protected function processExtrakurikulerCourses($siswa, array $data): void
    {
        $extraCategoryIds = [];
        $userId = Auth::id();

        foreach ($data['extrakurikuler_courses'] ?? [] as $course) {
            if (isset($course['category_id'])) {
                $extraCategoryIds[$course['category_id']] = [
                    'assigned_by' => $userId
                ];
            }
        }

        $siswa->extrakurikulerCourses()->sync($extraCategoryIds);
    }

    protected function processWorshipCourses($siswa, array $data): void
    {
        $worshipCategoryIds = [];
        $userId = Auth::id();

        foreach ($data['worship_courses'] ?? [] as $course) {
            if (isset($course['category_id'])) {
                $worshipCategoryIds[$course['category_id']] = [
                    'assigned_by' => $userId
                ];
            }
        }

        $siswa->worshipCourses()->sync($worshipCategoryIds);
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
