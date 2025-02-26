<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
    protected $table = 'siswa';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'detail_kelas', 'siswa_id', 'kelas_id');
    }

    public function detailKelas()
    {
        return $this->hasMany(DetailKelas::class, 'siswa_id');
    }
}
