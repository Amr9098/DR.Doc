<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistant extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'address',
        'gender',
        'image',
        'user_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
