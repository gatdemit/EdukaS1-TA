<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class TransaksiController extends Controller
{

    public function transaksi(Request $request){
        $db = Firebase::database();
        if($request['search']){
            return view('adPanel.sidemenu.transaksi.index', [
                'title' => 'Admin Panel | Transaksi',
                'header' => "Transaksi",
                'snapshots' => $db->getReference('transaksi/unvalidated')->getValue(),
                'validateds' => $db->getReference('transaksi/validated')->getValue(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            return view('adPanel.sidemenu.transaksi.index', [
                'title' => 'Admin Panel | Transaksi',
                'header' => "Transaksi",
                'snapshots' => $db->getReference('transaksi/unvalidated')->getValue(),
                'validateds' => $db->getReference('transaksi/validated')->getValue(),
                'search' => false
            ]);
        }
    }

    public function keranjangku(){
        return view('keranjang', [
            'title' => 'Keranjang'
        ]);
    }
    
    public function keranjang(Request $request){
        $db = Firebase::database();
        $auth = Firebase::Auth();
       
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

        try{
            if($auth->getUser(Session::get('firebaseUserId'))->emailVerified){
                $db->getReference('transaksi/unvalidated/' . $request['email'])->update(["email" => $email, "checkout" => false]);
                $db->getReference('transaksi/unvalidated/' . $request['email'] . '/Keranjang')->update($updates);
        
                return redirect()->back()->with('success', 'Video Berhasil Ditambahkan ke Keranjang!');
            } else{
                return redirect('/dashboard')->with('error', 'Anda belum memverifikasi email. Silakan verifikasi email untuk membeli video!');
            }
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Video Gagal Ditambahkan ke Keranjang. Silakan Coba Lagi.');
        }
    }

    public function checkout(Request $request){
        $db=Firebase::database();

        try{
            $db->getReference('transaksi/unvalidated/' . $request['email'])->update(['checkout' => true]);
    
            return redirect('/dashboard')->with('success', 'Checkout Berhasil!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Checkout Gagal. Silakan Coba Lagi.');
        }
    }

    public function remove(Request $request){
        $db=Firebase::database();

        try{
            if($db->getReference('transaksi/unvalidated/' . $request['email'] . "/Keranjang/")->getSnapshot()->numChildren() > 1){
                $db->getReference('transaksi/unvalidated/' . $request['email'] . "/Keranjang/" . $request['video'])->remove();
            } else{
                $db->getReference('transaksi/unvalidated/' . $request['email'])->remove();
            }
    
            return redirect()->back()->with('success', 'Video Berhasil Dihapus dari Keranjang!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Video Gagal Dihapus dari Keranjang. Silakan Coba Lagi.');
        }
    }
    
    public function removeAll(Request $request){
        $db=Firebase::database();

        try{
            $db->getReference('transaksi/unvalidated/' . $request['email'])->remove();
    
            return redirect()->back()->with('success', 'Keranjang Berhasil Dikosongkan!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Keranjang Gagal Dikosongkan. Silakan Coba Lagi.');
        }
    }


    public function validasi(Request $request){
        $db = Firebase::database();

        $date = Carbon::now()->toDateString();
        $time = Carbon::now()->toTimeString();

        $updates = [];

        $email = Str::replace('com', '.com', $request['email']);

        $videos = $db->getReference('transaksi/unvalidated/' . $request['email'] . '/Keranjang')->getValue();
        try{
            foreach($videos as $video){
                if(array_key_exists(Str::replace(' ', '_', $video['Jurusan']), $updates)){
                    $updates[Str::replace(' ', '_', $video['Jurusan'])] += [
                        $video['Video'] => [
                            'Video' => $video['Video'],
                            'Fakultas' => $video['Fakultas'],
                            'Jurusan' => $video['Jurusan']
                        ],
                    ];
                } else{
                    $updates += [
                        Str::replace(' ', '_', $video['Jurusan']) => [
                            $video['Video'] => [
                                'Video' => $video['Video'],
                                'Fakultas' => $video['Fakultas'],
                                'Jurusan' => $video['Jurusan']
                            ],
                        ],
                    ];
                }
                
                if($db->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video']. '/buy_count')->getSnapshot()->exists()){
                    $buy_count = $db->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'])->getValue()['buy_count'];
                    $db->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'])->update(['buy_count' => $buy_count+1 ]);
                } else{
                    $db->getReference('videos/' . Str::replace(' ', '_', $video['Jurusan']) . '/' . $video['Video'])->update(['buy_count' => 1]);
                }
            }
            foreach(array_keys($updates) as $keys){
                $db->getReference('users/' . $request['email'] . '/vids/' . $keys)->update($updates[$keys]);
            }
            $db->getReference('transaksi/validated/' . $request['email'] . '_' . $date . '_' . $time)->update(['validation_date' => $date, 'total' => $request['total'], 'email' => $email ]);
            $db->getReference('transaksi/unvalidated/' . $request['email'])->remove();
    
            return redirect()->back()->with('success', 'Transaksi Berhasil Divalidasi!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Transaksi Gagal Divalidasi. Silakan Coba Lagi.');
        }
    }
}
