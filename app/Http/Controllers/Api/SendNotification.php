<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\SendPushNotification;
use Illuminate\Http\Request;
use Kutia\Larafirebase\Services\Larafirebase;

class SendNotification extends Controller
{

    public function now(Request $request)
    {
        $fcmTokens = auth()->user()->fcm_token;
        auth()->user()->notify(new SendPushNotification($request->title,$request->message,$fcmTokens));

    }
    public function notification(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);

        try{
            $fcmTokens = User::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();

            //Notification::send(null,new SendPushNotification($request->title,$request->message,$fcmTokens));

            /* or */

            //auth()->user()->notify(new SendPushNotification($title,$message,$fcmTokens));

            /* or */

            \Kutia\Larafirebase\Facades\Larafirebase::withTitle($request->title)
                ->withBody($request->message)
                ->sendMessage($fcmTokens);

            return redirect()->back()->with('success','Notification Sent Successfully!!');

        }catch(\Exception $e){
            report($e);
            return redirect()->back()->with('error','Something goes wrong while sending notification.');
        }
    }
}
