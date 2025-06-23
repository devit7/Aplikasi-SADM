<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{

    protected $table = 'absen'; // Ensure this matches your database table name
    protected $guarded = ['id'];

    public function detailKelas()
    {
        return $this->belongsTo(DetailKelas::class, 'detail_kelas_id');
    }

    protected static function boot()
    {
        parent::boot();

        // Validasi saat membuat absen baru
        static::creating(function ($absen) {
            if ($absen->tanggal != now()->format('Y-m-d')) {
                throw new Exception('Tanggal absen hanya boleh diisi untuk hari ini.');
            }
        });

        // Validasi saat mengupdate absen
        static::updating(function ($absen) {
            $today = now()->format('Y-m-d');
            $sixMonthsFromNow = now()->addMonths(6)->format('Y-m-d');

            if ($absen->tanggal < $today) {
                throw new Exception('Tanggal absen tidak boleh diisi dengan tanggal sebelum hari ini.');
            }

            if ($absen->tanggal > $sixMonthsFromNow) {
                throw new Exception('Tanggal absen tidak boleh lebih dari 6 bulan ke depan.');
            }
        });
    }
}
