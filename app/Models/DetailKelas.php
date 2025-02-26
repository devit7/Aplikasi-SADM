<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailKelas extends Model
{
    //

    protected $table = 'detail_kelas';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'detail_kelas_id');
    }

    public function absen()
    {
        return $this->hasMany(Absen::class, 'detail_kelas_id');
    }

}
