<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersVolunteerRequest;
use App\Notifications\SendPushNotification;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserVolunteerRequestController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'volunteer_type' => ['required' , Rule::in(['sitter' , 'driver'])],
            'from' => ['sometimes' , 'string'],
            'to' => ['sometimes' , 'string'],
            'date' => ['required' , 'string'],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }


        UsersVolunteerRequest::createRequest($validator->validated());
        $allVolunteers = User::whereRole('volunteer')->whereVolunteerType($request->volunteer_type)->get();
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        Notification::send($allAdmins, new SendPushNotification("Volunteer Request","$userName Asking for Volunteering Request",$allVolunteers->pluck('fcm_token')->toArray()));

        return $this->success('Volunteer request has been sent successfully');


    }
}
