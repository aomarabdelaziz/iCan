<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;

class CheckAuthenticatedCenterRole
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $role = $request->user()->role;
        if($role != 'center'){
            return $this->error('Permission is denied' , 401 ,"You don't have the permission to access this page, due to your role");
        }
        return $next($request);
    }
}
