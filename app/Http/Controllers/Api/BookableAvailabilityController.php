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
    public function __invoke(Request $request, $id)
    {

        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',

            'to' => 'required|date_format:Y-m-d|after_or_equal:from',

        ]);

        $bookalbe = Bookable::findOrFail($id);
        // dd($bookalbe->bookings()->betweenDates($data['from'], $data['to'])->count());

        return $bookalbe->availableFor($data['from'], $data['to']) ? response()->json([]) : response()->json([], 404);
    }
}
