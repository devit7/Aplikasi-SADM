<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffAccesResource\Pages;
use App\Filament\Resources\StaffAccesResource\RelationManagers;
use App\Models\Matapelajaran;
use App\Models\StaffAcces;
use App\Models\AlQuranLearningCategory;
use App\Models\AlQuranLearningSubcategory;
use App\Models\ExtrakurikulerCategory;
use App\Models\WorshipCharacterCategory;
use Dom\Text;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\HtmlString;

class StaffAccesResource extends Resource
{
    protected static ?string $model = StaffAcces::class;
    protected static ?string $navigationGroup = 'Staff Management';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Staff Akses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // BAGIAN 1: Hak Akses Staff
                Section::make('Staff Access')
                    ->description('Tentukan staff dan kelas')
                    ->schema([
                        Select::make('staff_id')
                            ->label('Staff')
                            ->preload()
                            ->searchable()
                            ->searchDebounce(200)
                            ->relationship('staff', 'nama')
                            ->required(),
                        Select::make('kelas_id')
                            ->label('Kelas')
                            ->relationship('kelas', 'nama_kelas')
                            ->preload()
                            ->searchable()
                            ->searchDebounce(200)
                            ->required(),
                    ])->columnSpan(1),

                // BAGIAN 3: MATA PELAJARAN (DENGAN REPEATER)
                Section::make('Mata Pelajaran')
                    ->description('Tambahkan satu atau lebih mata pelajaran')
                    ->schema([
                        Repeater::make('mata_pelajaran')
                            ->label('')
                            ->schema([
                                Select::make('matapelajaran_id')
                                    ->label('Mata Pelajaran')
                                    ->options(function (callable $get) {
                                        $kelasId = $get('../../kelas_id');
                                        if (!$kelasId) {
                                            return [];
                                        }
                                        return Matapelajaran::where('kelas_id', $kelasId)
                                            ->get()
                                            ->mapWithKeys(function ($matapelajaran) {
                                                return [$matapelajaran->id => $matapelajaran->nama_mapel . ' - ' . $matapelajaran->semester];
                                            });
                                    })
                                    ->searchable()
                                    ->disabled(fn(callable $get) => !$get('../../kelas_id'))
                                    ->required(),
                            ])
                            ->addActionLabel('Tambah Mata Pelajaran')
                            ->itemLabel(
                                fn(array $state): ?string =>
                                $state['matapelajaran_id']
                                    ? Matapelajaran::find($state['matapelajaran_id'])?->nama_mapel
                                    : null
                            )
                            ->collapsible()
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->live() // Penting: Aktifkan live state updating
                    ])->columnSpan(1),

                // BAGIAN 2: HAK AKSES DASAR
                Section::make('Hak Akses Dasar')
                    ->description('Pilih 1 atau lebih hak akses yang diberikan kepada staff')
                    ->schema([
                        Checkbox::make('akses_nilai')
                            ->label('Akses Nilai')
                            ->helperText('Memberikan akses untuk mengelola nilai siswa')
                            ->disabled(function (callable $get) {
                                $mataPelajaran = $get('mata_pelajaran');
                                return !is_array($mataPelajaran) || count($mataPelajaran) === 0;
                            })
                            ->dehydrated(function (callable $get) {
                                $mataPelajaran = $get('mata_pelajaran');
                                return is_array($mataPelajaran) && count($mataPelajaran) > 0;
                            }),
                        Checkbox::make('akses_absen')
                            ->label('Akses Absen')
                            ->helperText('Memberikan akses untuk mengelola absensi siswa')
                            ->disabled(function (callable $get) {
                                $mataPelajaran = $get('mata_pelajaran');
                                return !is_array($mataPelajaran) || count($mataPelajaran) === 0;
                            })
                            ->dehydrated(function (callable $get) {
                                $mataPelajaran = $get('mata_pelajaran');
                                return is_array($mataPelajaran) && count($mataPelajaran) > 0;
                            }),
                    ])->columnSpan(1),

