<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'walikelas_id');
    }

    public function hasRole($role)
    {
        return $this->role === $role;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Check if the user has the required role to access the panel
        return $this->hasRole('admin');


    }
    

    /* protected $fillable = [
        'name',
        'email',
        'password',
    ]; */

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    /* protected $hidden = [
        'password',
        'remember_token',
    ]; */

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    /* protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    } */
}
