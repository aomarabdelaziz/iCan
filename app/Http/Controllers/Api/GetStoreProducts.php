<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GetStoreProducts extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'store_id' => ['sometimes' , Rule::exists('stores' , 'id')],
        ]);

        if($validator->fails()){
            return $this->error('Store Not Existing' , 401 ,$validator->errors());
        }


       $query = Product::query();

       $products = $query->when( $request->filled('store_id'), function ($query) use ($request) {
           return $query->whereStoreId($request->store_id);
       })->when($request->missing('store_id') , function ($query) {
                return $query;
       })->get();

       return $this->success($products);

    }
}
