<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductStore;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AddStoreProductController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {

        $validator =  Validator::make($request->all(),[

            'store_id' => ['required' , Rule::exists('stores' , 'id')],
            'product_id' => ['required' , Rule::exists('products' , 'id')]

        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 ,$validator->errors());
        }

        ProductStore::addProductToStore($validator->validated());

        return $this->success('Product added successfully to store');
    }
}
