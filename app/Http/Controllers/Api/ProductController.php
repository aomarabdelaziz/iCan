<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Store;
use App\Traits\ApiResponser;
use http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class ProductController extends Controller
{
    use ApiResponser;

    public function create(Request $request)
    {
        $validator =  Validator::make($request->all(),[
            'store_id' => ['required', 'int' , Rule::exists('stores' ,'id')->where(function ($query){
                    $query->where('user_id' , '=' , Auth::id());
            })],
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

    public function delete(Request $request)
    {
        $validator =  Validator::make($request->query(),[
            'id'=> ['required' , Rule::exists('products' , 'id')] ,
        ]);
        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        $validated  = $validator->validated();

        Product::findOrFail($validated['id'])->delete();
        return $this->success('Product deleted successfully');

    }

    public function updatePrice(Request $request)
    {

        $validator =  Validator::make($request->query(),[
            'id'=> ['required' , Rule::exists('products' , 'id')] ,
            'price' => ['required' , 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        $validated  = $validator->validated();

        Product::findOrFail($validated['id'])->update(['price' => $validated['price']]);


        return $this->success('Product price updated successfully');

    }


}
