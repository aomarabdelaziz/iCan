<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CreateAdminController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $validator =  Validator::make($request->all(),[

            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'string' , 'email:filter,rfc,dns' , Rule::unique('users','email')],
            'password' => [Password::min(8)->letters()->mixedCase()->numbers() , 'confirmed'],
            'phone' => ['required' , 'regex:^01[0-2,5]\d{8}$^'],
        ]);

        if($validator->fails()){
            return $this->error('Validation Error' , 401 ,$validator->errors());
        }

        $validated = $validator->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'role' => 'admin',

        ]);
        return $this->success('Admin created successfully');
    }
}
