<?php

namespace App\Filament\Resources\StaffAccesResource\Pages;

use App\Filament\Resources\StaffAccesResource;
use App\Models\StaffAcces;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateStaffAcces extends CreateRecord
{
    protected static string $resource = StaffAccesResource::class;

    // Menyimpan relasi many-to-many secara manual
    protected function afterCreate(): void
    {
        $record = $this->record;

        // Extract the data for relationships
        $alQuranSubcategories = $this->data['al_quran_subcategories'] ?? [];
        $extrakurikulerCategories = $this->data['extrakurikuler_categories'] ?? [];
        $worshipCategories = $this->data['worship_categories'] ?? [];

        // Sync relationships
        if (!empty($alQuranSubcategories)) {
            $record->alQuranSubcategories()->sync($alQuranSubcategories);
        }

        if (!empty($extrakurikulerCategories)) {
            $record->extrakurikulerCategories()->sync($extrakurikulerCategories);
        }

        if (!empty($worshipCategories)) {
            $record->worshipCategories()->sync($worshipCategories);
        }
    }

    // Filter data sebelum disimpan untuk menghapus field yang tidak ada di database
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Remove custom fields from main data as they will be handled separately
        unset($data['al_quran_categories']);
        unset($data['al_quran_subcategories']);
        unset($data['extrakurikuler_categories']);
        unset($data['worship_categories']);

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Extract repeater data before saving main record
        $mataPelajaran = $data['mata_pelajaran'] ?? [];
        $alquranSubcategories = $data['alquran_subcategories'] ?? [];
        $extrakurikulerCategories = $data['extrakurikuler_categories'] ?? [];
        $worshipCategories = $data['worship_categories'] ?? [];

        // Remove repeater data from the main record
        unset($data['mata_pelajaran']);
        unset($data['alquran_subcategories']);
        unset($data['extrakurikuler_categories']);
        unset($data['worship_categories']);

        // Create main record (we'll use the first mata pelajaran if available)
        if (!empty($mataPelajaran)) {
            $data['matapelajaran_id'] = $mataPelajaran[0]['matapelajaran_id'];
        }

        $record = static::getModel()::create($data);

        // Process Al-Quran subcategories
        $alQuranSubcategoryIds = [];
        foreach ($alquranSubcategories as $item) {
            if (isset($item['subcategory_ids']) && is_array($item['subcategory_ids'])) {
                foreach ($item['subcategory_ids'] as $subcategoryId) {
                    $alQuranSubcategoryIds[] = $subcategoryId;
                }
            }
        }
        if (!empty($alQuranSubcategoryIds)) {
            $record->alQuranSubcategories()->sync($alQuranSubcategoryIds);
        }

        // Process Extrakurikuler categories
        $extrakurikulerCategoryIds = [];
        foreach ($extrakurikulerCategories as $item) {
            if (isset($item['category_id'])) {
                $extrakurikulerCategoryIds[] = $item['category_id'];
            }
        }
        if (!empty($extrakurikulerCategoryIds)) {
            $record->extrakurikulerCategories()->sync($extrakurikulerCategoryIds);
        }

        // Process Worship & Character categories
        $worshipCategoryIds = [];
        foreach ($worshipCategories as $item) {
            if (isset($item['category_id'])) {
                $worshipCategoryIds[] = $item['category_id'];
            }
        }
        if (!empty($worshipCategoryIds)) {
            $record->worshipCategories()->sync($worshipCategoryIds);
        }

        // Create additional staff access records for other mata pelajaran (if any)
        if (count($mataPelajaran) > 1) {
            for ($i = 1; $i < count($mataPelajaran); $i++) {
                // Create a duplicate record with different mata pelajaran
                $newData = $data;
                $newData['matapelajaran_id'] = $mataPelajaran[$i]['matapelajaran_id'];

                $newRecord = static::getModel()::create($newData);

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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
