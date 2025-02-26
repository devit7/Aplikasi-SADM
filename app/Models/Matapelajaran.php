<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matapelajaran extends Model
{
    //

    protected $table = 'matapelajaran';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'matapelajaran_id');
    }
}
