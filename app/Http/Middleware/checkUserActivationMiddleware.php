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
        $user = User::where('token',explode('Bearer ',$request->headers->get('Authorization'))[1])->first();
        if($user->activated_at == null)
        {
            return response(['success' => false],200);
        }


        return $next($request);
    }
}
