<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CenterBooking;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CenterBookingController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'center_id' => ['required' , Rule::exists('centers' , 'id')],
            'case_name' => ['required' , 'string'],
            'phone' => ['required' , 'regex:^01[0-2,5]\d{8}$^'],
            'booking_date' => ['required' ],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }


        CenterBooking::assignNewBooking($validator->validated());

        return $this->success("Booking has been submitted");
    }
}
