<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'walikelas_id');
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'staff_id');
    }
}