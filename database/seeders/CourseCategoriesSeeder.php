<?php

namespace Database\Seeders;

use App\Models\AlQuranLearningCategory;
use App\Models\AlQuranLearningSubcategory;
use App\Models\ExtrakurikulerCategory;
use App\Models\WorshipCharacterCategory;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourseCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = '2024/2025';
        $admin = User::first();
        $assignedBy = $admin ? $admin->id : null;

        // 1. Al-Quran Categories & Subcategories
        $alQuranData = [
            'Tahfidz (Hafalan Al-Quran)' => [
                'Surah An-Naba s.d An-Nazi\'at',
                'Surah ' . "Abasa s.d Al-Muthaffifin",
                'Juz 30 (Juz \'Amma Lengkap)',
                'Juz 29',
            ],
            'Tahsin & Tilawah' => [
                'Makharijul Huruf & Sifatul Huruf',
                'Hukum Nun Sukun & Tanwin',
                'Hukum Mad & Qashr',
                'Gharib & Tajwid Praktis',
            ],
            'Iqro / Dasar Membaca' => [
                'Iqro Jilid 1 - 2',
                'Iqro Jilid 3 - 4',
                'Iqro Jilid 5 - 6',
            ],
        ];

        $subcategories = [];
        foreach ($alQuranData as $categoryName => $subItems) {
            $cat = AlQuranLearningCategory::updateOrCreate(
                ['nama' => $categoryName],
                []
            );

            foreach ($subItems as $subItem) {
                $sub = AlQuranLearningSubcategory::updateOrCreate(
                    [
                        'category_id' => $cat->id,
                        'sub_nama' => $subItem,
                    ],
                    [
                        'semester' => 'ganjil',
                        'tahun_ajaran' => $tahunAjaran,
                    ]
                );
                $subcategories[] = $sub;
            }
        }

        // 2. Ekstrakurikuler Categories
        $ekskulList = [
            'Hizbul Wathan (Pramuka Penghela/Pengenal)',
            'Tapak Suci Putera Muhammadiyah',
            'Futsal & Sepak Bola',
            'Robotika & Coding Kids',
            'Drumband & Seni Musik',
            'Panahan (Archery)',
            'English Club & Story Telling',
            'Seni Lukis & Kaligrafi',
        ];

        $ekskulRecords = [];
        foreach ($ekskulList as $ekskulName) {
            $ekskulRecords[] = ExtrakurikulerCategory::updateOrCreate(
                ['nama' => $ekskulName],
                [
                    'semester' => 'ganjil',
                    'tahun_ajaran' => $tahunAjaran,
                ]
            );
        }

        // 3. Worship & Character Categories
        $worshipList = [
            'Shalat Berjamaah Dzuhur & Ashar',
            'Shalat Sunnah Dhuha',
            'Doa Harian & Dzikir Pagi Petang',
            'Kejujuran & Akhlakul Karimah',
            'Kedisiplinan & Ketertiban',
            'Kebersihan & Kepedulian Lingkungan',
        ];

        $worshipRecords = [];
        foreach ($worshipList as $worshipName) {
            $worshipRecords[] = WorshipCharacterCategory::updateOrCreate(
                ['nama' => $worshipName],
                [
                    'semester' => 'ganjil',
                    'tahun_ajaran' => $tahunAjaran,
                ]
            );
        }

        // 4. Enroll Siswa into Courses (Pivot Tables)
        $siswas = Siswa::all();
        if ($siswas->isNotEmpty()) {
            foreach ($siswas as $index => $siswa) {
                // Al-Quran Course
                if (!empty($subcategories)) {
                    $sub = $subcategories[$index % count($subcategories)];
                    DB::table('siswa_alquran_courses')->updateOrInsert(
                        [
                            'siswa_id' => $siswa->id,
                            'subcategory_id' => $sub->id,
                        ],
                        [
                            'assigned_by' => $assignedBy,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                // Ekstrakurikuler Course
                if (!empty($ekskulRecords)) {
                    $ekskul = $ekskulRecords[$index % count($ekskulRecords)];
                    DB::table('siswa_extrakurikuler_courses')->updateOrInsert(
                        [
                            'siswa_id' => $siswa->id,
                            'category_id' => $ekskul->id,
                        ],
                        [
                            'assigned_by' => $assignedBy,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }

                // Worship Course
                if (!empty($worshipRecords)) {
                    $worship = $worshipRecords[$index % count($worshipRecords)];
                    DB::table('siswa_worship_courses')->updateOrInsert(
                        [
                            'siswa_id' => $siswa->id,
                            'category_id' => $worship->id,
                        ],
                        [
                            'assigned_by' => $assignedBy,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]
                    );
                }
            }
        }

        $this->command->info('Al-Quran, Ekstrakurikuler, and Worship Character categories & enrollments seeded successfully.');
    }
}

