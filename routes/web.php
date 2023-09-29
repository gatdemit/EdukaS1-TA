<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdPanelController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KuisController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
        'title' => 'Home',
        'user' => 'Guest'
    ]);
});

Route::get('/course', [CourseController::class, 'index']);
Route::get('/course/{wildcard}', [CourseController::class, 'vidList']);
Route::get('/course/{wildcard}/{video}', [CourseController::class, 'vidStream']);

Route::get('/about', function () {
    return view('about', [
        'title' => "About Us"
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'title' => "Contact Person"
    ]);
});

Route::get('/login', [LoginController::class, 'index'])->middleware('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/check',[LoginController::class, 'userCheck']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('login');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/adReg', [AdPanelController::class, 'adReg']);
Route::get('/adLog', [AdPanelController::class, 'adLog']);
Route::get('/adPanel', [AdPanelController::class, 'adPanel']);

Route::post('/adReg', [RegisterController::class, 'adReg']);
Route::post('/adLog', [LoginController::class, 'adLog']);

Route::resource('/dashboard', DashboardController::class)->middleware('tamu');
Route::get('/quiz', [DashboardController::class, 'kuis'])->middleware('tamu');

Route::resource('/adPanel/video', VideoController::class)->middleware('tamu');

Route::get('/adPanel/users', [AdPanelController::class, 'adUsers']);

Route::post('/keranjang', [TransaksiController::class, 'keranjang']);
Route::get('/adPanel/transaksi', [TransaksiController::class, 'transaksi']);
Route::post('/adPanel/transaksi/validate', [TransaksiController::class, 'validasi']);

Route::resource('/adPanel/quiz', KuisController::class);
Route::post('adPanel/quiz/create', [KuisController::class, 'create']);
Route::get('quiz/{video}', [KuisController::class, 'tampilKuis']);
Route::post('quiz/{video}', [KuisController::class, 'jawabKuis']);

Route::get('/userList', [AdPanelController::class, 'userList']);

Route::get('/vidList', [AdPanelController::class, 'vidList']);

Route::get('/dataTest', [AdPanelController::class, 'dataTest']);
