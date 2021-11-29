<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class checkUserActivationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->headers->get('Authorization');
        $user = User::where('token',explode('Bearer ',$token)[1])->first();
        if($request->user())
        {
            return response(['success' => false],200);
        }


        return $next($request);
    }
}
