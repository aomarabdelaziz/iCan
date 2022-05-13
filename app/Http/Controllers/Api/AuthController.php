<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Laravel\Sanctum\PersonalAccessToken;


class AuthController extends Controller
{
    use ApiResponser;


    public function register(Request $request)
    {
        $validator =  Validator::make($request->all(),[

            'first_name' => ['required' , 'string' , 'max:255'],
            'last_name' => ['required' , 'string' , 'max:255'],
            'email' => ['required' , 'string' , 'email:filter,rfc,dns' , Rule::unique('users','email')],
            'password' => [Password::min(8)->letters()->mixedCase()->numbers() , 'confirmed'],
            'phone' => ['required' , 'regex:^01[0-2,5]\d{8}$^'],
            'national_id' => ['sometimes' , 'image' , 'mimes:jpg,png'],
            'license_id' => ['sometimes' , 'image' , 'mimes:jpg,png'],
            'role' => ['required' , 'string'],
            'volunteer_type' => ['sometimes' , 'string' , Rule::in(['sitter' , 'driver'])],
        ]);

        if($validator->fails()){
            return $this->error('Validation error' , 401 , $validator->errors());
        }

        $validated = $validator->validated();


        if($validated['role'] == 'volunteer' )
        {

           if(!$request->hasFile('national_id')){

                return $this->error('Validation error' , 401 ,'National id must be exist');
            }

            $national_path = Storage::disk('public')->put('images' , $request->file('national_id'));
            $validated['national_id'] = $national_path;

           if($validated['volunteer_type'] == 'driver'){
                if(!$request->hasFile('license_id')){
                    return $this->error('Validation error' , 401 ,'Lisence id must be exist');
                }
                $License_path =  Storage::disk('public')->put('images' , $request->file('license_id'));
                $validated['license_id'] = $License_path;
            }


        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'phone' => $validated['phone'],
            'national_id' => ($validated['national_id'] ?? ''),
            'license_id' => ($validated['license_id'] ?? ''),
            'role' => $validated['role'],
            'volunteer_type' => $validated['volunteer_type'] ?? 'null',
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {

        if(auth('sanctum')->check())
        {
            return $this->error('You must logout' , 401);
        }


        $attr = $request->validate([
            'email' => ['required' , 'string' , 'email:filter,rfc,dns'],
            'password' => [Password::min(8)->letters()->mixedCase()->numbers() ],
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken,
            'role' => auth()->user()->role
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'User Logged out'
        ];
    }

    public function changePassword(Request $request)
    {
        if(auth('sanctum')->check())
        {
            $validator =  Validator::make($request->all(),[
                'password' => ['required'],
                'new_password' => [ 'required', Password::min(8)->letters()->mixedCase()->numbers() , 'confirmed' ],
            ]);

            if($validator->fails()){
                return $this->error('Validation Error' , 401 ,$validator->errors());
            }

            $validated = $validator->validated();

            if (!Hash::check($validated['password'], auth()->user()->password))
            {
                return $this->error('Validation Error' , 401 ,"Password don't match");

            }

            auth()->user()->fill([
                'password' => Hash::make($validated['new_password'])
            ])->save();

            return $this->success("Password Changed");


        }

    }


    public function getUserDataByToken(Request $request)
    {


        $personalAccessToken = PersonalAccessToken::findToken($request->plainTextToken);

        $user = $personalAccessToken->tokenable;

        return $this->success($user);
        dd($user);
    }

}
