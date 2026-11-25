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
        $detailKelasList = DetailKelas::all();

        if ($detailKelasList->isEmpty()) {
            $this->command->warn('No DetailKelas found. Running SiswaSeeder first...');
            $this->call(SiswaSeeder::class);
            $detailKelasList = DetailKelas::all();
        }

        $count = 0;
        foreach ($detailKelasList as $detail) {
            // Hanya ambil matapelajaran yang sesuai dengan kelas siswa tersebut
            $mapelList = Matapelajaran::where('kelas_id', $detail->kelas_id)->get();

            foreach ($mapelList as $mapel) {
                Nilai::updateOrCreate(
                    [
                        'detail_kelas_id' => $detail->id,
                        'matapelajaran_id' => $mapel->id,
                    ],
                    [
                        'nilai_uts' => (string) rand(70, 95),
                        'nilai_uas' => (string) rand(72, 98),
                    ]
                );
                $count++;
            }
        }

        $this->command->info($count . ' Nilai records seeded successfully.');
    }
}
