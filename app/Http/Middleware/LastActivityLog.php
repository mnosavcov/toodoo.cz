<?php

namespace App\Http\Middleware;

use Closure;

class LastActivityLog
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
	    // last user activity log
	    $user = $request->user();
	    if ($user) {
		    $user->last_activity_at = time();
		    $user->save();
	    }

        return $next($request);
    }
}
