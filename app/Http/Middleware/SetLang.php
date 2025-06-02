<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if($request->HasHeader('Accept-Language')) {
            App::setLocale($request->header('Accept-Language'));
        }
//        app()->setLocale($request->segment(2));
//        URL::defaults(['locale' => $request->segment(2)]);
        return $next($request);
    }
}
