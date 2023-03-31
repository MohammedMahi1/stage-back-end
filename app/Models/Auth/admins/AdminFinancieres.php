<?php

namespace App\Models\Auth\admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AdminFinancieres extends  Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'fullname',
        'CIN',
        'email',
        'password',
        'image_profile',
        'image_url',
    ];
}
