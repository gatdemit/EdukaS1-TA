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
            'title' => "dashboard"
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.menu.fill', [
            'title' => "dashboard"
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
            'profpic' => $request['image']->store('profile_picture'),
            'profile' => 'fill'
        ];

        try{
            $db->getReference('users/'.$request['email'])->update($updates);
        } catch(\Exception $e){
            Session::flash('error', 'Data storage failed. Please try again.');
        }

        return redirect('/dashboard')->with('success', 'profile has been created!');

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
            'title' => "dashboard"
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
            'gender' => $request['gender'],
            'tanggal_lahir' => $request['tanggal_lahir'],
            'nomor_telp' => $request['phone-number'],
            'alamat' => $request['address'],
            'profpic' => $request['image']->store('profile_picture')
        ];
        Storage::delete($db->getReference('users/'.Session::get('email'))->getValue()['profpic']);
        try{
            $db->getReference('users/'.$request['email'])->update($updates);
        } catch(\Exception $e){
            Session::flash('error', 'Data storage failed. Please try again.');
        }

        return redirect('/dashboard')->with('success', 'profile has been created!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function kuis(){
        return view('dashboard.menu.kuis',[
            'title' => 'dashboard | quiz'
        ]);
    }
}
