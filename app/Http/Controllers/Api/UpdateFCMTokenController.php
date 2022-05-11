<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class UpdateFCMTokenController extends Controller
{

    use ApiResponser;
    public function updateToken(Request $request)
    {
        try{

            $request->user()->update(['fcm_token'=>$request->token]);
            return response()->json([
                'success'=>true
            ]);

        }catch(\Exception $e){

            report($e);
            return response()->json([
                'success'=>false
            ],500);

        }
    }
}
