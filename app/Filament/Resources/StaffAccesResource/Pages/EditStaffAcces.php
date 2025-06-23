<?php

namespace App\Filament\Resources\StaffAccesResource\Pages;

use App\Filament\Resources\StaffAccesResource;
use App\Models\StaffAcces;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditStaffAcces extends EditRecord
{
    protected static string $resource = StaffAccesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function beforeSave(): void
    {
        $data = $this->data;

        // Validasi duplikasi data (exclude current record)
        $exists = StaffAcces::where('staff_id', $data['staff_id'])
            ->where('kelas_id', $data['kelas_id'])
            ->where('matapelajaran_id', $data['matapelajaran_id'])
            ->where('id', '!=', $this->record->id)
            ->exists();

        if ($exists) {
            $staff = \App\Models\Staff::find($data['staff_id']);
            $kelas = \App\Models\Kelas::find($data['kelas_id']);
            $matapelajaran = \App\Models\Matapelajaran::find($data['matapelajaran_id']);

            Notification::make()
                ->title('Data Duplikat')
                ->body("Staff {$staff->nama} sudah memiliki akses untuk mata pelajaran {$matapelajaran->nama_mapel} di kelas {$kelas->nama_kelas}")
                ->danger()
                ->send();

            $this->halt();
        }
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Staff Access berhasil diperbarui';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
