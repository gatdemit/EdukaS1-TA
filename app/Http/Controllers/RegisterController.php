<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    private $firebaseAuth;
    private $database;

    public function index(){
        return view('register.index', [
            'title' => 'Pendaftaran',
        ]);
    }

    public function __construct(){
        $this->firebaseAuth = Firebase::auth();
        $this->database = Firebase::database();
    }

    protected function register(Request $request){
        $validator = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|string|min:6',
        ]);


        $email = $request->input('email');
        $password = $request->input('password');
        $inputEmail = Str::replace('.', '', $email);
        $ref_tablename = "users/".$inputEmail;
        $postData = [
            'username' => $request->input('username'),
            'profile' => 'empty',
            'profpic' => 'profile_picture/default.jpg',
            'email' => $email
        ];

        try {
            $createdUser = $this->firebaseAuth->createUserWithEmailAndPassword($email, $password);

            $customClaims = [
                'role' => 'user'
            ];
            $this->firebaseAuth->setCustomUserClaims($createdUser->uid, $customClaims);
            $this->firebaseAuth->updateUser($createdUser->uid, ['displayName' => $request['username']]);
            $this->firebaseAuth->sendEmailVerificationLink($email);

            $this->database->getReference($ref_tablename)->set($postData);
        } catch(\Exception $e){
            Session::flash('error', 'Registration failed.  Please try again');
            return redirect('/register');
        }
        $signInResult = $this->firebaseAuth->signInWithEmailAndPassword($email, $password);
        Session::put('firebaseUserId', $signInResult->firebaseUserId());
        Session::put('email', $inputEmail);
        Session::put('user', true);
        Session::save();
        
        Session::flash('success', 'Registration Succesful!');
        return redirect('/dashboard/create');
    }

    protected function adReg(Request $request){
        $validator = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|string|min:6'
        ]);


        $email = $request->input('email');
        $password = $request->input('password');
        $inputEmail = Str::replace('.', '', $email);
        $ref_tablename = "admin/".$inputEmail;
        $postData = [
            'username' => $request->input('username')
        ];

        try {
            $createdUser = $this->firebaseAuth->createUserWithEmailAndPassword($email, $password)   ;

            $customClaims = [
                'role' => 'admin'
            ];
            $this->firebaseAuth->setCustomUserClaims($createdUser->uid, $customClaims);

            $this->database->getReference($ref_tablename)->set($postData);
        } catch(\Exception $e){
            Session::flash('error', 'Registration failed.  Please try again');
            return redirect('/register');
        }
        
        return redirect('/adPanel/users')->with('success', 'Pembuatan akun admin berhasil!');
    }

    protected function dosReg(Request $request){
        $validator = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|confirmed|string|min:6'
        ]);


        $email = $request->input('email');
        $password = $request->input('password');
        $inputEmail = Str::replace('.', '', $email);
        $ref_tablename = "dosen/".$inputEmail;
        $postData = [
            'username' => $request->input('username'),
            'nama' => $request['nama'],
            'email' => $email
        ];

        try {
            $createdUser = $this->firebaseAuth->createUserWithEmailAndPassword($email, $password)   ;

            $customClaims = [
                'role' => 'dosen'
            ];
            $this->firebaseAuth->setCustomUserClaims($createdUser->uid, $customClaims);

            $this->database->getReference($ref_tablename)->set($postData);
        } catch(\Exception $e){
            Session::flash('error', 'Pendaftaran gagal. Silakan coba lagi');
            return redirect('/register');
        }
        
        return redirect('/adPanel/users')->with('success', 'Pembuatan akun dosen berhasil!');
    }
}
