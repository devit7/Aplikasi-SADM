<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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

        $allKelas = Kelas::all();
        $matapelajaranData = [];
        $now = Carbon::now();

        foreach ($allKelas as $kelas) {
            foreach ($baseSubjects as $subject) {
                $matapelajaranData[] = [
                    'nama_mapel' => $subject['nama'],
                    'kode_mapel' => $subject['kode_base'] . $kelas->id . '-1', // IPA12, MTK12, etc.
                    'kelas_id' => $kelas->id,
                    'semester' => 'ganjil',
                    'kkm' => 80,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $matapelajaranData[] = [
                    'nama_mapel' => $subject['nama'],
                    'kode_mapel' => $subject['kode_base'] . $kelas->id . '-2', // IPA12, MTK12, etc.
                    'kelas_id' => $kelas->id,
                    'semester' => 'genap',
                    'kkm' => 80,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Insert all data at once
        DB::table('matapelajaran')->insert($matapelajaranData);
    }
}
