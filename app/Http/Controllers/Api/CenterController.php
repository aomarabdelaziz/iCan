<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Store;
use App\Models\User;
use App\Notifications\SendPushNotification;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Notification;

class CenterController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[

            /*'email' => ['required' , 'string' , 'email:filter,rfc,dns' , Rule::unique('centers' , 'email')],*/
            'name' => ['required' , 'string' , 'max:255'],
            'about' => ['required' , 'string' , 'max:255'],
            'center_image' => ['sometimes' , 'image' , 'mimes:jpg,png'],
            'phone_number' => ['required' , 'regex:^01[0-2,5]\d{8}$^'],
            'address' => ['required' , 'string'],
        ]);

        if($validator->fails()){

            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

       if($request->hasFile('center_image')){
           $center_path = Storage::disk('public')->put('images' , $request->file('center_image'));
       }

        Center::addNewCenter($validator->validated() , $center_path ?? '');

        $allAdmins = User::whereRole('admin')->get();
        $userName = Auth::user()->first_name . ' ' . Auth::user()->last_name;
        Notification::send($allAdmins, new SendPushNotification("Creating New Center","$userName Asking for Center\nApproval",$allAdmins->pluck('fcm_token')->toArray()));

        return $this->success('Center has been created');
    }
}
