<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Session;

class isProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(request()->segment(count(request()->segments())) != 'create' && Firebase::database()->getReference('users/' . Session::get('email') . '/profile')->getValue() != 'fill'){
            if(!Session::has('user')){
                return redirect('/login');
            } else{
                if(Firebase::Auth()->getUser(Session::get('firebaseUserId'))->customClaims['role']=='admin'){
                    return redirect('/adPanel');
                } else if(Firebase::Auth()->getUser(Session::get('firebaseUserId'))->customClaims['role']=='dosen'){
                    return redirect('/dosPanel');
                } else{
                    return redirect('/dashboard/create');
                }
            }
        }
        return $next($request);
    }
}
