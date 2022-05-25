<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UsersVolunteerRequest;
use App\Models\Volunteer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetVolunteerTrip extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        $data = Volunteer::where('volunteer_id' , Auth::id())->whereNull('end_date')->first();
        return $this->success($data);

    }
}