                // BAGIAN 4: HAK AKSES AL-QURAN LEARNING
                Section::make('Al-Quran Learning')
                    ->description('Atur akses untuk pembelajaran dan penilaian Al-Quran')
                    ->schema([
                        Checkbox::make('akses_alquran_learning')
                            ->label('Akses Pembelajaran Al-Quran')
                            ->helperText('Memberikan akses untuk mengelola pembelajaran dan penilaian Al-Quran')
                            ->live(),

                        Repeater::make('alquran_subcategories')
                            ->label('Kategori dan Sub-Kategori Al-Quran')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori Al-Quran')
                                    ->options(function () {
                                        return AlQuranLearningCategory::all()->pluck('nama', 'id');
                                    })
                                    ->preload()
                                    ->searchable()
                                    ->live()
                                    ->required(),

                                Select::make('subcategory_ids')
                                    ->label('Sub-Kategori')
                                    ->options(function (callable $get) {
                                        $categoryId = $get('category_id');
                                        if (!$categoryId) {
                                            return [];
                                        }

                                        // Debug - cek field yang digunakan untuk nama subcategory
                                        $subcategories = AlQuranLearningSubcategory::where('category_id', $categoryId)->get();

                                        return $subcategories->mapWithKeys(function ($subcategory) {
                                            // Gunakan sub_nama sesuai dengan migrasi
                                            return [$subcategory->id => $subcategory->sub_nama];
                                        });
                                    })
                                    ->multiple()
                                    ->preload()
                                    ->searchable()
                                    ->visible(fn(callable $get) => (bool) $get('category_id')),
                            ])
                            ->visible(fn(callable $get) => $get('akses_alquran_learning'))
                            ->addActionLabel('Tambah Kategori Al-Quran')
                            ->itemLabel(
                                fn(array $state): ?string =>
                                isset($state['category_id'])
                                    ? (AlQuranLearningCategory::find($state['category_id'])?->nama ?? 'Kategori tidak ditemukan')
                                    : 'Pilih kategori'
                            )
                            ->collapsible()
                            ->defaultItems(0)
                            ->reorderable(false),
                    ])->columnSpan(1),

                // BAGIAN 5: HAK AKSES EKSTRAKURIKULER
                Section::make('Ekstrakurikuler')
                    ->description('Atur akses untuk kegiatan dan penilaian ekstrakurikuler')
                    ->schema([
                        Checkbox::make('akses_extrakurikuler')
                            ->label('Akses Ekstrakurikuler')
                            ->helperText('Memberikan akses untuk mengelola kegiatan dan penilaian ekstrakurikuler')
                            ->live(),

                        Repeater::make('extrakurikuler_categories')
                            ->label('Kategori Ekstrakurikuler')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori Ekstrakurikuler')
                                    ->options(ExtrakurikulerCategory::all()->pluck('nama', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                            ])
                            ->visible(fn(callable $get) => $get('akses_extrakurikuler'))
                            ->addActionLabel('Tambah Kategori Ekstrakurikuler')
                            ->itemLabel(
                                fn(array $state): ?string =>
                                $state['category_id']
                                    ? ExtrakurikulerCategory::find($state['category_id'])?->nama
                                    : null
                            )
                            ->collapsible()
                            ->defaultItems(0)
                            ->reorderable(false),
                    ])->columnSpan(1),

                // BAGIAN 6: HAK AKSES IBADAH & KARAKTER
                Section::make('Worships and Characters')
                    ->description('Atur akses untuk penilaian ibadah dan karakter siswa')
                    ->schema([
                        Checkbox::make('akses_worship_character')
                            ->label('Akses Ibadah & Karakter')
                            ->helperText('Memberikan akses untuk mengelola penilaian ibadah dan karakter siswa')
                            ->live(),

                        Repeater::make('worship_categories')
                            ->label('Kategori Ibadah & Karakter')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori Ibadah & Karakter')
                                    ->options(WorshipCharacterCategory::all()->pluck('nama', 'id'))
                                    ->preload()
                                    ->searchable()
                                    ->required(),
                            ])
                            ->visible(fn(callable $get) => $get('akses_worship_character'))
                            ->addActionLabel('Tambah Kategori Ibadah & Karakter')
                            ->itemLabel(
                                fn(array $state): ?string =>
                                $state['category_id']
                                    ? WorshipCharacterCategory::find($state['category_id'])?->nama
                                    : null
                            )
                            ->collapsible()
                            ->defaultItems(0)
                            ->reorderable(false),
                    ])->columnSpan(1),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                StaffAcces::with([
                    'staff',
                    'kelas',
                    'matapelajaran',
                    'alQuranSubcategories.category',
                    'extrakurikulerCategories',
                    'worshipCategories'
                ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('staff.nama')
                    ->label('Staff')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('matapelajaran.nama_mapel')
                    ->label('Mata Pelajaran')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->matapelajaran ?
                            $record->matapelajaran->nama_mapel . ' - ' . $record->matapelajaran->semester : '-';
                    })
                    ->searchable()
                    ->sortable(),

                // Akses dasar dengan ikon
                Tables\Columns\IconColumn::make('akses_nilai')
                    ->label('Nilai')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\IconColumn::make('akses_absen')
                    ->label('Absen')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                // Akses penilaian khusus dengan ikon dan detail
                Tables\Columns\IconColumn::make('akses_alquran_learning')
                    ->label('Al-Quran Learning')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('akses_extrakurikuler')
                    ->label('Extrakurikuler')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\IconColumn::make('akses_worship_character')
                    ->label('Worship & Character')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->modalHeading('Detail Akses Staff')
                    ->modalDescription(function (StaffAcces $record): string {
                        return "Informasi lengkap untuk akses {$record->staff->nama}";
                    })
                    ->modalContent(function (StaffAcces $record): HtmlString {
                        $details = "<div class='space-y-4 px-1 py-2'>";

                        // Mata Pelajaran - Perbaikan untuk menampilkan semua mata pelajaran
                        $details .= "<div class='border-b pb-2'><strong>Mata Pelajaran:</strong><ul class='list-disc pl-4 mt-1'>";

                        // Menampilkan mata pelajaran utama jika ada
                        if ($record->matapelajaran) {
                            $details .= "<li>{$record->matapelajaran->nama_mapel} - {$record->matapelajaran->semester}</li>";
                        }

                        // Cari semua akses staff yang memiliki kelas dan staff yang sama
                        $otherAccesses = StaffAcces::where('staff_id', $record->staff_id)
                            ->where('kelas_id', $record->kelas_id)
                            ->where('id', '!=', $record->id)
                            ->with('matapelajaran')
                            ->get();

                        // Tambahkan mata pelajaran lain yang terkait dengan staff dan kelas yang sama
                        foreach ($otherAccesses as $access) {
                            if ($access->matapelajaran) {
                                $details .= "<li>{$access->matapelajaran->nama_mapel} - {$access->matapelajaran->semester}</li>";
                            }
                        }

                        if (!$record->matapelajaran && $otherAccesses->isEmpty()) {
                            $details .= "<li>Tidak ada mata pelajaran yang dipilih</li>";
                        }

                        $details .= "</ul></div>";

                        // Kategori & subkategori Al-Quran
                        if ($record->akses_alquran_learning) {
                            $details .= "<div class='border-b pb-2'><strong>Akses Al-Quran:</strong><ul class='list-disc pl-4 mt-1'>";
                            if ($record->alQuranSubcategories->count()) {
                                foreach ($record->alQuranSubcategories as $subcategory) {
                                    $details .= "<li>{$subcategory->category->nama} - {$subcategory->sub_nama}</li>";
                                }
                            } else {
                                $details .= "<li>Tidak ada sub-kategori yang dipilih</li>";
                            }
                            $details .= "</ul></div>";
                        }

                        // Kategori Ekstrakurikuler
                        if ($record->akses_extrakurikuler) {
                            $details .= "<div class='border-b pb-2'><strong>Akses Ekstrakurikuler:</strong><ul class='list-disc pl-4 mt-1'>";
                            if ($record->extrakurikulerCategories->count()) {
                                foreach ($record->extrakurikulerCategories as $category) {
                                    $details .= "<li>{$category->nama}</li>";
                                }
                            } else {
                                $details .= "<li>Tidak ada kategori yang dipilih</li>";
                            }
                            $details .= "</ul></div>";
                        }

                        // Kategori Ibadah & Karakter
                        if ($record->akses_worship_character) {
                            $details .= "<div class='border-b pb-2'><strong>Akses Ibadah & Karakter:</strong><ul class='list-disc pl-4 mt-1'>";
                            if ($record->worshipCategories->count()) {
                                foreach ($record->worshipCategories as $category) {
                                    $details .= "<li>{$category->nama}</li>";
                                }
                            } else {
                                $details .= "<li>Tidak ada kategori yang dipilih</li>";
                            }
                            $details .= "</ul></div>";
                        }

                        $details .= "</div>";
                        return new HtmlString($details);
                    }),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaffAcces::route('/'),
            'create' => Pages\CreateStaffAcces::route('/create'),
            'edit' => Pages\EditStaffAcces::route('/{record}/edit'),
        ];
    }
}
