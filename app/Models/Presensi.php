<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensis';
    protected $fillable = ['tanggal', 'kelas_id', 'status'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class);
    }
}
