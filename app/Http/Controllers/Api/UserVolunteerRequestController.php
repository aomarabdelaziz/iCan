<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UsersVolunteerRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserVolunteerRequestController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'volunteer_id' => ['required' , Rule::exists('users' , 'id')],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }


        $validated = $validator->validated();

        $volunteer_type = User::firstWhere('id' ,$validated['volunteer_id'])->role;
        if(!$volunteer_type == 'volunteer'){
            return $this->error('Validation Error' , 401 ,'this person is not a volunteer user');

        }

        UsersVolunteerRequest::createRequest($validated);

        return $this->success('Volunteer request has been sent successfully');


    }
}
