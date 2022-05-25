<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UsersVolunteerRequest;
use App\Models\Volunteer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GetVolunteerTrip extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {

        $data = DB::table('users_volunteer_requests')
            ->join('volunteers' , 'users_volunteer_requests.id' , '=' , 'volunteers.id')
            ->where("volunteers.volunteer_id", '=' , Auth::id())->get();
        return $this->success($data);

    }
}
