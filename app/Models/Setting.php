<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'verification_start_date',
        'verification_end_date',
        'current_semester',
        'academic_year'
    ];
}
