<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'appointment_address','user_id','date','client_first_name','client_last_name','client_email','client_address','client_phone','location_distence','duration','appointment_lat','appointment_long'
    ];


}
