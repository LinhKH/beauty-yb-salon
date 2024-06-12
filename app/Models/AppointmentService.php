<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Service;

class AppointmentService extends Model
{
    use HasFactory;

    protected $table = 'appointment_service';

    protected $fillable = [
        'appointment',
        'service',
        'agent',
        'qty',
        'service_price',
    ];

    public function service_name(){
        return $this->hasOne(Service::class,'id','service');
    }
}
