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
        $jurusan = [ 
            'Mata Kuliah Umum' => ['Umum'],
            'Fakultas Ekonomika dan Bisnis' => ['Akuntansi', 'Manajemen', 'Bisnis Digital', 'Ilmu Ekonomi', 'Ekonomi Islam'],
            'Fakultas Hukum' => ['Hukum'],
            'Fakultas Ilmu Budaya' => ['Sejarah', 'Sastra Indonesia', 'Bahasa dan Kebudayaan Jepang', 'Sastra Inggris', 'Antropologi Sosial', 'Ilmu Perpustakaan'],
            'Fakultas Ilmu Sosial dan Ilmu Politik' => ['Administrasi Bisnis', 'Administrasi Publik', 'Hubungan Internasional', 'Ilmu Komunikasi', 'Ilmu Pemerintahan'],
            'Fakultas Kedokteran' => ['Kedokteran', 'Kedokteran Gigi', 'Farmasi'],
            'Fakultas Kesehatan Masyarakat' => ['Kesehatan Masyarakat'],
            'Fakultas Perikanan dan Ilmu Kelautan' => ['Sumber Daya Perairan', 'Akuakultur', 'Perikanan Tangkap', 'Teknologi Hasil Perikanan', 'Ilmu Kelautan', 'Oseanografi'],
            'Fakultas Peternakan dan Pertanian' => ['Peternakan', 'Teknologi Pangan', 'Agroekoteknologi', 'Agribisnis'],
            'Fakultas Psikologi' => ['Psikologi'],
            'Fakultas Sains dan Matematika' => ['Matematika', 'Biologi', 'Fisika', 'Kimia', 'Statistika', 'Informatika', 'Bioteknologi'],
            'Fakultas Teknik' => ['Teknik Sipil', 'Arsitektur', 'Teknik Kimia', 'Teknik Perencanaan Wilayah dan Kota', 'Teknik Mesin', 'Teknik Elektro', 'Teknik Perkapalan', 'Teknik Industri', 'Teknik Lingkungan', 'Teknik Geologi', 'Teknik Geodesi', 'Teknik Komputer'],
        ];
        return view('course.index', [
            'title' => "Our Course",
            'facs' => $jurusan
        ]);
    }

    public function vidList(){
        $jurusan = ['Teknik Sipil', 'Arsitektur', 'Teknik Kimia', 'Teknik Perencanaan Wilayah dan Kota', 'Teknik Mesin', 'Teknik Elektro', 'Teknik Perkapalan', 'Teknik Industri', 'Teknik Lingkungan', 'Teknik Geologi', 'Teknik Geodesi', 'Teknik Komputer', 'Kedokteran', 'Kedokteran Gigi', 'Farmasi', 'Kesehatan Masyarakat', 'Matematika', 'Biologi', 'Fisika', 'Kimia', 'Statistika', 'Informatika', 'Bioteknologi', 'Peternakan', 'Teknologi Pangan', 'Agroekoteknologi', 'Agribisnis', 'Sumber Daya Perairan', 'Akuakultur', 'Perikanan Tangkap', 'Teknologi Hasil Perikanan', 'Ilmu Kelautan', 'Oseanografi', 'Hukum', 'Akuntansi', 'Manajemen', 'Bisnis Digital', 'Ilmu Ekonomi', 'Ekonomi Islam', 'Administrasi Bisnis', 'Administrasi Publik', 'Hubungan Internasional', 'Ilmu Komunikasi', 'Ilmu Pemerintahan', 'Sejarah', 'Sastra Indonesia', 'Bahasa dan Kebudayaan Jepang', 'Sastra Inggris', 'Antropologi Sosial', 'Ilmu Perpustakaan', 'Psikologi'];
        return view('course.vidList', [
            'title' => 'Our Course',
            'jurusan' => $jurusan, 
            'videos' => Firebase::database()->getReference('videos')->getValue()
        ]);
    }

    public function vidStream(){
        return view('course.vidStream', [
            'title' => 'Our Course'
        ]);
    }

    public function rate(Request $request){
        $db=Firebase::database();
        try{   
            if($db->getReference('users/' . $request['email'] . '/vids/' . $request['link']. '/rated')->getSnapshot()->exists()){
                $user_rate = $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->getValue()['user_rate'];
                $rate = $db->getReference('videos/' . $request['link'])->getValue()['rating'];
                $db->getReference('videos/' . $request['link'])->update([
                    'rating' => ($rate - $user_rate) + $request['rating'],
                ]);
                $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->update([
                    'user_rate' => $request['rating']
                ]);
                return redirect()->back()->with('success', 'Rating Berhasil!');
            } else{
                if($db->getReference('videos/' . $request['link'] . '/rating')->getSnapshot()->exists()){
                    $rate = $db->getReference('videos/' . $request['link'])->getValue()['rating'];
                    $rate_count = $db->getReference('videos/' . $request['link'])->getValue()['rate_count'];
                    $db->getReference('videos/' . $request['link'])->update([
                        'rating' => $request['rating'] + $rate,
                        'rate_count' => $rate_count + 1
                    ]);
                    $db->getReference('users/' . $request['email'] . '/vids/' . $request['link'])->update([
                        'user_rate' => $request['rating'],
                        'rated' => true
                    ]);
    
                    return redirect()->back()->with('success', 'Rating Berhasil!');
                } else{
                    $db->getReference('videos/' . $request['link'])->update([
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
