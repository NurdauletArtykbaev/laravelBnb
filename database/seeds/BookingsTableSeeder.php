<?php

use App\Bookable;
use Illuminate\Database\Seeder;
use App\Booking;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable){
            $booking = factory(Booking::class)->make();
            $bookings = collect([$booking]);
            
            for($i=0; $i<random_int(0,20); $i++){
                $from = (clone $booking->to)->addDays(random_int(0,14));
                $to = (clone $booking->from)->addDays(random_int(0,14));

                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to
                ]);

                //bookings массивты толтырамыз
                $bookings->push($booking);

            }
            
            $bookable->bookings()->saveMany($bookings);
        });
    }
}
