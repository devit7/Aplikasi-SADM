<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Matapelajaran;
use App\Models\Kelas;
use Carbon\Carbon;

class MatapelajaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allKelas = Kelas::all();

        if ($allKelas->isEmpty()) {
            $this->command->warn('No Kelas found. Running KelasSeeder first...');
            $this->call(KelasSeeder::class);
            $allKelas = Kelas::all();
        }

        $baseSubjects = [
            ['nama' => 'Islamic Education', 'kode_base' => 'PAI'],
            ['nama' => 'PPKn/ Civic', 'kode_base' => 'PKN'],
            ['nama' => 'Indonesian', 'kode_base' => 'IND'],
            ['nama' => 'Math', 'kode_base' => 'MTK'],
            ['nama' => 'Science and Social', 'kode_base' => 'IAS'],
            ['nama' => 'Science', 'kode_base' => 'IPA'],
            ['nama' => 'Social', 'kode_base' => 'IPS'],
            ['nama' => 'SBdP(Fine Arts)', 'kode_base' => 'SBP'],
            ['nama' => 'Sports Physical Education and Health (PJOK)', 'kode_base' => 'PJO'],
            ['nama' => 'English/Writing', 'kode_base' => 'ENW'],
            ['nama' => 'English/Reading', 'kode_base' => 'ENR'],
            ['nama' => 'English/Listening', 'kode_base' => 'ENL'],
            ['nama' => 'English/Speaking', 'kode_base' => 'ENS'],
            ['nama' => 'Arabic', 'kode_base' => 'ARB'],
            ['nama' => 'Java', 'kode_base' => 'JVA'],
            ['nama' => 'Kemuhammadiyahan', 'kode_base' => 'KMD'],
        ];

        $count = 0;
        foreach ($allKelas as $kelas) {
            foreach ($baseSubjects as $subject) {
                // Semester Ganjil
                Matapelajaran::updateOrCreate(
                    [
                        'kode_mapel' => $subject['kode_base'] . $kelas->id . '-1',
                    ],
                    [
                        'nama_mapel' => $subject['nama'],
                        'kelas_id' => $kelas->id,
                        'semester' => 'ganjil',
                        'kkm' => 80,
                    ]
                );
                $count++;

                // Semester Genap
                Matapelajaran::updateOrCreate(
                    [
                        'kode_mapel' => $subject['kode_base'] . $kelas->id . '-2',
                    ],
                    [
                        'nama_mapel' => $subject['nama'],
                        'kelas_id' => $kelas->id,
                        'semester' => 'genap',
                        'kkm' => 80,
                    ]
                );
                $count++;
            }
        }

        $this->command->info($count . ' Matapelajaran records seeded successfully.');
    }
}
