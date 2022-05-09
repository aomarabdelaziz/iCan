<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Traits\ApiResponser;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'name' => ['required', 'string' , 'max:255'],
            'description' => ['required' , 'string' , 'max:255'],
            'price' => ['required' , 'regex:/^\d+(\.\d{1,2})?$/'],
            'image' =>[ 'required' , 'image' , 'mimes:jpg,png'],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }


        $image_path = Storage::disk('public')->put('images' , $request->file('image'));

        Product::createNewProduct($validator->validated() , $image_path);

        return $this->success('Product created successfully');
    }


}
