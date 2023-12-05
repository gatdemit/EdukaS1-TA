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
        return view('adPanel.sidemenu.video.index', [
            'title' => 'Admin Panel | Video',
            'jurusan' => $db->getReference('videos')->getValue(),
            'search' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusan = Firebase::database()->getReference('faculties')->getValue();
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
        if($request['search']){
            $db = Firebase::database();
            return view('adPanel.sidemenu.video.index', [
                'title' => 'Admin Panel | Video',
                'jurusan' => $db->getReference('videos')->getValue(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            $db = Firebase::database();
    
            $inVid = Str::replace('video/','', $request->file('video')->store('video'));
    
            $storVid = Str::replace('.','_',$inVid);

            $storeJur = Str::replace(' ', '_', $request['jurusan']);

            $size = 50;
    
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
                'Active' => true
            ];
    
            try{
                $db->getReference('videos/' . $storeJur . '/'. $storVid)->update($updates);
            } catch(\Exception $e){
                return redirect()->back()->with('error', 'Upload Video Gagal. Silakan Coba Lagi.');
            }
    
            return redirect('/adPanel/video')->with('success', 'Upload Video Berhasil!');
        }
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
    public function edit(Request $request)
    {
        return view('adPanel.sidemenu.video.edit', [
            'title' => 'Admin Panel | Video',
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

        try{
            $db->getReference('videos/' . $request['jurusan'] . '/' . $request['video'])->update($updates);
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
