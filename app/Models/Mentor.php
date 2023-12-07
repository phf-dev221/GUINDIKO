<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Mentor extends Authenticatable
{
    use HasFactory ,HasApiTokens;

    protected $fillable = [
        'nom',
        'telephone',
        'nombre_annee_experience',
        'email',
        'password',
        'role',
        'is_archived',
        'nombre_mentores',
        'photo_profil',
        'article_id'
    ];

    protected $hidden = [
        'password',
    ];
}
