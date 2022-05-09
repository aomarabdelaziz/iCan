<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\Evaluation;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class GetCentersController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {
        $centers = Center::all();
        return $this->success($centers);
    }

}
