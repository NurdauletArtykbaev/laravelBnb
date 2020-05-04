<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bookable;

class BookableAvailabilityController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {

        dd($request->all());
        // $data = $request->validate([
        //     'from' => 'required|date_format:Y-m-d|after_or_equal:now',

        //     'to' => 'required|date_format:Y-m-d|after_or_equal:from',

        // ]);
        $bookalbe = Bookable::findOrFail($id);
        dd($bookalbe->bookings);
        return 'none';
    }
}
