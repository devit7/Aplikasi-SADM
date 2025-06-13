<?php

namespace App\Models;

use Exception;
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

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($waliKelas) {
            // Cek apakah wali kelas memiliki relasi kelas
            if ($waliKelas->kelas()->exists()) {
                throw new Exception('Wali kelas tidak dapat dihapus karena masih memiliki kelas yang terkait.');
            }
        });
    }
}
