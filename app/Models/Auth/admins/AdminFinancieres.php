<?php

namespace App\Models\Auth\admins;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFinancieres extends Model
{
    use HasFactory;
    protected $fillable = [
        'fullname',
        'CIN',
        'email',
        'password',
    ];
}
