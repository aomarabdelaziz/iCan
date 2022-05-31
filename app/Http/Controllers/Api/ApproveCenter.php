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
        $centerOwner = User::findOrFail(Center::firstWhere('id' , $request->center_id)->user_id);

        $centerOwner->notify(new SendPushNotification("Center Approval Request","Admin has $status your center request" ,$centerOwner->fcm_token));



      /*  $data = [
            "to"  => $centerOwner->fcm_token,
            "notification" => [
                "title" => 'Center Approval Request',
                "body" => 'Admin has $status your center request',
            ]
        ];
        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . env('FIREBASE_SERVER_KEY'),
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        return curl_exec($ch);*/


        return $this->success("Center has been $status");

    }
}
