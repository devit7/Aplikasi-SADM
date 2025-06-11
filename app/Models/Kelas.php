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
        return $this->hasMany(Matapelajaran::class, 'kelas_id');
    }

    public function countSiswa()
    {
        return $this->belongsToMany(Siswa::class, 'detail_kelas', 'kelas_id', 'siswa_id')->count();
    }

    /**
     * Get all Al-Quran subcategories associated with this class
     */
    public function alQuranSubcategories()
    {
        return $this->belongsToMany(AlQuranLearningSubcategory::class, 'al_quran_subcategory_kelas', 'kelas_id', 'subcategory_id')
            ->withTimestamps();
    }

    /**
     * Get all Extrakurikuler categories associated with this class
     */
    public function extrakurikulerCategories()
    {
        return $this->belongsToMany(ExtrakurikulerCategory::class, 'extrakurikuler_category_kelas', 'kelas_id', 'category_id')
            ->withTimestamps();
    }

    /**
     * Get all Worship Character categories associated with this class
     */
    public function worshipCategories()
    {
        return $this->belongsToMany(WorshipCharacterCategory::class, 'worship_category_kelas', 'kelas_id', 'category_id')
            ->withTimestamps();
    }
}
