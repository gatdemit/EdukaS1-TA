<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db = Firebase::database();
        return view('adPanel.sidemenu.video.index', [
            'title' => 'Admin Panel | Video',
            'videos' => $db->getReference('videos')->getValue()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
        return view('adPanel.sidemenu.video.create', [
            'title' => 'Admin Panel | Video',
            'faks' => $jurusan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $db = Firebase::database();

        $inVid = Str::replace('video/','', $request->file('video')->store('video'));

        $storVid = Str::replace('.','_',$inVid);

        $updates = [
            'Judul_Video' => $request['judul'],
            'Fakultas' => $request['fakultas'],
            'Jurusan' => $request['jurusan'],
            'Harga' => $request['harga'],
            'Deskripsi' => $request['deskripsi'],
            'Link' => $request['video']->store('video'),
            'Video' => $storVid
        ];

        try{
            $db->getReference('videos/'. $storVid)->update($updates);
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Upload Video Gagal. Silakan Coba Lagi.');
        }

        return redirect('/adPanel/video')->with('success', 'Upload Video Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('adPanel.sidemenu.video.show', [
            'title' => 'Admin Panel | Video'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('adPanel.sidemenu.video.edit', [
            'title' => 'Admin Panel | Video'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $db = Firebase::database();

        $updates = [
            'Judul_Video' => $request['judul'],
            'Harga' => $request['harga'],
            'Deskripsi' => $request['deskripsi'],
        ];

        try{
            $db->getReference('videos/' . $request['video'])->update($updates);
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Pembaruan Video Gagal. Silakan Coba Lagi');
        }

        return redirect('/adPanel/video')->with('success', 'Pembaruan Video Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $db=Firebase::database();

        try{
            foreach($db->getReference('users')->getValue() as $snapshot){
                if(array_key_exists('vids', $snapshot)){
                    if(array_key_exists($request['video'], $snapshot['vids'])){
                        $email = Str::replace('.com', 'com', $snapshot['email']);
                        $db->getReference('users/' . $email . '/vids/' . $request['video'])->remove();
                    } 
                }
            }
    
            $db->getReference('videos/' . $request['video'])->remove();
            return redirect()->back()->with('success', 'Video Berhasil Dihapus!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Video Gagal Dihapus. Silakan Coba Lagi.');
        }
    }
}
