<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicWorkingHour extends Model
{
    use HasFactory;
    protected $table = 'clinic_working_hours';
    protected $guarded = [];

}
