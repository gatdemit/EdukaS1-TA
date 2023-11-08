<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;

class KuisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $db=Firebase::database();

        return view('adPanel.sidemenu.kuis.index',[
            'title' => 'Admin Panel | Quiz',
            'videos' => $db->getReference('videos')->getValue()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('adPanel.sidemenu.kuis.create',[
            'title' => 'Admin Panel | Quiz',
            'video' => $request['video']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $db = Firebase::database();
        $updates = [];
        try{
            for($i=0; $i<=$request['count']; $i++){
                $updates += [
                    'pertanyaan ' . $i+1 => [
                        'pertanyaan' => $request['pertanyaan' . $i+1],
                        'jawaban' => [
                            'jawaban 1' => $request['jawaban' . ($i*5)+1],
                            'jawaban 2' => $request['jawaban' . ($i*5)+2],
                            'jawaban 3' => $request['jawaban' . ($i*5)+3],
                            'jawaban 4' => $request['jawaban' . ($i*5)+4],
                            'jawaban 5' => $request['jawaban' . ($i*5)+5],
                            'kunci jawaban' => $request['radio' . $i+1]
                        ]
                    ], 
                ];
            }
    
            $db->getReference('videos/' . $request['video']. '/kuis')->update($updates);
    
            return redirect('adPanel/quiz')->with('success', 'Kuis Berhasil Ditambahkan!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Penambahan Kuis Gagal. Silakan Coba Lagi.');
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
    public function edit(string $id)
    {
        return view('adPanel.sidemenu.kuis.edit',[
            'title' => 'Admin Panel | Quiz'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $db = Firebase::database();
        $updates = [];
        try{
            for($i=0; $i<=$request['count']; $i++){
                $updates += [
                    'pertanyaan ' . $i+1 => [
                        'pertanyaan' => $request['pertanyaan' . $i+1],
                        'jawaban' => [
                            'jawaban 1' => $request['jawaban' . ($i*5)+1],
                            'jawaban 2' => $request['jawaban' . ($i*5)+2],
                            'jawaban 3' => $request['jawaban' . ($i*5)+3],
                            'jawaban 4' => $request['jawaban' . ($i*5)+4],
                            'jawaban 5' => $request['jawaban' . ($i*5)+5],
                            'kunci jawaban' => $request['radio' . $i+1]
                        ]
                    ], 
                ];
            }
    
            $db->getReference('videos/' . $request['video']. '/kuis')->update($updates);
    
            return redirect('adPanel/quiz')->with('success', 'Kuis Berhasil Diperbarui!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Pembaruan Kuis Gagal. Silakan Coba Lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $db=Firebase::database();

        try{
            $db->getReference('videos/' . $request['video'] . '/kuis')->remove();
    
            return redirect('adPanel/quiz')->with('success', 'Penghapusan Kuis Berhasil!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Penghapusan Kuis Gagal.');
        }
    }

    public function tampilKuis(){
        return view('course.kuis',[
            'title' => 'Our Course'
        ]);
    }

    public function jawabKuis(Request $request){
        $db = Firebase::database();
        $nilai = 0;

        try{
            for($i=1; $i <= $request['question_count']; $i++){
                if($request['Pertanyaan_' . $i] == $db->getReference('videos/' . $request['video'] . '/kuis')->getValue()['pertanyaan '. $i]['jawaban']['kunci jawaban']){
                    $nilai++;
                }
            }
    
            $score = $nilai/count($db->getReference('videos/' . $request['video'] . '/kuis')->getValue())*100;
    
            $db->getReference('users/' . Session::get('email') . '/vids/' . $request['video'])->update([
                'nilai' => $score
            ]);
    
            return redirect('/dashboard/quiz')->with('success', 'Kuis Berhasil Dikerjakan!');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Terjadi Kesalahan Dalam Pengerjaan Kuis. Silakan Coba Lagi.');
        }
    }
}
