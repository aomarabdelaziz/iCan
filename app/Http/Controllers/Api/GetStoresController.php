<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetStoresController extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {


        $query = Store::query();

        $state = $request->query('state' ?? 'accepted');

        $stores = $query->when(auth()->user()->role == 'user'  , fn($query) => $query->whereStatus($state))
            ->when(auth()->user()->role == 'store' , fn($query)=> $query->whereUserId(Auth::id()))
            ->when(auth()->user()->role == 'admin' , fn($query)=> $query->whereStatus($state))
            ->get();


    /*    $stores = $query->when(auth()->user()->role == 'user' , function ($query) {
            return $query->where('status' , '=' , 'accepted');
        })->when(auth()->user()->role == 'store' , function ($query) {
            return $query->whereUserId(Auth::id());
        })->when(auth()->user()->role == 'admin' , function ($query) {
            return $query;
        })->get();*/


        return $this->success($stores);
    }
}
