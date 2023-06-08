<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;

class appcleint
{
    use GeneralTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $appusers = null;
        try {
            $appusers = \Tymon\JWTAuth\Facades\JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('E401','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('E401','EXPIRED_TOKEN');
            } else {
                return $this -> returnError('E401','TOKEN_NOTFOUND');
            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this -> returnError('E401','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this -> returnError('E401','EXPIRED_TOKEN');
            } else {
                return $this -> returnError('E401','TOKEN_NOTFOUND');
            }
        }

        if (!$appusers)
            $this -> returnError('','Unauthenticated');



        return $next($request);
    }
}
