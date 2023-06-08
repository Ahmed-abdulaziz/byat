<?php

namespace App\Http\Middleware;

use Closure;

class CheackLangages
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
        app()->setLocale('ar');
        if ($request->header("lang") && $request->header('lang') =='fr'){
              app()->setLocale('fr');
        }elseif ($request->header("lang") && $request->header('lang') =='en'){
              app()->setLocale('en');
        }
          
        return $next($request);
    }
}
