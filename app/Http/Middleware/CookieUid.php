<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\CookieService;

class CookieUid
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
        $app = app();
        $service = $app->make(CookieService::class);
        $service->getOrSetCookieUid();

        return $next($request);
        

    //    return redirect('/')->with('error','You have not admin access');
    }
}