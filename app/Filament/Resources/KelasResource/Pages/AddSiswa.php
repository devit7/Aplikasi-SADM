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
        return $table
            ->query(fn() => Siswa::query()->whereDoesntHave('detailKelas', fn($query) =>
            $query->where('kelas_id', $this->record))) // Hanya siswa yang belum masuk kelas
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
            ]);
    }

}

