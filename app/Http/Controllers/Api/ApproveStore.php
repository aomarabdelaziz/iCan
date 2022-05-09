<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ApproveStore extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'status' => [ 'required' , 'boolean'],
            'store_id' => ['required' , Rule::exists('stores' , 'id')]
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        $status = Store::updateStoreStatus($validator->validated());

        return $this->success("Store has been $status");

    }
}
