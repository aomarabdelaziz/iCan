<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GetUserCenters extends Controller
{
    use ApiResponser;



    public function __invoke(Request $request)
    {
        $centers =  Center::whereUserId(Auth::id())->get();
        return $this->success($centers);
    }
}
