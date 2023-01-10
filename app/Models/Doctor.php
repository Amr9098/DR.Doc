<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'specialization_id',
        'image',
        'bio',
        'clinic_count',
        'gender',
        'renewal',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function Specialization(){
        return $this->belongsTo(Specialization::class);
    }

    public function Assistants()
    {
       return $this->hasMany(Assistant::class);
    }
}
