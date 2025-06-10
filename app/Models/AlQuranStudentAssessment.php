<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlQuranStudentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'subcategory_id',
        'predicate',
        'explanation',
        'updated_at',
        'created_by',
        'staff_id',
    ];

    /**
     * Get the subcategory associated with this assessment
     */
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(AlQuranLearningSubcategory::class, 'subcategory_id');
    }

    /**
     * Get the student associated with this assessment
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    /**
     * Get the user who created this assessment
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the staff who assessed this student
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
