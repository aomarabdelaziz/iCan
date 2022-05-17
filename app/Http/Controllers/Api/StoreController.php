<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name' => ['required' , 'string', 'max:255'],
            'address' => ['required' , 'string' , 'max:255'],
/*            'email' => ['required' , 'string' , 'email:filter,rfc,dns' , Rule::unique('stores' , 'email')],*/
            'store_image' => ['sometimes' , 'image' , 'mimes:jpg,png'],

        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        $store_path = Storage::disk('public')->put('images' , $request->file('store_image'));


        Store::createStore($validator->validated() , $store_path);

        return $this->success('Store created successfully');
    }
}
