<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UsersVolunteerRequest;
use App\Models\Volunteer;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VolunteerEndVolunteering extends Controller
{
    use ApiResponser;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'request_id' => ['required' , Rule::exists('users_volunteer_requests' , 'id')],
        ]);


        $validated = $validator->validated();

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }

        Volunteer::firstWhere('request_id' , $validated['request_id'])->update(['end_date' => Carbon::now()]);
        UsersVolunteerRequest::firstWhere('request_id' , $validated['request_id'])->update(['status' => 'finished']);
        return $this->success('Your volunteering is ended successfully');


    }
}
