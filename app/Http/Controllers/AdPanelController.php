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
            'title' => 'Admin Register'
        ]);
    }

    public function adPanel(){
        return view('adPanel.index', [
            'title' => 'Admin Panel'
        ]);
    }

    public function adUsers(Request $request){
        $auth=Firebase::auth();
        if($request['search']){
            return view('adPanel.sidemenu.users',[
                'title' => 'Admin Panel | Users',
                'users' => $auth->listUsers(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            return view('adPanel.sidemenu.users',[
                'title' => 'Admin Panel | Users',
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
                'snapshots' => $db->getReference('transaksi/validated')->getValue(),
                'tahun' => $request['tahun']
            ]);
        } else{
            return view('adPanel.sidemenu.laporan.index', [
                'title' => 'Admin Panel | Laporan',
                'snapshots' => $db->getReference('transaksi/validated')->getValue(),
                'tahun' => date('Y', strtotime(Carbon::now()))
            ]);
        }
    }

    public function dataTest(){
        $db=Firebase::database();

        $auth=Firebase::Auth();

        dump(Str::title('aku adalah anak gembala selalu riang serta gembira'));

        if(Str::contains(Str::title('teknik komputer'), $db->getReference('faculties/Teknik/jurusan')->getValue())){
            dump('Sudah Ada');
        } else{
            dump('Belum Ada');
        }

        dump($db->getReference('data_test')->getSnapshot()->numChildren());
        // dump($auth->getUser(Session::get('firebaseUserId'))->customClaims['role']);
        dump(array_keys($db->getReference('faculties')->getValue()));
        dump(array_keys($db->getReference('users')->getValue()));
        dump($db->getReference('faculties/Teknik/jurusan')->getValue());
        dump(Str::replace(' ', '_', $db->getReference('faculties/Teknik/jurusan')->getValue()));
        dump(Str::contains('Teknik', Str::replace(' ', '_', $db->getReference('faculties/Teknik/jurusan')->getValue())));
        foreach($auth->listUsers() as $user){
            dump($user->customClaims['role']);
        }
    }
}
