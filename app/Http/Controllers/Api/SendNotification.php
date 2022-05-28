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
//use Kutia\Larafirebase\Services\Larafirebase;
use Kutia\Larafirebase\Facades\Larafirebase;


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
            'message'=> ['required' , 'string'],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }

        try{

            //$fcmTokens = auth()->user()->fcm_token;

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */
/*
            $data = \Kutia\Larafirebase\Facades\Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);*/

          /*  $data =  Larafirebase::withTitle('Test Title')
                ->withBody('Test body')
                ->sendMessage($fcmTokens);*/

           // $firebaseToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();

            $firebaseToken = auth()->user()->fcm_token;


            $data = [
                "to" => $firebaseToken,
                "notification" => [
                    "title" => $request->title,
                    "body" => $request->message,
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

            $response = curl_exec($ch);






            //$response = Http::withHeaders($headers)->withBody($dataString , 'application/json')->post("https://fcm.googleapis.com/fcm/send");





            return $this->success($response);
           // return redirect()->back()


        }catch(\Exception $e){
            report($e);
            return $this->error('Something goes wrong while sending notification.' , 401 ,$e->getMessage());

        }
    }
}
