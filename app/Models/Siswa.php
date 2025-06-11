<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    //
    protected $table = 'siswa';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class, 'detail_kelas', 'siswa_id', 'kelas_id');
    }

    public function detailKelas()
    {
        return $this->hasMany(DetailKelas::class, 'siswa_id');
    }

    public function detailPresensi()
    {
        return $this->hasMany(DetailPresensi::class);
    }

    /**
     * Get all Al-Quran assessments for this student
     */
    public function alQuranAssessments()
    {
        return $this->hasMany(AlQuranStudentAssessment::class, 'siswa_id');
    }

    /**
     * Get all Extrakurikuler assessments for this student
     */
    public function extrakurikulerAssessments()
    {
        return $this->hasMany(ExtrakurikulerStudentAssessment::class, 'siswa_id');
    }

    /**
     * Get all Worship assessments for this student
     */
    public function worshipAssessments()
    {
        return $this->hasMany(WorshipStudentAssessment::class, 'siswa_id');
    }

    /**
     * Get all Al-Quran courses for this student
     */
    public function alQuranCourses()
    {
        return $this->belongsToMany(AlQuranLearningSubcategory::class, 'siswa_alquran_courses', 'siswa_id', 'subcategory_id')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    /**
     * Get all Extrakurikuler courses for this student
     */
    public function extrakurikulerCourses()
    {
        return $this->belongsToMany(ExtrakurikulerCategory::class, 'siswa_extrakurikuler_courses', 'siswa_id', 'category_id')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }

    /**
     * Get all Worship courses for this student
     */
    public function worshipCourses()
    {
        return $this->belongsToMany(WorshipCharacterCategory::class, 'siswa_worship_courses', 'siswa_id', 'category_id')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }
}
