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
        return view('adPanel.index', [
            'title' => 'Admin Panel',
            'header' => "Selamat Datang di Admin Panel",
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
        try{
            if($auth->getUser($request['uid'])->disabled){
                $auth->enableUser($request['uid']);
                return redirect('/adPanel/users')->with('success', 'Akun Berhasil Diaktifkan!');
            } else{
                $auth->disableUser($request['uid']);
                return redirect('/adPanel/users')->with('success', 'Akun Berhasil Dinonaktifkan!');
            }
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

    public function dataTest(){
        $auth = Firebase::Auth();
        $db = Firebase::database();
        $msg = 'm3';
        $email = 'yahyariz14@gmailcom';
        $ref = Firebase::database()->getReference('message/sent/dosen3@gmailcom/ananda@gmailcom/message')->getValue();

        dump(Carbon::now()->toDateTimeString());

        // $db->getReference('message/received/' . Session::get('email') . '/' . $email . '/message')->update([
        //     $msg => [
        //         'message' => 'child ke-3',
        //         'timestamp' => Carbon::now()
        //     ],
        // ]);
        
        // $db->getReference('message/received/' . Session::get('email') . '/' . $email)->update([
        //     'sender' => $email
        // ]);
        // $db->getReference('message/sent/' . $email . '/' . Session::get('email') . '/message')->update([
        //     $msg => [
        //         'message' => 'child ke-3',
        //         'timestamp' => Carbon::now()
        //     ],
        // ]);

        // $db->getReference('message/sent/' . $email . '/' . Session::get('email'))->update([
        //     'to' => Session::get('email')
        // ]);
    }
}
