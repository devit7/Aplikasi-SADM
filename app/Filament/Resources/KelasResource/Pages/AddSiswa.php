<?php

namespace App\Filament\Resources\KelasResource\Pages;

use App\Filament\Resources\KelasResource;
use Filament\Resources\Pages\Page;
use App\Models\DetailKelas;
use App\Models\Kelas;
use Filament\Tables\Actions\BulkAction;
use App\Models\Siswa;
use Filament\Actions\Action;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action as TableAction;

class AddSiswa extends Page implements HasTable, HasForms
{

    use InteractsWithTable;
    use InteractsWithForms;

    protected static string $resource = KelasResource::class;
    protected static ?string $title = 'Tambah Siswa';
    protected static string $view = 'filament.resources.kelas-resource.pages.add-siswa';

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
        $record = $this->record;
        return $table // Mengambil data siswa yang belum masuk kelas di tahun ajaran ini
            ->query(fn() => Siswa::query()
            ->whereDoesntHave('detailKelas.kelas', function($query) use ($record) {
                $query->where('tahun_ajaran', Kelas::find($record)->tahun_ajaran);
            }))
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
            ])
            ->actions([
                TableAction::make('add_to_kelas')
                    ->label('Tambahkan ke Kelas')
                    ->icon('heroicon-o-building-office-2')
                    ->requiresConfirmation()
                    ->action(fn($record) => DetailKelas::create([
                        'kelas_id' =>  $this->record,
                        'siswa_id' => $record->id,
                    ]))
                    ->successNotificationTitle('Siswa berhasil ditambahkan!'),
            ]);
    }

}

