<?php

namespace App\Filament\Widgets;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsDashboard extends BaseWidget
{
    protected function getStats(): array
    {
        $totalSiswa = Siswa::count();
        $totalWaliKelas = User::where('role', 'walikelas')->count();
        $totalSiswaTahunIni = Siswa::whereYear('created_at', date('Y'))->count();
        $totalKelasTahunIni = Kelas::whereYear('created_at', date('Y'))->count();
        return [
            //
            Stat::make('Siswa', $totalSiswa )->color('success')->description('Total Siswa yang terdaftar'),
            Stat::make('Siswa', $totalSiswaTahunIni )->color('primary')->description('Siswa yang terdaftar tahun ini'),
            Stat::make('Wali Kelas', $totalWaliKelas )->color('warning')->description('Total Wali Kelas'),
            Stat::make('Kelas Tahun Ini', $totalKelasTahunIni )->color('danger')->description('Kelas yang dibuat tahun ini'),
        ];
    }
}
