<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAcces extends Model
{
    protected $table = 'staff_access';
    protected $guarded = ['id'];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
    public function matapelajaran()
    {
        return $this->belongsTo(Matapelajaran::class, 'matapelajaran_id');
    }
}
