<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;
use Kreait\Laravel\Firebase\Facades\Firebase;

class isGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Session::has('user')){
            return redirect('/login');
        } else if(Firebase::Auth()->getUser(Session::get('firebaseUserId'))->customClaims['role']=='admin'){
            return redirect('/adPanel');
        } else if(Firebase::Auth()->getUser(Session::get('firebaseUserId'))->customClaims['role']=='dosen'){
            return redirect('/dosPanel');
        }
        return $next($request);
    }
}
