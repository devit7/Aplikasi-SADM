<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffAcces extends Model
{
    protected $table = 'staff_access';
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'akses_nilai' => 'boolean',
        'akses_absen' => 'boolean',
        'akses_alquran_learning' => 'boolean',
        'akses_extrakurikuler' => 'boolean',
        'akses_worship_character' => 'boolean',
    ];

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

    /**
     * Get all Al-Quran subcategories that this staff access is assigned to
     */
    public function alQuranSubcategories()
    {
        return $this->belongsToMany(AlQuranLearningSubcategory::class, 'al_quran_subcategory_staff_access', 'staff_access_id', 'subcategory_id')
            ->withTimestamps();
    }

    /**
     * Get all Extrakurikuler categories that this staff access is assigned to
     */
    public function extrakurikulerCategories()
    {
        return $this->belongsToMany(ExtrakurikulerCategory::class, 'extrakurikuler_category_staff_access', 'staff_access_id', 'category_id')
            ->withTimestamps();
    }

    /**
     * Get all Worship Character categories that this staff access is assigned to
     */
    public function worshipCategories()
    {
        return $this->belongsToMany(WorshipCharacterCategory::class, 'worship_category_staff_access', 'staff_access_id', 'category_id')
            ->withTimestamps();
    }
}
