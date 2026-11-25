<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class WaliKelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $waliKelasList = [
            [
                'nip' => '198501152010011001',
                'name' => 'Setyo Nugroho, S.Pd',
                'email' => 'setyo@gmail.com',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Surabaya',
                'tanggal_lahir' => '1985-01-15',
                'no_hp' => '081234567801',
                'alamat' => 'Jl. Pemuda No. 10, Surabaya',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '198602202010011002',
                'name' => 'Budi Santoso, S.Pd',
                'email' => 'budi.santoso@gmail.com',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Sidoarjo',
                'tanggal_lahir' => '1986-02-20',
                'no_hp' => '081234567802',
                'alamat' => 'Jl. Pahlawan No. 15, Sidoarjo',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '198803122011012001',
                'name' => 'Siti Aminah, S.Pd.I',
                'email' => 'siti.aminah@gmail.com',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Gresik',
                'tanggal_lahir' => '1988-03-12',
                'no_hp' => '081234567803',
                'alamat' => 'Jl. RA Kartini No. 8, Gresik',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '199004182012012002',
                'name' => 'Dewi Lestari, S.Pd',
                'email' => 'dewi.lestari@gmail.com',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Mojokerto',
                'tanggal_lahir' => '1990-04-18',
                'no_hp' => '081234567804',
                'alamat' => 'Jl. Gajah Mada No. 22, Mojokerto',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '198705252010011003',
                'name' => 'Ahmad Dahlan, S.Pd',
                'email' => 'ahmad.dahlan@gmail.com',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Yogyakarta',
                'tanggal_lahir' => '1987-05-25',
                'no_hp' => '081234567805',
                'alamat' => 'Jl. KH Ahmad Dahlan No. 1, Surabaya',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '199106302014012003',
                'name' => 'Nur Hidayah, S.Pd.I',
                'email' => 'nur.hidayah@gmail.com',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Malang',
                'tanggal_lahir' => '1991-06-30',
                'no_hp' => '081234567806',
                'alamat' => 'Jl. Basuki Rahmat No. 45, Malang',
                'role' => 'walikelas',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($waliKelasList as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info(count($waliKelasList) . ' Wali Kelas records seeded successfully.');
    }
}

