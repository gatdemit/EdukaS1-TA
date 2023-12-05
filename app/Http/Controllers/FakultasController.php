<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserQuery;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class FakultasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db = Firebase::database();
        return view('adPanel.sidemenu.fakultas.index',[
            'title' => 'Admin Panel | Fakultas dan Jurusan',
            'search' => false,
            'fakultas' => $db->getReference('faculties')->getValue()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $db = Firebase::database();
        return view('adPanel.sidemenu.fakultas.create',[
            'title' => 'Admin Panel | Fakultas dan Jurusan',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request['search']){
            $db = Firebase::database();
            return view('adPanel.sidemenu.fakultas.index', [
                'title' => 'Admin Panel | Fakultas dan Jurusan',
                'videos' => $db->getReference('faculties')->getValue(),
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            $db = Firebase::database();
    
            $storFak = Str::title(Str::replace(' ', '_', $request['fakultas']));
            $jurusan = [];

            try{
                if($db->getReference('faculties/' . $storFak)->getSnapshot()->exists()){
                    return redirect()->back()->with('error', 'Fakultas sudah ada');
                } else{
                    for($i=0; $i<=$request['count']; $i++){
                        $jurusan += [
                            $i => Str::title($request['jurusan'. $i+1])
                        ];
                    }
    
                    $updates = [
                        $storFak => [
                            'Value' => Str::title($request['fakultas']),
                            'jurusan' => $jurusan
                        ]
                    ];
    
                    $db->getReference('faculties')->update($updates);
                }
            } catch(\Exception $e){
                return redirect()->back()->with('error', 'Penambahan Fakultas Gagal. Silakan Coba Lagi.');
            }
    
            return redirect('/adPanel/fakultas')->with('success', 'Penambahan Fakultas Berhasil!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $db = Firebase::database();
        return view('adPanel.sidemenu.fakultas.show', [
            'title' => 'Admin Panel | Fakultas dan Jurusan',
            'search' => false
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('adPanel.sidemenu.fakultas.edit',[
            'title' => 'Admin Panel | Fakultas dan Jurusan'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $db = Firebase::database();
    
        $jurusan = [];

        try{
            for($i=$request['childCount']; $i<=$request['count'] + $request['childCount']; $i++){
                if(Str::contains(Str::title($request['jurusan'. ($i+1)-$request['childCount']]), $db->getReference('faculties/Teknik/jurusan')->getValue())){
                    return redirect()->back()->with('error', 'Jurusan sudah ada');
                } else{
                    $jurusan += [
                        $i => Str::title($request['jurusan'. ($i+1)-$request['childCount']])
                    ];
                }
            }

            $db->getReference('faculties/' . $request['fakultas'] . '/jurusan')->update($jurusan);
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Penambahan Jurusan Gagal. Silakan Coba Lagi.');
        }

        return redirect('/adPanel/fakultas')->with('success', 'Penambahan Jurusan Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $db = Firebase::database();

        try{
            $db->getReference('faculties/' . $request['fakultas'])->remove();
            return redirect('/adPanel/fakultas')->with('success', 'Fakultas Berhasil Dihapus!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Gagal menghapus Fakultas. Silakan coba lagi.');
        }
    }

    public function destroyJur(Request $request)
    {
        $db = Firebase::database();

        try{
            $db->getReference('faculties/' . $request['fakultas'] . '/jurusan/' . $request['jurusan'])->remove();
            return redirect('/adPanel/fakultas')->with('success', 'Jurusan Berhasil Dihapus!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Gagal menghapus Fakultas. Silakan coba lagi.');
        }
    }
}
