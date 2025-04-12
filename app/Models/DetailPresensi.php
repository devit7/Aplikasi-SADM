<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPresensi extends Model
{
    use HasFactory;

    protected $table = 'detail_presensi';
    protected $fillable = ['presensi_id', 'siswa_id', 'status'];

    public function presensi()
    {
        return $this->belongsTo(Presensi::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
