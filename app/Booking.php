<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bookable;

class Booking extends Model
{
    public function bookables()
    {
        return $this->belongsTo(Bookable::class);
    }
}
