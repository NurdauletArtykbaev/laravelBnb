<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Booking;

class Bookable extends Model
{
    public function bookings()
    {
        // 1:00
        return $this->hasMany(Booking::class);
    }

    public function reviews(){
        return $this->hasMany(Review::class);
    }

    public function availableFor($from, $to) :bool
    {
        return 0 === $this->bookings()->betweenDates($from, $to)->count(); 
    }
}
