<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsPartner
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
        if (isPartner()) {
            return $next($request);
       }

       return redirect('/')->with('error','Вы не зарегестрированы как партнер. Пройдите, регистрацию для доступа в личный кабинет партнера.');
    }
}
