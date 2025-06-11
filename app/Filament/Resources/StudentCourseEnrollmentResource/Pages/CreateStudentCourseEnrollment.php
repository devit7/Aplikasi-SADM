<?php

namespace App\Filament\Resources\StudentCourseEnrollmentResource\Pages;

use App\Filament\Resources\StudentCourseEnrollmentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;

class CreateStudentCourseEnrollment extends CreateRecord
{
    protected static string $resource = StudentCourseEnrollmentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Keep only siswa data for main record creation
        $siswaData = [];
        if (isset($data['siswa_id'])) {
            $siswaData['siswa_id'] = $data['siswa_id'];
        }

        return $siswaData;
    }

    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        DB::beginTransaction();
        
        try {
            // Get the selected siswa
            $siswa = Siswa::find($data['siswa_id']);
            
            if (!$siswa) {
                throw new \Exception('Siswa tidak ditemukan');
            }

            // Process course enrollments
            $this->processAlQuranCourses($siswa, $data);
            $this->processExtrakurikulerCourses($siswa, $data);
            $this->processWorshipCourses($siswa, $data);

            DB::commit();
            
            return $siswa;
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

        if (!empty($alQuranSubcategoryIds)) {
            $siswa->alQuranCourses()->sync($alQuranSubcategoryIds);
        }
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

        if (!empty($extraCategoryIds)) {
            $siswa->extrakurikulerCourses()->sync($extraCategoryIds);
        }
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

        if (!empty($worshipCategoryIds)) {
            $siswa->worshipCourses()->sync($worshipCategoryIds);
        }
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
