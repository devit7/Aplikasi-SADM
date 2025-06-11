<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    //

    protected $table = 'nilai';
    protected $guarded = ['id'];

    public function detailKelas()
    {
        return $this->belongsTo(DetailKelas::class, 'detail_kelas_id');
    }
    public function mataPelajaran()
    {
        return $this->belongsTo(Matapelajaran::class, 'matapelajaran_id');
    }

}
