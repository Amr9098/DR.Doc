<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $fillable = [
        'manger_id',
        'assistant_id',
        'name',
        'phone',
        'image',
        'address',
        'count',
    ];
    public function manger(){
        return $this->belongsTo(doctor::class,"manger_id");
    }
    public function assistant(){
        return $this->belongsTo(assistant::class,"assistant_id");
    }
    public function user(){
        return $this->belongsTo(User::class);
    }

}
