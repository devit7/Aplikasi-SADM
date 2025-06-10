<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentCourseEnrollmentResource\Pages;
use App\Models\AlQuranLearningCategory;
use App\Models\AlQuranLearningSubcategory;
use App\Models\ExtrakurikulerCategory;
use App\Models\WorshipCharacterCategory;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentCourseEnrollmentResource extends Resource
{
    protected static ?string $model = Siswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Student Course Enrollment';
    protected static ?string $navigationGroup = 'Student Management';
    protected static ?string $slug = 'student-course-enrollment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // PERBAIKAN: Hapus select siswa untuk edit mode, karena sudah auto-detected
                Select::make('siswa_id')
                    ->label('Pilih Siswa')
                    ->options(Siswa::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->required()
                    ->visible(fn($record) => $record === null), // Hanya tampil saat create

                Section::make('Al-Quran Courses')
                    ->description('Tetapkan siswa ke kursus Al-Quran')
                    ->schema([
                        Repeater::make('alquran_courses')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori Al-Quran')
                                    ->options(AlQuranLearningCategory::all()->pluck('nama', 'id'))
                                    ->reactive()
                                    ->required(),

                                Select::make('subcategory_id')
                                    ->label('Sub-Kategori')
                                    ->options(function (callable $get) {
                                        $categoryId = $get('category_id');
                                        if (!$categoryId) return [];

                                        return AlQuranLearningSubcategory::where('category_id', $categoryId)
                                            ->get()
                                            ->mapWithKeys(function ($item) {
                                                $tahunAjaran = $item->tahun_ajaran ? " ({$item->tahun_ajaran})" : '';
                                                return [$item->id => $item->sub_nama . $tahunAjaran];
                                            });
                                    })
                                    ->reactive()
                                    ->required()
                                    ->searchable(),
                            ])
                            ->itemLabel(function (array $state) {
                                $subcategoryId = $state['subcategory_id'] ?? null;
                                if (!$subcategoryId) return 'Kursus Al-Quran Baru';

                                $subcategory = AlQuranLearningSubcategory::find($subcategoryId);
                                if (!$subcategory) return 'Kursus Al-Quran Baru';

                                $tahunAjaran = $subcategory->tahun_ajaran ? " ({$subcategory->tahun_ajaran})" : '';
                                return $subcategory->category->nama . ' - ' . $subcategory->sub_nama . $tahunAjaran;
                            })
                            ->collapsible()
                            ->defaultItems(0),
                    ]),

                Section::make('Extrakurikuler Courses')
                    ->description('Tetapkan siswa ke kursus Extrakurikuler')
                    ->schema([
                        Repeater::make('extrakurikuler_courses')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori Extrakurikuler')
                                    ->options(ExtrakurikulerCategory::all()
                                        ->mapWithKeys(function ($item) {
                                            $tahunAjaran = $item->tahun_ajaran ? " ({$item->tahun_ajaran})" : '';
                                            return [$item->id => $item->nama . $tahunAjaran];
                                        }))
                                    ->required()
                                    ->searchable(),
                            ])
                            ->itemLabel(function (array $state) {
                                $categoryId = $state['category_id'] ?? null;
                                if (!$categoryId) return 'Kursus Extrakurikuler Baru';

                                $category = ExtrakurikulerCategory::find($categoryId);
                                if (!$category) return 'Kursus Extrakurikuler Baru';

                                $tahunAjaran = $category->tahun_ajaran ? " ({$category->tahun_ajaran})" : '';
                                return $category->nama . $tahunAjaran;
                            })
                            ->collapsible()
                            ->defaultItems(0),
                    ]),

                Section::make('Worship & Character Courses')
                    ->description('Tetapkan siswa ke kursus Ibadah dan Karakter')
                    ->schema([
                        Repeater::make('worship_courses')
                            ->schema([
                                Select::make('category_id')
                                    ->label('Kategori Ibadah & Karakter')
                                    ->options(WorshipCharacterCategory::all()
                                        ->mapWithKeys(function ($item) {
                                            $tahunAjaran = $item->tahun_ajaran ? " ({$item->tahun_ajaran})" : '';
                                            return [$item->id => $item->nama . $tahunAjaran];
                                        }))
                                    ->required()
                                    ->searchable(),
                            ])
                            ->itemLabel(function (array $state) {
                                $categoryId = $state['category_id'] ?? null;
                                if (!$categoryId) return 'Kursus Ibadah & Karakter Baru';

                                $category = WorshipCharacterCategory::find($categoryId);
                                if (!$category) return 'Kursus Ibadah & Karakter Baru';

                                $tahunAjaran = $category->tahun_ajaran ? " ({$category->tahun_ajaran})" : '';
                                return $category->nama . $tahunAjaran;
                            })
                            ->collapsible()
                            ->defaultItems(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('alQuranCourses')
                    ->label('Al-Quran Courses')
                    ->formatStateUsing(function ($record) {
                        $courses = $record->alQuranCourses;
                        if ($courses->isEmpty()) {
                            return 'Tidak ada kursus';
                        }

                        return $courses->map(function ($subcategory) {
                            $tahunAjaran = $subcategory->tahun_ajaran ? " ({$subcategory->tahun_ajaran})" : '';
                            return $subcategory->sub_nama . $tahunAjaran;
                        })->join(', ');
                    })
                    ->wrap()
                    ->searchable(),
                TextColumn::make('al_quran_courses_count')
                    ->label('Jumlah Al-Quran Courses')
                    ->counts('alQuranCourses')
                    ->sortable()
                    ->badge()
                    ->color('success'),

                TextColumn::make('extrakurikulerCourses')
                    ->label('Extrakurikuler Courses')
                    ->formatStateUsing(function ($record) {
                        $courses = $record->extrakurikulerCourses;
                        if ($courses->isEmpty()) {
                            return 'Tidak ada kursus';
                        }

                        return $courses->map(function ($category) {
                            $tahunAjaran = $category->tahun_ajaran ? " ({$category->tahun_ajaran})" : '';
                            return $category->nama . $tahunAjaran;
                        })->join(', ');
                    })
                    ->wrap()
                    ->searchable(),
                TextColumn::make('extrakurikuler_courses_count')
                    ->label('Jumlah Extrakurikuler Courses')
                    ->counts('extrakurikulerCourses')
                    ->sortable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('worshipCourses')
                    ->label('Jumlah Worship Courses')
                    ->formatStateUsing(function ($record) {
                        $courses = $record->worshipCourses;
                        if ($courses->isEmpty()) {
                            return 'Tidak ada kursus';
                        }

                        return $courses->map(function ($category) {
                            $tahunAjaran = $category->tahun_ajaran ? " ({$category->tahun_ajaran})" : '';
                            return $category->nama . $tahunAjaran;
                        })->join(', ');
                    })
                    ->wrap()
                    ->searchable(),
                TextColumn::make('worship_courses_count')
                    ->label('Worship Courses')
                    ->counts('worshipCourses')
                    ->sortable()
                    ->badge()
                    ->color('warning'),
            ])
            ->filters([
                Tables\Filters\Filter::make('course_tahun_ajaran')
                    ->form([
                        Forms\Components\TextInput::make('tahun_ajaran')
                            ->label('Tahun Ajaran')
                            ->placeholder('Contoh: 2023/2024'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tahun_ajaran'],
                                function (Builder $query, $value) {
                                    // Filter siswa yang memiliki kursus Al-Quran dengan tahun ajaran yang sesuai
                                    return $query->whereHas('alQuranCourses', function ($query) use ($value) {
                                        $query->where('tahun_ajaran', 'like', "%{$value}%");
                                    })
                                        // ATAU siswa yang memiliki kursus Extrakurikuler dengan tahun ajaran yang sesuai
                                        ->orWhereHas('extrakurikulerCourses', function ($query) use ($value) {
                                            $query->where('tahun_ajaran', 'like', "%{$value}%");
                                        })
                                        // ATAU siswa yang memiliki kursus Worship dengan tahun ajaran yang sesuai
                                        ->orWhereHas('worshipCourses', function ($query) use ($value) {
                                            $query->where('tahun_ajaran', 'like', "%{$value}%");
                                        });
                                }
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('Manage Courses')
                    ->icon('heroicon-m-pencil-square'),
            ])->modifyQueryUsing(function (Builder $query) { //query dengan eager loading untuk performa
                return $query->withCount([
                    'alQuranCourses',
                    'extrakurikulerCourses',
                    'worshipCourses'
                ])->with([
                    'alQuranCourses.category',
                    'extrakurikulerCourses',
                    'worshipCourses'
                ]);
            });
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentCourseEnrollments::route('/'),
            'create' => Pages\CreateStudentCourseEnrollment::route('/create'),
            'edit' => Pages\EditStudentCourseEnrollment::route('/{record}/edit'),
        ];
    }
}
