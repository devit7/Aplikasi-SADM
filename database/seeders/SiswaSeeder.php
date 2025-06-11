<?php

namespace Database\Seeders;

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
        $faker = Faker::create('id_ID'); // Indonesian locale for realistic names

        // Array of common Indonesian first names
        $firstNames = [
            'Ahmad',
            'Muhammad',
            'Abdul',
            'Ali',
            'Umar',
            'Yusuf',
            'Ibrahim',
            'Ismail',
            'Siti',
            'Aisyah',
            'Fatimah',
            'Khadijah',
            'Maryam',
            'Zainab',
            'Hafsah',
            'Ummu',
            'Andi',
            'Budi',
            'Citra',
            'Dian',
            'Eka',
            'Fajar',
            'Gita',
            'Hadi',
            'Indra',
            'Joko',
            'Kartika',
            'Lestari',
            'Maya',
            'Nanda',
            'Okta',
            'Putri',
            'Reza',
            'Sari',
            'Taufik',
            'Ulfa',
            'Vina',
            'Wahyu',
            'Yoga',
            'Zahra'
        ];

        // Array of common Indonesian last names
        $lastNames = [
            'Pratama',
            'Sari',
            'Putra',
            'Putri',
            'Wijaya',
            'Santoso',
            'Wati',
            'Hidayat',
            'Rahmadi',
            'Kurniawan',
            'Susanto',
            'Handayani',
            'Setiawan',
            'Maharani',
            'Permana',
            'Nurrahman',
            'Rahayu',
            'Perdana',
            'Kusuma',
            'Indrawati',
            'Firmansyah',
            'Anggraini',
            'Prihandoko',
            'Suryani',
            'Hermawan',
            'Lestari'
        ];
        $iteration = 5;
        // Generate 100 students
        for ($i = 1; $i <= $iteration; $i++) {
            $firstName = $faker->randomElement($firstNames);
            $lastName = $faker->randomElement($lastNames);
            $fullName = $faker->name();

            // Generate NIS (Nomor Induk Siswa) - typically 8-10 digits
            $nis = str_pad($i, 5, '0', STR_PAD_LEFT);

            // Generate NISN (Nomor Induk Siswa Nasional) - 10 digits
            $nisn = '20' . str_pad($faker->numberBetween(10000000, 99999999), 8, '0', STR_PAD_LEFT);

            Siswa::create([
                'nis' => $nis,
                'nisn' => $nisn,
                'nama' => $fullName,
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->dateTimeBetween('-18 years', '-6 years')->format('Y-m-d'),
                'alamat' => $faker->address,
                'nama_bapak' => $faker->name('male'),
                'nama_ibu' => $faker->name('female'),
                'pekerjaan_bapak' => $faker->randomElement([
                    'PNS',
                    'Guru',
                    'Petani',
                    'Pedagang',
                    'Buruh',
                    'Wiraswasta',
                    'Karyawan Swasta',
                    'TNI/Polri',
                    'Dokter',
                    'Pengacara',
                    'Perawat',
                    'pilot'

                ]),
                'pekerjaan_ibu' => $faker->randomElement([
                    'Ibu Rumah Tangga',
                    'Guru',
                    'Perawat',
                    'Pedagang',
                    'PNS',
                    'Karyawan Swasta',
                    'Wiraswasta',
                    'Petani',
                    'Dokter',
                    'Bidan',
                    'TNI/Polri',
                    'Pengacara'
                ]),
                'no_hp_bapak' => $faker->phoneNumber,
                'no_hp_ibu' => $faker->phoneNumber,
                'tanggal_masuk' => $faker->date('Y-m-d'),// You can add default photo logic here if needed
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info($iteration . ' Siswa records created successfully.');
    }
}
