<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;

class LoginController extends Controller
{
    protected $auth;
    public function index(){
        return view('login.index', [
            'title' => "Login"
        ]);
    }

    protected function login(Request $request){
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try{
            $firebaseAuth = Firebase::Auth();
            $signInResult = $firebaseAuth->signInWithEmailAndPassword($request['email'], $request['password']);
            $inputEmail = Str::replace('.', '', $request['email']);
            Session::put('firebaseUserId', $signInResult->firebaseUserId());
            Session::put('email', $inputEmail);
            Session::put('user', true);
            Session::save();
            
            return redirect('/dashboard');
        } catch(\Exception $e){
            Session::flash('error', 'Login failed. Please try again.');
        }
    }

    protected function adLog(Request $request){
        $validator = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try{
            $firebaseAuth = Firebase::Auth();
            $signInResult = $firebaseAuth->signInWithEmailAndPassword($request['email'], $request['password']);
            $inputEmail = Str::replace('.', '', $request['email']);
            Session::put('firebaseUserId', $signInResult->firebaseUserId());
            Session::put('email', $inputEmail);
            Session::put('user', true);
            Session::save();
            
            return redirect('/adPanel');
        } catch(\Exception $e){
            Session::flash('error', 'Login failed. Please try again.');
        }
    }

    protected function logout(){
        $firebaseAuth = Firebase::Auth();
        if(Session::has('user')){
            $firebaseAuth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('user');
            
            Session::save();
            Session::flash('logoutSuccess', "Logout berhasil!");
            return redirect('/login');
        } else{
            Session::flash('belumLogin', 'User Belum Login');
            return redirect('/login');
        }
    }
}
