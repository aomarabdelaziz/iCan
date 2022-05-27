<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendPushNotification;
use App\Rules\CheckTheRequestAvailability;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Kutia\Larafirebase\Services\Larafirebase;

class SendNotification extends Controller
{

    use ApiResponser;
    public function now(Request $request)
    {
        $fcmTokens = auth()->user()->fcm_token;
        auth()->user()->notify(new SendPushNotification($request->title,$request->message,$fcmTokens));


    }
    public function notification(Request $request)
    {




        $validator =  Validator::make($request->all(),[
            'title'=> ['required' , 'string'],
            'title'=> ['required' , 'string'],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }

        try{
            $fcmTokens = Auth::user()->fcm_token;

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

           // auth()->user()->notify(new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            $data = \Kutia\Larafirebase\Facades\Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);


            return $this->success(    $data);


        }catch(\Exception $e){
            report($e);
            return $this->error('Something goes wrong while sending notification.' , 401 ,$e->getMessage());

        }
    }
}
