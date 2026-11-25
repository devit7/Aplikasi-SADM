<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Matapelajaran;
use App\Models\Staff;
use App\Models\StaffAcces;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StaffAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffList = Staff::all();
        $kelasList = Kelas::all();

        if ($staffList->isEmpty() || $kelasList->isEmpty()) {
            $this->command->warn('Staff or Kelas is empty. Skipping StaffAccessSeeder.');
            return;
        }

        $count = 0;
        foreach ($staffList as $index => $staff) {
            $kelas = $kelasList[$index % $kelasList->count()];
            $mapel = Matapelajaran::where('kelas_id', $kelas->id)->first();

            StaffAcces::updateOrCreate(
                [
                    'staff_id' => $staff->id,
                    'kelas_id' => $kelas->id,
                    'matapelajaran_id' => $mapel ? $mapel->id : null,
                ],
                [
                    'akses_nilai' => true,
                    'akses_absen' => true,
                    'akses_alquran_learning' => true,
                    'akses_extrakurikuler' => true,
                    'akses_worship_character' => true,
                ]
            );
            $count++;
        }

        $this->command->info($count . ' StaffAccess records seeded successfully.');
    }
}

