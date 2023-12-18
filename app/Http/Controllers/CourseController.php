<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(){
        $db = Firebase::database();
        return view('course.index', [
            'title' => "Our Course",
            'fakultas' => $db->getReference('faculties')->getValue()
        ]);
    }

    public function vidList(Request $request){
        $jurusan = Firebase::database()->getReference('faculties')->getValue();
        if($request['search']){
            return view('course.vidList', [
                'title' => 'Our Course',
                'fakultas' => $jurusan, 
                'search' => true,
                'query' => $request['search']
            ]);
        } else{
            return view('course.vidList', [
                'title' => 'Our Course',
                'fakultas' => $jurusan, 
                'search' => false
            ]);
        }
    }

    public function vidStream(){
        $jurusan = Firebase::database()->getReference('faculties')->getValue();
        return view('course.vidStream', [
            'title' => 'Our Course',
            'fakultas' => $jurusan
        ]);
    }

    public function rate(Request $request){
        $db=Firebase::database();
        try{   
            if($db->getReference('users/' . $request['email'] . '/vids/' . $request['link']. '/rated')->getSnapshot()->exists()){
                $user_rate = $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->getValue()['user_rate'];
                $rate = $db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'])->getValue()['rating'];
                $db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'])->update([
                    'rating' => ($rate - $user_rate) + $request['rating'],
                ]);
                $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->update([
                    'user_rate' => $request['rating']
                ]);
                return redirect()->back()->with('success', 'Rating Berhasil!');
            } else{
                if($db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'] . '/rating')->getSnapshot()->exists()){
                    $rate = $db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'])->getValue()['rating'];
                    $rate_count = $db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'])->getValue()['rate_count'];
                    $db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'])->update([
                        'rating' => $request['rating'] + $rate,
                        'rate_count' => $rate_count + 1
                    ]);
                    $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->update([
                        'user_rate' => $request['rating'],
                        'rated' => true
                    ]);
    
                    return redirect()->back()->with('success', 'Rating Berhasil!');
                } else{
                    $db->getReference('videos/' . $request['jurusan'] . '/' . $request['link'])->update([
                        'rating' => $request['rating'],
                        'rate_count' => 1
                    ]);
                    $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->update([
                        'user_rate' => $request['rating'],
                        'rated' => true
                    ]);
                    return redirect()->back()->with('success', 'Rating Berhasil!');
                }
            }
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'Rating Gagal. Silakan Coba Lagi.');
        }
    }
}
