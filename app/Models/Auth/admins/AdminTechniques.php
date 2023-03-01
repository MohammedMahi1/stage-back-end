<?php

namespace App\Models\Auth\admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTechniques extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'CIN',
        'email',
        'password',
    ];
}
