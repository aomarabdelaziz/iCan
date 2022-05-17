<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Store;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CenterController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[

            'name' => ['required' , 'string' , 'max:255'],
/*            'email' => ['required' , 'string' , 'email:filter,rfc,dns' , Rule::unique('centers' , 'email')],*/
            'about' => ['required' , 'string' , 'max:255'],
            'center_image' => ['sometimes' , 'image' , 'mimes:jpg,png'],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

       if($request->hasFile('center_image')){
           $center_path = Storage::disk('public')->put('images' , $request->file('center_image'));
       }

        Center::addNewCenter($validator->validated() , $center_path ?? '');

        return $this->success('Center has been created');
    }
}
