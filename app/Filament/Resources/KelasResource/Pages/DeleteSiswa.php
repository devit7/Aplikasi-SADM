<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use App\Models\DetailKelas;
use App\Models\Kelas;
use Filament\Resources\Pages\Page;
use Filament\Tables\Actions\BulkAction;
use App\Models\Siswa;
use Faker\Provider\ar_EG\Text;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action as TableAction;

class DeleteSiswa extends Page implements HasTable, HasForms
{
    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = KelasResource::class;
    protected static string $view = 'filament.resources.kelas-resource.pages.delete-siswa';
    protected static ?string $title = 'Hapus Siswa';
    public $record; // ID kelas yang sedang dikelola
    public $nama_kelas;

    public function mount($record)
    {
        $this->record = $record;
        $this->nama_kelas = Kelas::find($record)->nama_kelas;
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
                TextColumn::make('nis')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nisn')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('jenis_kelamin')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tempat_lahir')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_lahir')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('tanggal_masuk')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('alamat')
                    ->searchable()
                    ->limit(20)
                    ->sortable(),

            ])
            ->bulkActions([
                BulkAction::make('remove_from_kelas')
                    ->label('Hapus dari Kelas')
                    ->requiresConfirmation()
                    ->action(function ($records) {
                        foreach ($records as $siswa) {
                            DetailKelas::where('kelas_id', $this->record)
                                ->where('siswa_id', $siswa->id)
                                ->delete();
                        }
                    })
                    ->successNotificationTitle('Siswa berhasil dihapus dari kelas!'),
            ])
            ->filters([
                //
            ])
            ->actions([
                TableAction::make('remove_from_kelas')
                    ->label('Hapus dari Kelas')
                    ->icon('heroicon-o-trash')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        DetailKelas::where('kelas_id', $this->record)
                            ->where('siswa_id', $record->id)
                            ->delete();
                    })
                    ->successNotificationTitle('Siswa berhasil dihapus dari kelas!'),
            ]);
    }
}
