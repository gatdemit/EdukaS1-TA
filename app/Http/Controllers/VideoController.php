<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db = Firebase::database();
        $jur = Firebase::database()->getReference('faculties')->getValue();
        return view('adPanel.sidemenu.video.index', [
            'title' => 'Admin Panel | Video',
            'header' => "Video",
            'jurusan' => $db->getReference('videos/' . array_keys($db->getReference('videos')->getValue())[0])->getValue(),
            'faks' => $jur,
            'choice' => array_keys($db->getReference('videos')->getValue())[0],
            'search' => false
        ]);
    }

    public function indexDos()
    {
        $db = Firebase::database();
        return view('dosPanel.sidemenu.video.index', [
            'title' => 'Dosen Panel | Video',
            'header' => "Video",
            'jurusan' => $db->getReference('dosen/' . Session::get('email') . '/vids')->getValue(),
            'search' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Firebase::database()->getReference('faculties')->getValue();
        return view('dosPanel.sidemenu.video.create', [
            'title' => 'Dosen Panel | Video',
            'header' => "Upload Video",
            'faks' => $jurusan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request['search'] || $request['choice']){
            $db = Firebase::database();
            $jur = Firebase::database()->getReference('faculties')->getValue();
            return view('adPanel.sidemenu.video.index', [
                'title' => 'Admin Panel | Video',
                'header' => "Video",
                'jurusan' => $db->getReference('videos/' . Str::replace(' ', '_', $request['choice']))->getValue(),
                'faks' => $jur,
                'choice' => Str::replace(' ', '_',$request['choice']),
                'search' => $request['search'] == null ? false : true,
                'query' => $request['search'] == null ? $request['choice'] : $request['search'],
            ]);
        } 
    }

    public function storeDos(Request $request)
    {
        if($request['search']){
            $db = Firebase::database();
            return view('dosPanel.sidemenu.video.index', [
                'title' => 'Dosen Panel | Video',
                'header' => "Video",
                'jurusan' => $db->getReference('dosen/' . Session::get('email') . '/vids')->getValue(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            $db = Firebase::database();
            $inVid = Str::replace('video/','', $request->file('video')->store('video'));
            $storVid = Str::replace('.','_',$inVid);
            $storeJur = Str::replace(' ', '_', $request['jurusan']);
            $size = 5;
            $request->validate([
                'video' => [
                    'required',
                    File::default()->max($size . 'mb')
                ]
            ], [
                'video.max' => 'The video field must not be greater than ' . $size . ' MB.'
            ]);

            $updates = [
                'Judul_Video' => $request['judul'],
                'Fakultas' => $request['fakultas'],
                'Jurusan' => $request['jurusan'],
                'Harga' => $request['harga'],
                'Deskripsi' => $request['deskripsi'],
                'Link' => $request['video']->store('video'),
                'Video' => $storVid,
                'Dosen' => $db->getReference('dosen/' . Session::get('email'))->getValue()['nama'],
                'Email_Dosen' => Session::get('email'),
                'Active' => true
            ];

            $updatesDos = [
                'Judul_Video' => $request['judul'],
                'Fakultas' => $request['fakultas'],
                'Jurusan' => $request['jurusan'],
                'Harga' => $request['harga'],
                'Video' => $storVid
            ];
    
            try{
                $db->getReference('videos/' . $storeJur . '/'. $storVid)->update($updates);
                $db->getReference('dosen/' . Session::get('email') . '/vids/'. Str::replace(' ', '_', $request['jurusan']) . '/' . $storVid)->update($updatesDos);
            } catch(\Exception $e){
                return redirect()->back()->with('error', 'Upload Video Gagal. Silakan Coba Lagi.');
            }
    
            return redirect('/dosPanel/video')->with('success', 'Upload Video Berhasil!');
        }
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
    public function edit(Request $request)
    {
        return view('adPanel.sidemenu.video.edit', [
            'title' => 'Admin Panel | Video',
            'header' => "Edit Data Video",
            'jurusan' => $request['jurusan']
        ]);
    }
    public function editDos(Request $request)
    {
        return view('dosPanel.sidemenu.video.edit', [
            'title' => 'Dosen Panel | Video',
            'header' => "Edit Data Video",
            'jurusan' => $request['jurusan']
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

        $updatesDos = [
            'Judul_Video' => $request['judul'],
            'Harga' => $request['harga']
        ];

        try{
            $db->getReference('videos/' . $request['jurusan'] . '/' . $request['video'])->update($updates);
            $db->getReference('dosen/' . $request['email'] . '/vids/' . $request['jurusan'] . '/' . $request['video'])->update($updatesDos);
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Pembaruan Video Gagal. Silakan Coba Lagi');
        }

        return redirect('/adPanel/video')->with('success', 'Pembaruan Video Berhasil!');
    }

    public function updateDos(Request $request, string $id)
    {
        $db = Firebase::database();

        $updates = [
            'Judul_Video' => $request['judul'],
            'Harga' => $request['harga'],
            'Deskripsi' => $request['deskripsi'],
        ];

        $updatesDos = [
            'Judul_Video' => $request['judul'],
            'Harga' => $request['harga']
        ];

        try{
            $db->getReference('videos/' . $request['jurusan'] . '/' . $request['video'])->update($updates);
            $db->getReference('dosen/' . Session::get('email') . '/vids/' . $request['jurusan'] . '/' . $request['video'])->update($updatesDos);
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Pembaruan Video Gagal. Silakan Coba Lagi');
        }

        return redirect('/dosPanel/video')->with('success', 'Pembaruan Video Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $db=Firebase::database();

        try{
            $db->getReference('videos/' . $request['jurusan'] . '/' . $request['video'])->update(['Active' => false]);
            return redirect()->back()->with('success', 'Video Berhasil Dinonaktifkan!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Video Gagal Dinonaktifkan. Silakan Coba Lagi.');
        }
    }

    public function reactivate(Request $request)
    {
        $db=Firebase::database();

        try{
            $db->getReference('videos/' . $request['jurusan'] . '/' . $request['video'])->update(['Active' => true]);
            return redirect()->back()->with('success', 'Video Berhasil Diaktifkan!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Video Gagal Diaktifkan. Silakan Coba Lagi.');
        }
    }
}
