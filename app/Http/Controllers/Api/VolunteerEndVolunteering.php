<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersVolunteerRequest;
use App\Models\Volunteer;
use App\Notifications\SendPushNotification;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $query =  UsersVolunteerRequest::firstWhere('id' , $validated['request_id']);
        $userId = $query->user_id;
        $user = User::findOrFail($userId);
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $query->update(['status' => 'finished']);
        $user->notify(new SendPushNotification("Volunteer Trip","$userName has been ended\n your volunteering trip" ,$user->fcm_token));

        return $this->success('Your volunteering is ended successfully');


    }
}
