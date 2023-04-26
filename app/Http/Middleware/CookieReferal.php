<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\CookieService;

class CookieReferal
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
        $service->getOrSetCookiePartner();//Учет наличия партнерской ссылки и сохранение оной в кукис

        return $next($request);
        

    //    return redirect('/')->with('error','You have not admin access');
    }
}