<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Volunteer;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FetchVolunteersController extends Controller
{
    use ApiResponser;
    public function __invoke()
    {
        $volunteers = User::where('role' , 'volunteer')->get();
        return $this->success($volunteers);


    }
}
