<?php

namespace Database\Seeders;

use App\Models\DetailKelas;
use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        $kelasList = Kelas::all();

        // 24 Siswa data predefined or realistic generated
        $maleNames = [
            'Muhammad Rizky Pratama',
            'Ahmad Fauzi Hidayat',
            'Ali Zainal Abidin',
            'Umar Abdullah Al-Farisi',
            'Yusuf Maulana Ibrahim',
            'Ismail Hasan Basri',
            'Budi Setiawan Santoso',
            'Fajar Nugroho Prihandoko',
            'Hadi Saputra Wijaya',
            'Indra Kurniawan Perdana',
            'Joko Rahmadi Pratama',
            'Wahyu Firmansyah Putra',
        ];

        $femaleNames = [
            'Siti Nurhaliza Zahra',
            'Aisyah Putri Maharani',
            'Fatimah Azzahra Lestari',
            'Khadijah Maryam Rahayu',
            'Zainab Hafsah Anggraini',
            'Citra Dewi Handayani',
            'Dian Kartika Suryani',
            'Gita Maya Indrawati',
            'Nanda Vina Permana',
            'Okta Reza Nurrahman',
            'Putri Ayu Lestari',
            'Zahra Ulfa Mahardika',
        ];

        $pekerjaanList = [
            'PNS', 'Guru', 'Wiraswasta', 'Karyawan Swasta', 'Dokter',
            'Pedagang', 'BUMN', 'TNI/Polri', 'Perawat', 'Dosen'
        ];

        $pekerjaanIbuList = [
            'Ibu Rumah Tangga', 'Guru', 'PNS', 'Karyawan Swasta', 'Bidan',
            'Dokter', 'Wiraswasta', 'Perawat', 'Dosen', 'Pedagang'
        ];

        $totalSiswa = 24;

        for ($i = 1; $i <= $totalSiswa; $i++) {
            $isMale = ($i % 2 !== 0);
            $nama = $isMale 
                ? $maleNames[($i - 1) / 2 % count($maleNames)] 
                : $femaleNames[($i / 2 - 1) % count($femaleNames)];
            
            $gender = $isMale ? 'L' : 'P';
            $nis = str_pad($i, 5, '0', STR_PAD_LEFT);
            $nisn = '00' . str_pad(12345600 + $i, 8, '0', STR_PAD_LEFT);

            $siswa = Siswa::updateOrCreate(
                ['nisn' => $nisn],
                [
                    'nis' => $nis,
                    'nama' => $nama,
                    'jenis_kelamin' => $gender,
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->dateTimeBetween('-12 years', '-7 years')->format('Y-m-d'),
                    'alamat' => $faker->streetAddress . ', ' . $faker->city,
                    'nama_bapak' => $faker->name('male'),
                    'nama_ibu' => $faker->name('female'),
                    'pekerjaan_bapak' => $faker->randomElement($pekerjaanList),
                    'pekerjaan_ibu' => $faker->randomElement($pekerjaanIbuList),
                    'no_hp_bapak' => '08' . $faker->numerify('##########'),
                    'no_hp_ibu' => '08' . $faker->numerify('##########'),
                    'tanggal_masuk' => '2024-07-15',
                ]
            );

            // Hubungkan siswa ke kelas (DetailKelas)
            if ($kelasList->isNotEmpty()) {
                $targetKelas = $kelasList[($i - 1) % $kelasList->count()];
                DetailKelas::updateOrCreate(
                    [
                        'kelas_id' => $targetKelas->id,
                        'siswa_id' => $siswa->id,
                    ],
                    []
                );
            }
        }

        $this->command->info($totalSiswa . ' Siswa records seeded and enrolled in DetailKelas successfully.');
    }
}
