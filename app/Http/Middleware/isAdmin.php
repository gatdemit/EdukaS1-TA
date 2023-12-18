<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Session;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Session::has('user') && Firebase::Auth()->getUser(Session::get('firebaseUserId'))->customClaims['role']!='admin'){
            return redirect('/dashboard');
        } else if(!Session::has('user')){
            return redirect('/login');
        }
        return $next($request);
    }
}
