<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserQuery;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class AdPanelController extends Controller
{
    public function adReg(){
        return view('adReg.index', [
            'title' => 'Pendaftaran Admin'
        ]);
    }

    public function adPanel(){
        $video = Firebase::database()->getReference('videos')->getValue();
        return view('adPanel.index', [
            'title' => 'Admin Panel',
            'header' => "Selamat Datang di Admin Panel",
            'videos' => $video,
        ]);
    }

    public function adUsers(Request $request){
        $auth=Firebase::auth();
        if($request['search']){
            return view('adPanel.sidemenu.users',[
                'title' => 'Admin Panel | Pengguna',
                'header' => "Pengguna",
                'users' => $auth->listUsers(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            return view('adPanel.sidemenu.users',[
                'title' => 'Admin Panel | Pengguna',
                'header' => "Pengguna",
                'users' => $auth->listUsers(),
                'search' => false
            ]);
        }
    }

    public function delUser(Request $request){
        $auth = Firebase::auth();
        $db = Firebase::database();
        $email = Str::replace('.', '', $request['email']);
        try{
            $auth->deleteUser($request['uid']);
            $db->getReference('users/' . $email)->remove();
    
            return redirect('/adPanel/users')->with('success', 'User Berhasil Dihapus!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'User Gagal Dihapus. Silakan Coba Lagi.');
        }
    }

    public function laporan(Request $request){
        $db = Firebase::database();
        if($request['tahun']){
            return view('adPanel.sidemenu.laporan.index', [
                'title' => 'Admin Panel | Laporan',
                'header' => "Laporan Pendapatan Bruto EdukaS1",
                'snapshots' => $db->getReference('transaksi/validated')->getValue(),
                'year' => $request['tahun'],
                'month' => $request['bulan']
            ]);
        } else{
            return view('adPanel.sidemenu.laporan.index', [
                'title' => 'Admin Panel | Laporan',
                'header' => "Laporan Pendapatan Bruto EdukaS1",
                'snapshots' => $db->getReference('transaksi/validated')->getValue(),
                'year' => date('Y', strtotime(Carbon::now())),
                'month' => date('m', strtotime(Carbon::now()))
            ]);
        }
    }
}
