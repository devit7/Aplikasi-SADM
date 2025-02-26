<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    //

    protected $table = 'kelas';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'walikelas_id');
    }

    public function detailKelas()
    {
        return $this->hasMany(DetailKelas::class, 'kelas_id');
    }

    public function siswa()
    {
        return $this->belongsToMany(Siswa::class, 'detail_kelas', 'kelas_id', 'siswa_id');
    }

    public function matapelajaran()
    {
        return $this->hasMany(MataPelajaran::class, 'kelas_id');
    }

    public function countSiswa()
    {
        return $this->belongsToMany(Siswa::class, 'detail_kelas', 'kelas_id', 'siswa_id')->count();
    }

}
