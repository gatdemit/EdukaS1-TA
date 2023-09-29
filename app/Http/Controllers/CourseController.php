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
}
