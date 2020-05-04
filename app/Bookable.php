<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Booking;

class Bookable extends Model
{
    protected $fillable = ['from', 'to'];
    public function bookings()
    {
        // 1:00
        return $this->hasMany(Booking::class);
    }
}
