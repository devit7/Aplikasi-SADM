<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorshipStudentAssessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'siswa_id',
        'predicate',
        'explanation',
        'notes',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the category associated with this assessment
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(WorshipCharacterCategory::class, 'category_id');
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
     * Get the user who last updated this assessment
     */
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
