<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class GetAuthUserToken extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        return $this->success($request->bearerToken());
    }
}
