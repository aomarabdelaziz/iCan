<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\User;
use App\Notifications\SendPushNotification;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApproveCenter extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),
            [
                'status' => ['required' , 'boolean'],
                'center_id' => ['required', Rule::exists('centers','id')]
            ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }

        $status = Center::updateCenterStatus($validator->validated());
        $centerOwner = User::findOrFail(Center::firstWhere('id' , $request->center_id)->id);
        $centerOwner->notify(new SendPushNotification("Center Approval Request","Admin has $status your center request" ,$centerOwner->fcm_token));

        return $this->success("Center has been $status");

    }
}
