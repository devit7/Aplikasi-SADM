<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    //
    protected $table = 'users';
    protected $guarded = ['id'];

    protected $attributes = [
        'role' => 'walikelas',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'walikelas_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'walikelas_id');
    }
}
