<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ExtrakurikulerCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama', 'deskripsi', 'predicates', 'explanations'];

    protected $casts = [
        'predicates' => 'array',
        'explanations' => 'array',
    ];

    /**
     * Get all assessments for this category
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(ExtrakurikulerStudentAssessment::class, 'category_id');
    }

    /**
     * Get all staff accesses for this category
     */
    public function staffAccesses(): BelongsToMany
    {
        return $this->belongsToMany(StaffAcces::class, 'extrakurikuler_category_staff_access', 'category_id', 'staff_access_id')
            ->withTimestamps();
    }

    /**
     * Get all classes for this category
     */
    public function kelas(): BelongsToMany
    {
        return $this->belongsToMany(Kelas::class, 'extrakurikuler_category_kelas', 'category_id', 'kelas_id')
            ->withTimestamps();
    }
}
