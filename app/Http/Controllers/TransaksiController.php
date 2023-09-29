<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{

    public function transaksi(){
        $db = Firebase::database();
        return view('adPanel.sidemenu.transaksi.index', [
            'title' => 'Admin Panel | Transaksi',
            'snapshots' => $db->getReference('transaksi')->getValue(),
            'tagihan' => 0
        ]);
    }

    public function keranjang(Request $request){
        $db = Firebase::database();
       
        $email = Str::replace('com', '.com', $request['email']);

        $updates = [
            $request['video'] => [
                "Judul Video" => $request['judul'],
                "Video" => $request['video'],
                "Harga" => $request['harga'],
                "Fakultas" => $request['fakultas'],
                "Jurusan" => $request['jurusan']
            ],
        ];

        $db->getReference('transaksi/' . $request['email'])->update(["email" => $email]);
        $db->getReference('transaksi/' . $request['email'] . '/Keranjang')->update($updates);

        return redirect()->back();
    }

    public function validasi(Request $request){
        $db = Firebase::database();

        $updates = [];

        $videos = $db->getReference('transaksi/' . $request['email'] . '/Keranjang')->getValue();

        foreach($videos as $video){
            $updates += [
                $video['Video'] => [
                    'Video' => $video['Video'],
                    'Fakultas' => $video['Fakultas'],
                    'Jurusan' => $video['Jurusan']
                ]
            ];
        }

        $db->getReference('users/' . $request['email'] . '/vids')->update($updates);

        $db->getReference('transaksi/' . $request['email'])->remove();

        return redirect()->back();
    }
}
