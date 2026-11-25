<?php

namespace Database\Seeders;

use App\Models\Absen;
use App\Models\DetailKelas;
use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\DetailPresensi;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbsenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $detailKelasList = DetailKelas::with('siswa')->get();
        $kelasList = Kelas::all();

        if ($detailKelasList->isEmpty()) {
            $this->command->warn('No DetailKelas found. Skipping AbsenSeeder.');
            return;
        }

        $todayStr = now()->format('Y-m-d');
        $statusesAbsen = ['hadir', 'hadir', 'hadir', 'hadir', 'izin', 'sakit'];
        $statusesPresensi = ['masuk', 'masuk', 'masuk', 'masuk', 'izin', 'sakit'];

        // 1. Seed tabel absen untuk hari ini (sesuai aturan validasi model Absen)
        $absenCount = 0;
        foreach ($detailKelasList as $detail) {
            $status = $statusesAbsen[array_rand($statusesAbsen)];
            Absen::updateOrCreate(
                [
                    'detail_kelas_id' => $detail->id,
                    'tanggal' => $todayStr,
                ],
                [
                    'status' => $status,
                ]
            );
            $absenCount++;
        }

        // 2. Seed tabel presensis dan detail_presensis untuk 7 hari kerja terakhir
        $dates = [];
        $today = Carbon::today();
        for ($i = 0; $i < 14; $i++) {
            $date = $today->copy()->subDays($i);
            if (!$date->isWeekend()) {
                $dates[] = $date->format('Y-m-d');
            }
            if (count($dates) >= 7) {
                break;
            }
        }

        $presensiCount = 0;
        foreach ($kelasList as $kelas) {
            $kelasDetails = $detailKelasList->where('kelas_id', $kelas->id);

            foreach ($dates as $date) {
                $presensi = Presensi::updateOrCreate(
                    [
                        'tanggal' => $date,
                        'kelas_id' => $kelas->id,
                    ],
                    [
                        'status' => 'selesai',
                    ]
                );

                foreach ($kelasDetails as $detail) {
                    $status = $statusesPresensi[array_rand($statusesPresensi)];
                    DetailPresensi::updateOrCreate(
                        [
                            'presensi_id' => $presensi->id,
                            'siswa_id' => $detail->siswa_id,
                        ],
                        [
                            'status' => $status,
                        ]
                    );
                    $presensiCount++;
                }
            }
        }

        $this->command->info($absenCount . ' Absen records and ' . $presensiCount . ' DetailPresensi records seeded successfully.');
    }
}
