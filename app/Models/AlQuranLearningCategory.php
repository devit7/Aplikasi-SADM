<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlQuranLearningCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['nama'];

    /**
     * Get all subcategories for this category
     */
    public function subcategories(): HasMany
    {
        return $this->hasMany(AlQuranLearningSubcategory::class, 'category_id');
    }

    public function staffAccesses()
    {
        return $this->belongsToMany(StaffAcces::class, 'al_quran_category_staff_access', 'category_id', 'staff_access_id');
    }
}
