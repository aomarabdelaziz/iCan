<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Evaluation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GetCentersController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $centers = Center::where('status' , '=' , 'accepted')->get();
        return $this->success($centers);
    }

}
