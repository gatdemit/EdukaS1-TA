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
            
            return redirect('/dashboard')->with('success', 'Login Berhasil!');
        } catch(\Exception $e){
            return redirect()->back()->with('belumLogin', 'Login failed. Please try again.');
        }
    }

    protected function logout(){
        $firebaseAuth = Firebase::Auth();
        if(Session::has('user')){
            $firebaseAuth->revokeRefreshTokens(Session::get('firebaseUserId'));
            Session::forget('user');
            
            Session::save();
            Session::flash('success', "Logout berhasil!");
            return redirect('/login');
        } else{
            Session::flash('belumLogin', 'User Belum Login');
            return redirect('/login');
        }
    }

    public function forgotPass(){
        return view('login.forgotpass', [
            'title' => 'login'
        ]);
    }

    public function resetPass(Request $request){
        $auth = Firebase::Auth();

        try{
            $auth->sendPasswordResetLink($request['email']);
            return redirect('/login')->with('success', 'Reset Password Berhasil! Silakan Login dengan Password yang Baru!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Reset Password Gagal. Silakan Coba Lagi');
        }
    }
}
