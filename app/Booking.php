<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bookable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Booking extends Model
{
    
    protected $fillable = ['from', 'to'];

    public function bookable()
    {
        return $this->belongsTo(Bookable::class);
    }

    public function rewview(){
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(Builder $query, $from, $to){
        return $query->where('to', '>=', $from)
        ->where('from', '<=', $to);
    }


    // event или observer букингты создаьб еткенде ключты создать етеды ревюга
    protected static function boot(){
        parent::boot();

        static::creating(function (Booking $booking){
            $booking->review_key = Str::uuid();
        });
    }

    public static function findByReviewKey(string $reviewKey): ?Booking
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();

    }
}
