<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth\UserQuery;
use Illuminate\Support\Facades\Session;

class DosPanelController extends Controller
{
    public function dosReg(){
        return view('adReg.dosen', [
            'title' => 'Pendaftaran Admin'
        ]);
    }

    public function dosPanel(){
        return view('dosPanel.index', [
            'title' => 'Dosen Panel',
            'header' => "Selamat Datang di Dosen Panel",
        ]);
    }
}
