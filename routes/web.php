<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JalurController;
use App\Http\Controllers\KodeDistribusiController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\PengambilanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\PembuanganController;
use App\Http\Controllers\PendapatanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\RekananController;
use App\Http\Controllers\SetoranController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifikasiController;
use PHPUnit\TextUI\XmlConfiguration\Group;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Login Page
// Route::get('/', function () {
//     return view('login.login');
// })->name("login");

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});
// Kustom
Route::middleware('guest')->group(function(){
    Route::get('/login', [AuthController::class, 'getLoginUser'])->name('getLoginUser');
    Route::post('/login', [AuthController::class, 'postLoginUser'])->name('postLoginUser');
    Route::get('/registrasi', [AuthController::class, 'getRegistrasi'])->name('getRegistrasi');
    Route::post('/registrasi', [AuthController::class, 'postRegistrasi'])->name('postRegistrasi');
    Route::get('/kode', [KodeDistribusiController::class, 'getKodeDistribusi'])->name('getKodeDistribusi');
    Route::post('/registrasi/verifikasi', [AuthController::class, 'checkVerifikasi'])->name('checkVerifikasi');
    Route::get('/login-pegawai', [AuthController::class, 'getLoginPegawai'])->name('getLoginPegawai');
    Route::post('/login-pegawai', [AuthController::class, 'postLoginPegawai'])->name('postLoginPegawai');
});

Route::post('/whatsapp/send', [VerifikasiController::class, 'sendNotification'])->name('whatsapp.send');

