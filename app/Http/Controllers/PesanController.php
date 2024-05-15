<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserQuery;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class PesanController extends Controller
{
    public function index(){
        return view('dosPanel.sidemenu.pesan.index', [
            'title' => 'Dosen Panel | Pesan',
            'header' => 'Pesan',
        ]);
    }

    public function indexUser(){
        return view('dashboard.menu.pesan', [
            'title' => 'Dashboard',
        ]);
    }

    public function pesan(Request $request){
        $db = Firebase::database();

        $pesan = 'Salam sejahtera, Profesor ' . $db->getReference('dosen/' . $request['dosen'])->getValue()['nama'] . '! Saya ingin berdiskusi dengan Anda.';

        try{
            if($db->getReference('message/sent/' . Session::get('email') . '/' . $request['dosen'] . '/message')->getSnapshot()->exists()){
                $db->getReference('message/sent/' . Session::get('email') . '/' . $request['dosen'] . '/message')->update([
                    'm' . count($db->getReference('message/sent/' . Session::get('email') . '/' . $request['dosen'] . '/message')->getValue()) => [
                        'message' => $pesan,
                        'timestamp' => Carbon::now()->toDateTimeString()
                    ],
                ]);
            } else{
                $db->getReference('message/sent/' . Session::get('email') . '/' . $request['dosen'] . '/message')->update([
                    'm1' => [
                        'message' => $pesan,
                        'timestamp' => Carbon::now()->toDateTimeString()
                    ],
                ]);
        
                $db->getReference('message/sent/' . Session::get('email') . '/' . $request['dosen'])->update([
                    'to' => $request['dosen']
                ]);
            }
    
            if($db->getReference('message/received/' . $request['dosen'] . '/' . Session::get('email') . '/message')->getSnapshot()->exists()){
                $db->getReference('message/received/' . $request['dosen'] . '/' . Session::get('email') . '/message')->update([
                    'm' . count($db->getReference('message/received/' . $request['dosen'] . '/' . Session::get('email') . '/message')->getValue()) => [
                        'message' => $pesan,
                        'timestamp' => Carbon::now()->toDateTimeString()
                    ],
                ]);
            } else{
                $db->getReference('message/received/' . $request['dosen'] . '/' . Session::get('email') . '/message')->update([
                    'm1' => [
                        'message' => $pesan,
                        'timestamp' => Carbon::now()->toDateTimeString()
                    ],
                ]);
        
                $db->getReference('message/received/' . $request['dosen'] . '/' . Session::get('email'))->update([
                    'sender' => Session::get('email')
                ]);
            }
            return redirect('/dashboard/pesan')->with('success', 'pesan terkirim!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'pesan tidak terkirim');
        }
    }
}
