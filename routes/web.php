<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdPanelController;
use App\Http\Controllers\DosPanelController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\FakultasController;
use App\Http\Controllers\PesanController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Kreait\Laravel\Firebase\Facades\Firebase;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home', [
        'title' => 'Beranda',
    ]);
});

Route::get('/about', function () {
    return view('about', [
        'title' => "Tentang Kami"
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'title' => "Hubungi Kami"
    ]);
});

Route::get('/course', [CourseController::class, 'index']);
Route::get('/course/{wildcard}', [CourseController::class, 'vidList']);
Route::post('/course/{wildcard}', [CourseController::class, 'vidList']);
Route::get('/course/{wildcard}/{video}', [CourseController::class, 'vidStream']);
Route::post('/rate', [CourseController::class, 'rate']);

Route::get('/login', [LoginController::class, 'index'])->middleware('login');
Route::get('/forgotpass', [LoginController::class, 'forgotPass'])->middleware('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgotpass', [LoginController::class, 'resetPass']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('login');
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/adReg', [RegisterController::class, 'adReg']);
Route::post('/dosReg', [RegisterController::class, 'dosReg']);

Route::resource('/dashboard', DashboardController::class)->except(['show', 'store'])->middleware('tamu')->middleware('profile');
Route::post('/dashboard/create', [DashboardController::class, 'store'])->middleware('tamu')->middleware('profile');
Route::get('/dashboard/quiz', [DashboardController::class, 'kuis'])->middleware('tamu')->middleware('profile');
Route::get('/dashboard/account', [DashboardController::class, 'manageAccount'])->middleware('tamu')->middleware('profile');
Route::post('/dashboard/account', [DashboardController::class, 'passwordChange'])->middleware('tamu')->middleware('profile');
Route::get('/dashboard/pesan', [PesanController::class, 'indexUser'])->middleware('tamu')->middleware('profile');
Route::post('/dashboard/pesan', [PesanController::class, 'pesan'])->middleware('tamu')->middleware('profile');

Route::resource('/adPanel/video', VideoController::class)->middleware('admin');
Route::post('/adPanel/video/{wildcard}/edit', [VideoController::class, 'edit'])->middleware('admin');
Route::put('/adPanel/video/{wildcard}/react', [VideoController::class, 'reactivate'])->middleware('admin');

Route::get('/adReg', [AdPanelController::class, 'adReg'])->middleware('admin');
Route::get('/dosReg', [DosPanelController::class, 'dosReg'])->middleware('admin');
Route::get('/adPanel', [AdPanelController::class, 'adPanel'])->middleware('admin');
Route::get('/adPanel/users', [AdPanelController::class, 'adUsers'])->middleware('admin');
Route::post('/adPanel/users', [AdPanelController::class, 'adUsers'])->middleware('admin');
Route::delete('/adPanel/users/del', [AdPanelController::class, 'delUser']);
Route::get('/adPanel/laporan', [AdPanelController::class, 'laporan'])->middleware('admin');
Route::post('/adPanel/laporan', [AdPanelController::class, 'laporan'])->middleware('admin');

Route::get('/keranjang', [TransaksiController::class, 'keranjangku'])->middleware('tamu')->middleware('profile');
Route::post('/keranjang', [TransaksiController::class, 'keranjang']);
Route::post('/checkout', [TransaksiController::class, 'checkout']);
Route::post('/remove', [TransaksiController::class, 'remove']);
Route::post('/removeAll', [TransaksiController::class, 'removeAll']);
Route::get('/adPanel/transaksi', [TransaksiController::class, 'transaksi'])->middleware('admin');
Route::post('/adPanel/transaksi', [TransaksiController::class, 'transaksi'])->middleware('admin');
Route::post('/adPanel/transaksi/validate', [TransaksiController::class, 'validasi'])->middleware('admin');

Route::resource('/adPanel/quiz', KuisController::class)->middleware('admin');
Route::post('adPanel/quiz/create', [KuisController::class, 'create']);
Route::post('adPanel/quiz/{create}/edit', [KuisController::class, 'edit']);
Route::get('/dashboard/quiz/{video}/{wildcard}', [KuisController::class, 'tampilKuis'])->middleware('tamu');
Route::post('/dashboard/quiz/{video}/{wildcard}', [KuisController::class, 'tampilKuis'])->middleware('tamu');
Route::post('/dashboard/quiz/{video}', [KuisController::class, 'jawabKuis'])->middleware('tamu')->middleware('profile');

Route::resource('/adPanel/fakultas', FakultasController::class)->middleware('admin');
Route::delete('/adPanel/fakultas', [FakultasController::class, 'destroyJur'])->middleware('admin');

Route::get('/dosPanel', [DosPanelController::class, 'dosPanel'])->middleware('dosen');

Route::get('/dosPanel/video', [VideoController::class, 'indexDos'])->middleware('dosen');
Route::post('/dosPanel/video', [VideoController::class, 'storeDos'])->middleware('dosen');
Route::get('/dosPanel/video/create', [VideoController::class, 'create'])->middleware('dosen');
Route::get('/dosPanel/video/{video}/edit', [VideoController::class, 'editDos'])->middleware('dosen');
Route::post('/dosPanel/video/{video}/edit', [VideoController::class, 'editDos'])->middleware('dosen');
Route::put('/dosPanel/video/{video}', [VideoController::class, 'updateDos'])->middleware('dosen');

Route::get('/dosPanel/kuis', [KuisController::class, 'index']);
Route::get('/dosPanel/kuis/create', [KuisController::class, 'create']);
Route::post('/dosPanel/kuis/create', [KuisController::class, 'create']);
Route::post('/dosPanel/kuis', [KuisController::class, 'store']);
Route::get('/dosPanel/kuis/{video}/edit', [KuisController::class, 'edit']);
Route::put('/dosPanel/kuis/{video}', [KuisController::class, 'update']);
Route::delete('/dosPanel/kuis/{video}', [KuisController::class, 'destroy']);

Route::get('/dosPanel/pesan', [PesanController::class, 'index']);

Route::get('/dataTest', [AdPanelController::class, 'dataTest']);