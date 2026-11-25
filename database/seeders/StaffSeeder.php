<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffList = [
            [
                'nip' => '198203152008011005',
                'nama' => 'Drs. Hendro Wibowo, M.Pd',
                'email' => 'hendro.wibowo@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '198708222011012008',
                'nama' => 'Rina Marlina, S.Pd',
                'email' => 'rina.marlina@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '199011052015011004',
                'nama' => 'Faisal Rahman, S.Kom',
                'email' => 'faisal.rahman@gmail.com',
                'password' => Hash::make('password123'),
            ],
            [
                'nip' => '199204122018012006',
                'nama' => 'Ustadzah Halimah, S.Pd.I',
                'email' => 'halimah@gmail.com',
                'password' => Hash::make('password123'),
            ],
        ];

        foreach ($staffList as $data) {
            Staff::updateOrCreate(
                ['nip' => $data['nip']],
                $data
            );
        }

        $this->command->info(count($staffList) . ' Staff records seeded successfully.');
    }
}

