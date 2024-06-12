<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\AppointmentService;
use App\Models\TimeSlot;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'service',
        'client',
        'person',
        'date',
        'time',
        'amount',
        'discount',
        'service_status',
        'payment_status',
        'appointment_type',
    ];

    public function client_detail(){
        return $this->hasOne(Client::class,'id','client');
    }
    public function services(){
        return $this->hasMany(AppointmentService::class,'appointment','id')->with('service_name');
    }

    public function timing(){
        return $this->hasOne(TimeSlot::class,'id','time');
    }
}
