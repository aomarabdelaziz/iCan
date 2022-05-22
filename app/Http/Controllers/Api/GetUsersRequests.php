<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Center;
use App\Models\UsersVolunteerRequest;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetUsersRequests extends Controller
{
    use ApiResponser;

    public function __invoke(Request $request)
    {

        $query = UsersVolunteerRequest::query();

        $requests = $query->when(auth()->user()->role == 'volunteer' && auth()->user()->volunteer_type == 'sitter'  , fn($query) => $query->whereStatus('pending')->whereVolunteerType('sitter'))
            ->wwhen(auth()->user()->role == 'volunteer' && auth()->user()->volunteer_type == 'driver'  , fn($query) => $query->whereStatus('pending')->whereVolunteerType('driver'))
            ->get();


        return $this->success($requests);
    }
}