Route::group(['middleware' =>['auth:user,pegawai']], function (){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/single-chart-pelanggan', [DashboardController::class, 'getSingleChartPelanggan'])->name('getSingleChartPelanggan');
    Route::get('/donut-chart-pelanggan', [DashboardController::class, 'getDonutChartPelanggan'])->name('getDonutChartPelanggan');
    Route::get('/sales-chart-pelanggan', [DashboardController::class, 'getSalesChartPelanggan'])->name('getSalesChartPelanggan');

    Route::group(['prefix' => 'pengambilan', 'as' => 'pengambilan.'], function () { 
        Route::get('/', [PengambilanController::class, 'index'])->name('index');
        Route::get('/jadwal', [PengambilanController::class, 'getJadwal'])->name('getJadwal');
        Route::get('/create/{pelanggan}', [PengambilanController::class, 'create'])->name('create');
        Route::post('/create/{pelanggan}', [PengambilanController::class, 'store'])->name('store');
        
    });

    Route::group(['prefix' => 'pembayaran', 'as' => 'pembayaran.'], function () {
        Route::get('/', [PembayaranController::class, 'index'])->name('index');
        Route::get('jadwal', [PembayaranController::class, 'getJadwal'])->name('getJadwal');
        Route::get('create/{pelanggan}', [PembayaranController::class, 'create'])->name('create');
        Route::post('create/{pelanggan}', [PembayaranController::class, 'store'])->name('store');
        Route::get('create-transfer', [PembayaranController::class, 'getTransfer'])->name('getTransfer');
        Route::post('create-transfer', [PembayaranController::class, 'store'])->name('postTransfer');
        Route::get('cetak', [PembayaranController::class, 'cetak'])->name('cetak');

    });

    Route::group(['prefix' => 'verifikasi', 'as' => 'verifikasi.'], function () {
        Route::get('verify-transfer', [VerifikasiController::class, 'getVerifikasiTransfer'])->name('getVerifikasiTransfer');
        Route::patch('verify-transfer/{pembayaran}', [VerifikasiController::class, 'postVerifikasiTransfer'])->name('postVerifikasiTransfer');
        Route::get('verify-setoran', [VerifikasiController::class, 'getVerifikasiSetoran'])->name('getVerifikasiSetoran');
        Route::patch('verify-setoran/{petugas}', [VerifikasiController::class, 'postVerifikasiSetoran'])->name('postVerifikasiSetoran');
        Route::get('verify-pelanggan', [VerifikasiController::class, 'getVerifikasiPelanggan'])->name('getVerifikasiPelanggan');
        Route::patch('verify-pelanggan/{user}',[VerifikasiController::class, 'postVerifikasiPelanggan'])->name('postVerifikasiPelanggan');
        Route::get('/kode', [KodeDistribusiController::class, 'getKodeDistribusi'])->name('getKodeDistribusi');
        Route::get('/sync',[VerifikasiController::class, 'sync'])->name('sync');
        Route::get('nonaktif', [VerifikasiController::class, 'getNonaktif'])->name('getNonaktif');
        Route::get('kadaluarsa', [VerifikasiController::class, 'getKadaluarsa'])->name('getKadaluarsa');
        Route::get('get-fee/{distributionCodeId}', [VerifikasiController::class, 'getFee'])->name('getFee');
    });

    Route::group(['prefix' => 'jalur', 'as' => 'jalur.'], function () { 
        Route::get('/', [JalurController::class, 'index'])->name('index');
        Route::put('/edit/{jalur}', [JalurController::class, 'update'])->name('update');
        Route::patch('/{jalur}', [JalurController::class, 'postUpdateStatus'])->name('postUpdateStatus');
        Route::get('create', [JalurController::class, 'create'])->name('create');
        Route::post('create', [JalurController::class, 'store'])->name('store');
        Route::get('edit/{jalur}', [JalurController::class, 'edit'])->name('edit');
        Route::patch('edit/{jalur}', [JalurController::class, 'update'])->name('update');
        Route::delete('{jalur}', [JalurController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'kode-distribusi', 'as' => 'kode-distribusi.'], function () { 
        Route::get('/', [KodeDistribusiController::class, 'index'])->name('index');
        Route::get('create', [KodeDistribusiController::class, 'create'])->name('create');
        Route::post('create', [KodeDistribusiController::class, 'store'])->name('store');
        Route::get('edit/{kodeDistribusi}', [KodeDistribusiController::class, 'edit'])->name('edit');
        Route::patch('edit/{kodeDistribusi}', [KodeDistribusiController::class, 'update'])->name('update');
        Route::delete('{kodeDistribusi}', [KodeDistribusiController::class, 'destroy'])->name('destroy');
        
    });

    Route::group(['prefix' => 'pelanggan', 'as' => 'pelanggan.'], function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::get('/kode', [KodeDistribusiController::class, 'getKodeDistribusi'])->name('getKodeDistribusi');
        Route::post('create', [UserController::class, 'store'])->name('store');
        Route::patch('/{user}',[UserController::class, 'updateStatus'])->name('updateStatus');
        Route::get('edit/{pelanggan}',[UserController::class, 'edit'])->name('edit');
        Route::patch('edit/{pelanggan}',[UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('delete');
        Route::get('cetak', [UserController::class, 'cetak'])->name('cetak');
        Route::post('/import', [UserController::class, 'import'])->name('import');
        Route::get('/export', [UserController::class, 'export'])->name('export');
    });

    Route::group(['prefix' => 'setoran', 'as' => 'setoran.'], function () {
        Route::get('/', [SetoranController::class, 'index'])->name('index');
        Route::get('cetak', [SetoranController::class, 'cetak'])->name('getCetak');
    });

    Route::group(['prefix' => 'rekanan', 'as' => 'rekanan.'], function () {
        Route::resource('/',RekananController::class);
        Route::get('detail/{rekanan}', [RekananController::class, 'detail'])->name('detail');
    });

    Route::group(['prefix' => 'pendapatan', 'as' => 'pendapatan.'], function () {
        Route::get('/', [PendapatanController::class, 'index'])->name('index');
        Route::get('create', [PendapatanController::class, 'create'])->name('create');
        Route::post('create', [PendapatanController::class, 'store'])->name('store');
        // Route::get('edit', [PendapatanController::class, 'edit'])->name('edit');
        Route::get('cetak', [PendapatanController::class, 'cetak'])->name('cetak');
        Route::delete('/{pendapatan}',[PendapatanController::class, 'destroy'])->name('destroy');
        Route::post('/import', [PendapatanController::class, 'import'])->name('import');
    });

    Route::group(['prefix' => 'pembuangan', 'as' => 'pembuangan.'], function () {
        Route::get('/', [PembuanganController::class, 'index'])->name('index');
        Route::get('create', [PembuanganController::class, 'create'])->name('create');
        Route::post('create', [PembuanganController::class, 'store'])->name('store');
        Route::get('cetak', [PembuanganController::class, 'cetak'])->name('cetak');
        Route::delete('{pembuangan}', [PembuanganController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'petugas', 'as' => 'petugas.'], function () {
        Route::get('/', [PegawaiController::class, 'index'])->name('index');
        Route::get('create', [PegawaiController::class, 'create'])->name('create');
        Route::post('create', [PegawaiController::class, 'store'])->name('store');
        Route::patch('/{pegawai}',[PegawaiController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::group(['prefix' => 'profil', 'as' => 'profil.'], function () {
        Route::get('/', [ProfilController::class, 'index'])->name('index');
        Route::patch('editpass',[ProfilController::class, 'editpass'])->name('editpass');
    });


    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route::group(['middleware' =>['auth:pegawai']], function (){
//     Route::get('/dashboard-pegawai', [DashboardController::class, 'indexPegawai']);

   
// });
