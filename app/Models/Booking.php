<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class Booking extends ApiModel
{
    use HasFactory;

    protected $fillable=['id','startDate','endingDate','status','city','startCity','endingCity','customer_id','car_id','bookingType_id'];

}
