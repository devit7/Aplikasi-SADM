<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlQuranLearningSubcategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['category_id', 'sub_nama', 'tahun_ajaran'];

    /**
     * Get the category that owns this subcategory
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(AlQuranLearningCategory::class, 'category_id');
    }

    /**
     * Get all assessments for this subcategory
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(AlQuranStudentAssessment::class, 'subcategory_id');
    }

    /**
     * Get all staff accesses associated with this subcategory
     */
    public function staffAccesses(): BelongsToMany
    {
        return $this->belongsToMany(StaffAcces::class, 'al_quran_subcategory_staff_access', 'subcategory_id', 'staff_access_id')
            ->withTimestamps();
    }

    /**
     * Get all classes associated with this subcategory
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'al_quran_subcategory_kelas', 'subcategory_id', 'kelas_id')
            ->withTimestamps();
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(Siswa::class, 'siswa_alquran_courses', 'subcategory_id', 'siswa_id')
            ->withPivot('assigned_by')
            ->withTimestamps();
    }
}
