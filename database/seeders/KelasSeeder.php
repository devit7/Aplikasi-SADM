<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\User;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $waliKelasList = User::where('role', 'walikelas')->get();

        if ($waliKelasList->isEmpty()) {
            $this->command->warn('No Wali Kelas found. Running WaliKelasSeeder first...');
            $this->call(WaliKelasSeeder::class);
            $waliKelasList = User::where('role', 'walikelas')->get();
        }

        $tahunAjaran = '2024/2025';

        $kelasList = [
            'Kelas 1A',
            'Kelas 1B',
            'Kelas 2A',
            'Kelas 2B',
            'Kelas 3A',
            'Kelas 3B',
        ];

        foreach ($kelasList as $index => $namaKelas) {
            $waliKelas = $waliKelasList[$index % $waliKelasList->count()];

            Kelas::updateOrCreate(
                [
                    'nama_kelas' => $namaKelas,
                    'tahun_ajaran' => $tahunAjaran,
                ],
                [
                    'walikelas_id' => $waliKelas->id,
                ]
            );
        }

        $this->command->info(count($kelasList) . ' Kelas records seeded successfully for Tahun Ajaran ' . $tahunAjaran . '.');
    }
}

