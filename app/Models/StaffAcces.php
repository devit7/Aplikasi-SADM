<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Validasi sebelum create
            $model->validateUniqueAccess();
        });

        static::updating(function ($model) {
            // Validasi sebelum update
            $model->validateUniqueAccess($model->id);
        });
    }

    /**
     * Validate unique staff access combination
     */
    protected function validateUniqueAccess($excludeId = null)
    {
        $query = self::where('staff_id', $this->staff_id)
            ->where('kelas_id', $this->kelas_id)
            ->where('matapelajaran_id', $this->matapelajaran_id);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        if ($query->exists()) {
            $staff = $this->staff;
            $kelas = $this->kelas;
            $matapelajaran = $this->matapelajaran;

            throw ValidationException::withMessages([
                'duplicate_access' => "Staff {$staff->nama} sudah memiliki akses untuk mata pelajaran {$matapelajaran->nama_mapel} di kelas {$kelas->nama_kelas}"
            ]);
        }
    }

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
