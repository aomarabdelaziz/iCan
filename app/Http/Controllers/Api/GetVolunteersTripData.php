<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Volunteer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class GetVolunteersTripData extends Controller
{
    use ApiResponser;
    public function __invoke(Request $request)
    {
        $volunteers = Volunteer::all();

        return $this->success($volunteers);
    }
}
