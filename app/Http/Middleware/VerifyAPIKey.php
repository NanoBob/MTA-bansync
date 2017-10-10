<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class VerifyAPIKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $server = User::where("api_key",$request->get("api_key"))->first();
        if (! $server){
            abort(403, 'Access denied');
        } else {
            app()->server = $server;
        }
        return $next($request);
    }
}
