<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
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

        return $this->success("Center has been $status");

    }
}
