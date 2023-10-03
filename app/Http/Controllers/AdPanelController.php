<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserQuery;

class AdPanelController extends Controller
{
    public function adReg(){
        return view('adReg.index', [
            'title' => 'Admin Register'
        ]);
    }

    public function adLog(){
        return view('adLog.index', [
            'title' => 'Admin Login'
        ]);
    }

    public function adPanel(){
        return view('adPanel.index', [
            'title' => 'Admin Panel'
        ]);
    }

    public function adUsers(){
        $auth=Firebase::auth();
        return view('adPanel.sidemenu.users',[
            'title' => 'Admin Panel | Users',
            'users' => $auth->listUsers()
        ]);
    }

    public function delUser(Request $request){
        $auth = Firebase::auth();
        $db = Firebase::database();
        $email = Str::replace('.com', 'com', $request['email']);
        $auth->deleteUser($request['uid']);
        $db->getReference('users/' . $email)->remove();

        return redirect('/adPanel/users');
    }

    public function userList(){
        $auth = Firebase::auth();

        $users = $auth->listUsers();

        foreach($users as $user)
        {
            dump($user);
            dump($user->displayName);
            dump($user->uid);
        }
    }

    public function vidList(){
        $db = Firebase::database();

        dump($db->getReference('videos')->getSnapshot()->getValue('Jurusan'));
    }

    public function dataTest(){
        $db = Firebase::database();

        $fak = [
            'ft' => 'teknik',
            'fpp'=> 'pertanian dan peternakan',
            'fisip' => 'ilmu sosial dan ilmu politik',
            'fh' => 'hukum',
            'fib' => 'ilmu budaya',
            'feb' => 'ekonomika dan bisnis',
            'fk' => 'kedokteran',
            'fpsi' => 'psikologi',
            'fsm' => 'sains dan matematika',
            'fkm' => 'kesehatan masyarakat',
            'fpik' => 'perikanan dan ilmu kelautan'
        ];

        $jurusan = [
            'Teknik' => ['Teknik Sipil', 'Arsitektur', 'Teknik Kimia', 'Teknik Perencanaan Wilayah dan Kota', 'Teknik Mesin', 'Teknik Elektro', 'Teknik Perkapalan', 'Teknik Industri', 'Teknik Lingkungan', 'Teknik Geologi', 'Teknik Geodesi', 'Teknik Komputer'],
            'Kedokteran' => ['Kedokteran', 'Kedokteran Gigi', 'Farmasi'],
            'Kesehatan Masyarakat' => ['Kesehatan Masyarakat'],
            'Sains dan Matematika' => ['Matematika', 'Biologi', 'Fisika', 'Kimia', 'Statistika', 'Informatika', 'Bioteknologi'],
            'Peternakan dan Pertanian' => ['Peternakan', 'Teknologi Pangan', 'Agroekoteknologi', 'Agribisnis'],
            'Perikanan dan Ilmu Kelautan' => ['Sumber Daya Perairan', 'Akuakultur', 'Perikanan Tangkap', 'Teknologi Hasil Perikanan', 'Ilmu Kelautan', 'Oseanografi'],
            'Hukum' => ['Hukum'],
            'Ekonomika dan Bisnis' => ['Akuntansi', 'Manajemen', 'Bisnis Digital', 'Ilmu Ekonomi', 'Ekonomi Islam'],
            'Ilmu Sosial dan Ilmu Politik' => ['Administrasi Bisnis', 'Administrasi Publik', 'Hubungan Internasional', 'Ilmu Komunikasi', 'Ilmu Pemerintahan'],
            'Ilmu Budaya' => ['Sejarah', 'Sastra Indonesia', 'Bahasa dan Kebudayaan Jepang', 'Sastra Inggris', 'Antropologi Sosial', 'Ilmu Perpustakaan'],
            'Psikologi' => ['Psikologi']
        ];

        // $db->getReference('data_test')->set($fak);

        // dump(array_keys($jurusan));
        // dump(key($jurusan));
        // dump($jurusan['Teknik'][0]);
        // dump($jurusan['Teknik']);
        // dump($jurusan);
        // dump(count($jurusan));

        // dump($db->getReference('users/yahyariz14@gmailcom')->getChildKeys());
        // dump($db->getReference('users')->getSnapshot()->hasChildren());
        foreach($db->getReference('users')->getSnapshot() as $snapshot){
            dump($snapshot->getKey());
            // if(array_key_exists('vids', $snapshot)){
            //     dump($snapshot['vids']);
            // } else{
            //     dump('nop');
            // }
        }

        foreach($db->getReference('users')->getValue() as $snapshot){
            if(array_key_exists('vids', $snapshot)){
                if(array_key_exists('v5jmdOliHM2fsuev0G7XFvix0NlhgMmrz3Te9HqU_mp4', $snapshot['vids'])){
                    dump(true);
                } else{
                    dump('lanjut');
                }
            } else{
                dump('nop');
            }
        }
    }
}
