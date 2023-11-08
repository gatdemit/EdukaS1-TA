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
Route::post('/rate', [CourseController::class, 'rate']);

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
Route::get('/forgotpass', [LoginController::class, 'forgotPass'])->middleware('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/forgotpass', [LoginController::class, 'resetPass']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('login');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/adReg', [AdPanelController::class, 'adReg'])->middleware('admin');
Route::get('/adLog', [AdPanelController::class, 'adLog']);
Route::get('/adPanel', [AdPanelController::class, 'adPanel'])->middleware('admin');

Route::post('/adReg', [RegisterController::class, 'adReg']);
Route::post('/adLog', [LoginController::class, 'adLog']);

Route::resource('/dashboard', DashboardController::class)->except(['show'])->middleware('tamu');
Route::get('/dashboard/quiz', [DashboardController::class, 'kuis'])->middleware('tamu');
Route::get('/dashboard/account', [DashboardController::class, 'manageAccount'])->middleware('tamu');
Route::post('/dashboard/account', [DashboardController::class, 'passwordChange'])->middleware('tamu');

Route::resource('/adPanel/video', VideoController::class)->middleware('admin');

Route::get('/adPanel/users', [AdPanelController::class, 'adUsers'])->middleware('admin');
Route::post('/adPanel/users', [AdPanelController::class, 'delUser']);

Route::get('/keranjang', [TransaksiController::class, 'keranjangku'])->middleware('tamu');
Route::post('/keranjang', [TransaksiController::class, 'keranjang']);
Route::post('/checkout', [TransaksiController::class, 'checkout']);
Route::post('/remove', [TransaksiController::class, 'remove']);
Route::post('/removeAll', [TransaksiController::class, 'removeAll']);
Route::get('/adPanel/transaksi', [TransaksiController::class, 'transaksi'])->middleware('admin');
Route::post('/adPanel/transaksi/validate', [TransaksiController::class, 'validasi'])->middleware('admin');

Route::resource('/adPanel/quiz', KuisController::class)->middleware('admin');
Route::post('adPanel/quiz/create', [KuisController::class, 'create']);
Route::get('/dashboard/quiz/{video}', [KuisController::class, 'tampilKuis'])->middleware('login');
Route::post('/dashboard/quiz/{video}', [KuisController::class, 'jawabKuis'])->middleware('login');

Route::get('/adPanel/laporan', [AdPanelController::class, 'laporan'])->middleware('admin');
Route::post('/adPanel/laporan', [AdPanelController::class, 'laporan'])->middleware('admin');

Route::get('/userList', [AdPanelController::class, 'userList']);

Route::get('/vidList', [AdPanelController::class, 'vidList']);

Route::get('/dataTest', [AdPanelController::class, 'dataTest']);
Route::get('/makeUser', [AdPanelController::class, 'makeUser']);
Route::get('/addData', [AdPanelController::class, 'addData']);
Route::get('/revoke', [DashboardController::class, 'revoke']);
Route::get('/playground', function() {
    return view('playground');
});
