<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersVolunteerRequest;
use App\Models\Volunteer;
use App\Notifications\SendPushNotification;
use App\Rules\CheckTheRequestAvailability;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class VolunteerAcceptRequestController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {

        $validator =  Validator::make($request->all(),[
            'request_id' => ['required' , Rule::exists('users_volunteer_requests' , 'id') , new CheckTheRequestAvailability()],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }


        $validated = $validator->validated();




        $isBusy = Volunteer::where('volunteer_id' , Auth::id())->whereNull('end_date')->first();
        if(!is_null($isBusy))
        {
            return $this->error('You are busy' , 401 ,'You cannot accept a volunteer request right now, while you are in another trip');
        }


        $query = UsersVolunteerRequest::firstWhere(['id' => $validated['request_id']]);
        $userId = $query->user_id;
        $query->update(['status' => 'accepted']);

        $user = User::findOrFail($userId);
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        $user->notify(new SendPushNotification("Volunteer Request","$userName has been accepted your volunteering request" ,$user->fcm_token));

        Volunteer::create(
            [
                'volunteer_id' => Auth::id(),
                'request_id' => $validated['request_id'],
                'start_date' => Carbon::now(),
                'comment' => ''
            ]);



        return $this->success('Volunteer request has accepted successfully');



    }
}
