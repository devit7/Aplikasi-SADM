<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{

    protected $table = 'absen'; // Ensure this matches your database table name
    protected $guarded = ['id'];

    public function detailKelas()
    {
        return $this->belongsTo(DetailKelas::class, 'detail_kelas_id');
    }
}
