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
        $query = Center::query();
        
        $centers = $query->when(auth()->user()->role == 'user' , function ($query) {
            return $query->where('status' , '=' , 'accepted');
        })->when(auth()->user()->role == 'admin' , function ($query) {
            return $query;
        })->get();

        return $this->success($centers);
    }

}
