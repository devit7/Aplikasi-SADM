<?php

namespace App\Filament\Resources\StaffAccesResource\Pages;

use App\Filament\Resources\StaffAccesResource;
use App\Models\AlQuranLearningCategory;
use App\Models\Matapelajaran;
use App\Models\StaffAcces;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditStaffAcces extends EditRecord
{
    protected static string $resource = StaffAccesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        // Initialize repeater data arrays
        $data['mata_pelajaran'] = [];
        $data['alquran_subcategories'] = [];
        $data['extrakurikuler_categories'] = [];
        $data['worship_categories'] = [];

        // Add current matapelajaran as first item
        if ($record->matapelajaran_id) {
            $data['mata_pelajaran'][] = [
                'matapelajaran_id' => $record->matapelajaran_id,
            ];
        }

        // Find any other StaffAccess records for the same staff/kelas with other matapelajaran
        $otherAccess = StaffAcces::where('staff_id', $record->staff_id)
            ->where('kelas_id', $record->kelas_id)
            ->where('id', '!=', $record->id)
            ->get();

        foreach ($otherAccess as $access) {
            if ($access->matapelajaran_id) {
                $data['mata_pelajaran'][] = [
                    'matapelajaran_id' => $access->matapelajaran_id,
                ];
            }
        }

        // Prepare Al-Quran subcategory data
        $subcategories = $record->alQuranSubcategories()->with('category')->get();
        $subcategoriesByCategory = [];

        foreach ($subcategories as $subcategory) {
            $categoryId = $subcategory->category_id;
            if (!isset($subcategoriesByCategory[$categoryId])) {
                $subcategoriesByCategory[$categoryId] = [];
            }
            $subcategoriesByCategory[$categoryId][] = $subcategory->id;
        }

        foreach ($subcategoriesByCategory as $categoryId => $subcategoryIds) {
            $data['alquran_subcategories'][] = [
                'category_id' => $categoryId,
                'subcategory_ids' => $subcategoryIds,
            ];
        }

        // Prepare Extrakurikuler category data
        foreach ($record->extrakurikulerCategories as $category) {
            $data['extrakurikuler_categories'][] = [
                'category_id' => $category->id,
            ];
        }

        // Prepare Worship category data
        foreach ($record->worshipCategories as $category) {
            $data['worship_categories'][] = [
                'category_id' => $category->id,
            ];
        }

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        // Extract repeater data before updating main record
        $mataPelajaran = $data['mata_pelajaran'] ?? [];
        $alquranSubcategories = $data['alquran_subcategories'] ?? [];
        $extrakurikulerCategories = $data['extrakurikuler_categories'] ?? [];
        $worshipCategories = $data['worship_categories'] ?? [];

        // Remove repeater data from the main record
        unset($data['mata_pelajaran']);
        unset($data['alquran_subcategories']);
        unset($data['extrakurikuler_categories']);
        unset($data['worship_categories']);

        // Update main record
        if (!empty($mataPelajaran)) {
            $data['matapelajaran_id'] = $mataPelajaran[0]['matapelajaran_id'];
        } else {
            $data['matapelajaran_id'] = null;
        }

        $record->update($data);

        // Process Al-Quran subcategories
        $alQuranSubcategoryIds = [];
        foreach ($alquranSubcategories as $item) {
            if (isset($item['subcategory_ids']) && is_array($item['subcategory_ids'])) {
                foreach ($item['subcategory_ids'] as $subcategoryId) {
                    $alQuranSubcategoryIds[] = $subcategoryId;
                }
            }
        }
        $record->alQuranSubcategories()->sync($alQuranSubcategoryIds);

        // Process Extrakurikuler categories
        $extrakurikulerCategoryIds = [];
        foreach ($extrakurikulerCategories as $item) {
            if (isset($item['category_id'])) {
                $extrakurikulerCategoryIds[] = $item['category_id'];
            }
        }
        $record->extrakurikulerCategories()->sync($extrakurikulerCategoryIds);

        // Process Worship & Character categories
        $worshipCategoryIds = [];
        foreach ($worshipCategories as $item) {
            if (isset($item['category_id'])) {
                $worshipCategoryIds[] = $item['category_id'];
            }
        }
        $record->worshipCategories()->sync($worshipCategoryIds);

        // Handle mata pelajaran changes
        // First, delete all other staff access for the same staff/kelas except this record
        StaffAcces::where('staff_id', $record->staff_id)
            ->where('kelas_id', $record->kelas_id)
            ->where('id', '!=', $record->id)
            ->delete();

        // Then create new staff access records for each additional mata pelajaran
        if (count($mataPelajaran) > 1) {
            for ($i = 1; $i < count($mataPelajaran); $i++) {
                // Create a duplicate record with different mata pelajaran
                $newData = $data;
                $newData['matapelajaran_id'] = $mataPelajaran[$i]['matapelajaran_id'];

                $newRecord = StaffAcces::create([
                    'staff_id' => $record->staff_id,
                    'kelas_id' => $record->kelas_id,
                    'matapelajaran_id' => $newData['matapelajaran_id'],
                    'akses_nilai' => $record->akses_nilai,
                    'akses_absen' => $record->akses_absen,
                    'akses_alquran_learning' => $record->akses_alquran_learning,
                    'akses_extrakurikuler' => $record->akses_extrakurikuler,
                    'akses_worship_character' => $record->akses_worship_character,
                ]);

                // Copy the same relationships to the new record
                if (!empty($alQuranSubcategoryIds)) {
                    $newRecord->alQuranSubcategories()->sync($alQuranSubcategoryIds);
                }

                if (!empty($extrakurikulerCategoryIds)) {
                    $newRecord->extrakurikulerCategories()->sync($extrakurikulerCategoryIds);
                }

                if (!empty($worshipCategoryIds)) {
                    $newRecord->worshipCategories()->sync($worshipCategoryIds);
                }
            }
        }

        return $record;
    }
}
