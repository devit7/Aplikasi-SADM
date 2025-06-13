<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    //
    protected $table = 'users';
    protected $guarded = ['id'];
    protected $attributes = [
        'role' => 'admin',
    ];
}
