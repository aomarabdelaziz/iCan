<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class ValidateAccessToken
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


        if($request->wantsJson()){
            $bearerToken = $request->bearerToken();
            $personalAccessToken = PersonalAccessToken::findToken($bearerToken);
            if(!$personalAccessToken){
                return $this->error('Invalid acccess Token' , 401 ,"Access Token is not valid");
            }

        }

        return $next($request);
    }
}
