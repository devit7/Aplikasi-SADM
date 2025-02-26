<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\DetailKelas;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\BulkAction;
use App\Models\Siswa;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ManageSiswa extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = KelasResource::class;
    protected static string $view = 'filament.resources.kelas-resource.pages.manage-siswa';

    public $record; // ID kelas yang sedang dikelola

    public function mount($record)
    {
        $this->record = $record;
    }
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Kembali')
                ->color('gray')
                ->url(fn() => KelasResource::getUrl('index')),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
        // Hanya siswa yang sudah masuk kelas
            ->query(fn() => Siswa::query()->whereHas('detailKelas', fn($query) =>
                $query->where('kelas_id', $this->record)))
            ->columns([
                TextColumn::make('nama')->label('Nama Siswa')->searchable(),
            ])
            /* ->bulkActions([
                BulkAction::make('add_to_kelas')
                    ->label('Tambahkan ke Kelas')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        foreach ($records as $siswa) {
                            DetailKelas::create([
                                'kelas_id' =>  $this->record,
                                'siswa_id' => $siswa->id,
                            ]);
                        }
                    })
                    ->successNotificationTitle('Siswa berhasil ditambahkan!'),
            ]) */;
    }
}
