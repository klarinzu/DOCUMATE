<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentVerification extends Model
{
    const STATUS_VERIFIED = 'verified';
    const STATUS_REJECTED = 'rejected';
    protected $fillable = [
        'user_id',
        'student_number', // ✅ ADD THIS
        'e_slip_path', // optional but good for audit
        'ocr_data', // ✅ FIXED NAME
        'status',
        'semester',
        'academic_year',
        'verified_at'
    ];

    protected $casts = [
        'ocr_data' => 'array', // ✅ MATCH YOUR LIVEWIRE
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}