<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class GetStoresController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {

        $query = Store::query();

        $centers = $query->when((auth()->user()->role == 'user') || (auth()->user()->role == 'store'), function ($query) {
            return $query->where('status' , '=' , 'accepted');
        })->when(auth()->user()->role == 'admin' , function ($query) {
            return $query;
        })->get();

        return $this->success($stores);
    }
}
