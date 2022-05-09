<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PhoneNumber;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CenterStorePhoneController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'phone' => ['required' , 'regex:^01[0-2,5]\d{8}$^'],
            'category_id' => ['required' , 'int'],
            'category' => ['required' ,'string' , Rule::in(['center' , 'store'])],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        PhoneNumber::addNewPhoneNumber($validator->validated());

        return $this->success('Phone number has been added successfully');
    }
}
