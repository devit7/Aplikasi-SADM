<?php

namespace Database\Seeders;

use App\Models\DetailKelas;
use App\Models\Matapelajaran;
use App\Models\Nilai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all existing mata pelajaran
        $mataPelajarans = Matapelajaran::all();;

        // Get all existing detail kelas
        $detailKelas = DetailKelas::all();

        // Check if we have data to work with
        if ($mataPelajarans->isEmpty()) {
            $this->command->info('No Matapelajaran found. Please seed Matapelajaran first.');
            return;
        }

        if ($detailKelas->isEmpty()) {
            $this->command->info('No DetailKelas found. Please seed DetailKelas first.');
            return;
        }

        // Create nilai for each combination of DetailKelas and Matapelajaran
        foreach ($detailKelas as $kelas) {
            foreach ($mataPelajarans as $mapel) {
                Nilai::create([
                    'detail_kelas_id' => $kelas->id,
                    'matapelajaran_id' => $mapel->id,
                    'nilai_uts' => rand(60, 100),
                    'nilai_uas' => rand(50, 100),
                    // Add other fields as needed based on your nilai table structure
                ]);
            }
        }

        $this->command->info('Nilai seeded successfully for all Matapelajaran and DetailKelas combinations.');
    }
}
