<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersVolunteerRequest;
use App\Models\Volunteer;
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

        return $this->success('This Api Not Finished Yet');

        $validator =  Validator::make($request->all(),[
            'status' => ['required' , 'boolean'],
            'request_id' => ['required' , Rule::exists('users_volunteer_requests' , 'id')],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }

        $validated = $validator->validated();
        $isBusy = Volunteer::where('volunteer_id' , Auth::id())->where( 'end_date' , '=' ,  '' )->first();
        if($isBusy){
            return $this->error('Validation Error' , 401 ,'You are busy');
        }


        $query = UsersVolunteerRequest::firstWhere(['id' => $validated['request_id'] , 'volunteer_id' => Auth::id()]);


        $user_id = $query->user_id;
        $query->update(['status' => ($validated['status'] == 1 ? 'accepted' : 'rejected')]);

        Volunteer::create(
            [
                'volunteer_id' => Auth::id(),
                'request_id' => $validated['request_id'],
                'start_date' => Carbon::now(),
                'comment' => ''
            ]);


        UsersVolunteerRequest::firstWhere('user_id' , $user_id)
            ->where('id' , '!=' , $validated['request_id'] )->where('status' , '!='  ,'accepted')->delete();


        return $this->success('Volunteer request has accepted successfully');



    }
}
