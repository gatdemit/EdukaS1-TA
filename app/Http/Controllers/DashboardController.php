<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.index', [
            'title' => "Dashboard"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.menu.fill', [
            'title' => "Dashboard"
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $db = Firebase::database();

        $updates = [
            'name' => $request['name'],
            'gender' => $request['gender'],
            'tanggal_lahir' => $request['tanggal_lahir'],
            'nomor_telp' => $request['phone-number'],
            'alamat' => $request['address'],
            'profile' => 'fill'
        ];

        try{
            if($request['image']==null){
                $db->getReference('users/'.$request['email'])->update($updates);
            } else{
                $updates += ['profpic' => $request['image']->store('profile_picture')];
                $db->getReference('users/'.$request['email'])->update($updates);
            }
        } catch(\Exception $e){
            Session::flash('error', 'Pengisian Data Gagal. Silakan Coba Lagi.');
        }
        return redirect('/dashboard')->with('success', 'Profile Dibuat dengan Sukses! Silakan verifikasi email Anda untuk membeli video!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        return view('dashboard.menu.edit', [
            'title' => "Dashboard"
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $db = Firebase::database();

        $updates = [
            'name' => $request['name'],
            'nomor_telp' => $request['phone-number'],
            'alamat' => $request['address'],
        ];
        try{
            if($request['image']==null){
                $db->getReference('users/'.$request['email'])->update($updates);
            } else{
                Storage::delete($db->getReference('users/'.Session::get('email'))->getValue()['profpic']);
                $updates += ["profpic" => $request['image']->store('profile_picture')];
                $db->getReference('users/'.$request['email'])->update($updates);
            }
        } catch(\Exception $e){
            Session::flash('error', 'Pembaruan Gagal. Silakan Coba Lagi.');
        }

        return redirect('/dashboard')->with('success', 'Profil Berhasil Diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function manageAccount(){
        return view('dashboard.menu.akun', [
            'title' => 'Dashboard'
        ]);
    }

    public function passwordChange(Request $request){
        $auth = Firebase::Auth();

        $validator = $request->validate([
            'oldpassword' => 'required|string|min:6',
            'password' => 'required|confirmed|string|min:6',
        ]);

        $email = Str::replace('com', '.com', $request['email']);

        try{
            if($auth->signInWithEmailAndPassword($email, $validator['oldpassword'])){
                $auth->changeUserPassword(Session::get('firebaseUserId'), $validator['password']);
                return redirect('/dashboard')->with('success', 'Password Berhasil Diubah!');
            }
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Kata sandi lama salah. Silakan Coba Lagi');
        }
    }
    
    public function destroy(Request $request)
    {
        $auth = Firebase::Auth();
        $db = Firebase::database();

        try{
            $db->getReference('users/' . $request['email'])->remove();
            Session::forget('user');
                
            Session::save();
            $auth->deleteUser(Session::get('firebaseUserId'));
    
            return redirect('/login')->with('success', 'Penghapusan Akun Berhasil!');
        } catch(\Exception $e){
            return redirect()->back()->with('delError', 'Penghapusan Akun Gagal. Silakan Coba Lagi.');
        }
    }

    public function kuis(){
        return view('dashboard.menu.kuis',[
            'title' => 'Dashboard | Kuis'
        ]);
    }
}
