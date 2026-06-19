<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PelangganController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ManajemenPelangganController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\PelaporanAdminController;
use App\Http\Controllers\PengambilanSampahController;
use App\Http\Controllers\PenukaranRewardController;
use App\Http\Controllers\RuteController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\BerlanggananController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LaporanTransaksiController;
use App\Http\Controllers\PenghasilanBerlanggananController;
use App\Http\Controllers\TransaksiController;

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
    return view('Pelanggan.landing');
});

Route::get('/', [ArtikelController::class, 'showArtikelPelanggan'])->name('artikel.show');

// Auth
Route::get('/register', function () {
    return view('Pelanggan.register');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('password/forgot', [PasswordResetController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetFormWithToken'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'reset'])->name('password.update');
Route::get('/riwayat', [RiwayatController::class, 'index'])->name('pelanggan.riwayat');






// Admin
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [ManajemenPelangganController::class, 'index'])->name('admin.manajemenPelanggan');
    Route::get('/admin/pelanggan/{id}/edit', [ManajemenPelangganController::class, 'edit'])->name('admin.pelanggan.edit');
    Route::put('/admin/pelanggan/{id}', [ManajemenPelangganController::class, 'update'])->name('admin.pelanggan.update');
});
Route::patch('/admin/update-profile', [AdminController::class, 'updateProfileAndPassword'])->name('admin.nama_dan_password.update');






// Pelanggan
Route::middleware(['pelanggan'])->group(function () {
    Route::get('/pelanggan/landing', [PelangganController::class, 'landing'])->name('pelanggan.landing');
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('pelanggan.riwayat');
    Route::get('/reward', [PenukaranRewardController::class, 'showReward'])->name('pelanggan.reward');
    Route::get('/status/reward', [PenukaranRewardController::class, 'riwayatReward'])->name('status.reward');
    Route::post('/berlangganan/create', [BerlanggananController::class, 'create'])->name('berlangganan.create');
    Route::post('/berlangganan/store', [BerlanggananController::class, 'store'])->name('berlangganan.store');
    Route::post('/pengaturan/profil/simpan', [PelangganController::class, 'updateProfil'])->name('pengaturan.profil.simpan');
});




Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth:pelanggan')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('pelanggan.dashboard');
})->middleware(['auth:pelanggan', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user('pelanggan')->sendEmailVerificationNotification();
    return back()->with('status', 'Link verifikasi telah dikirim!');
})->middleware(['auth:pelanggan', 'throttle:6,1'])->name('verification.send');

// Rute
Route::get('/Admin.rute', [RuteController::class, 'showRute'])->name('optimasi.rute');
Route::post('/admin/tambah-ember', [PengambilanSampahController::class, 'tambahEmber'])->name('Admin.tambahEmber');

// Manajemen Artikel
Route::get('/Admin.manajemenArtikel', [ArtikelController::class, 'showArtikelAdmin']);
Route::get('/Admin.createArtikel', function () {
    return view('Admin.createArtikel');
});
Route::get('/Admin.createArtikel', [ArtikelController::class, 'create'])->name('artikel.create');
Route::post('/Admin.storeArtikel', [ArtikelController::class, 'store'])->name('artikel.store');
Route::middleware(['admin'])->group(function () {
    Route::get('/artikel/edit/{artikel_id}', [ArtikelController::class, 'edit'])->name('artikel.edit');
    Route::post('/artikel/update/{artikel_id}', [ArtikelController::class, 'update'])->name('artikel.update');
});
Route::delete('/artikel/destroy/{artikek_id}', [ArtikelController::class, 'destroy'])->name('artikel.destroy');
Route::get('/artikel/read/{artikel_id}', [ArtikelController::class, 'read'])->name('artikel.read');

// Pelaporan Admin
Route::get('/laporan', [PelaporanAdminController::class, 'pengambilanPerBulan'])->name('admin.pelaporan');

// Laporan Penghasilan Berlangganan
Route::get('/pengahsilan/berlangganan', [PenghasilanBerlanggananController::class, 'penghasilanBerlangganan'])->name('admin.pengahsilanBerlangganan');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');
Route::post('/pengaturan/nama', [PelangganController::class, 'updateNama'])->name('pengaturan.nama.simpan');
Route::post('/pengaturan/password', [PelangganController::class, 'updatePassword'])->name('pengaturan.password.simpan');
// Route::get('/ecomerce', function () {
//     return view('Pelanggan.ecomerce');
// });

//Manajemem Reward
Route::get('/Admin.manajemenReward', [RewardController::class, 'showRewardAdmin'])->name('admin.manajemenReward');
Route::get('/Admin.createReward', function () {
    return view('Admin.createReward');
});
Route::get('/Admin.createReward', [RewardController::class, 'create'])->name('reward.create');
Route::post('/Admin.storeReward', [RewardController::class, 'store'])->name('reward.store');
Route::get('/reward/edit/{reward_id}', [RewardController::class, 'edit'])->name('reward.edit');
Route::post('/reward/update/{reward_id}', [RewardController::class, 'update'])->name('reward.update');
Route::delete('/reward/destroy/{reward_id}', [RewardController::class, 'destroy'])->name('reward.destroy');
Route::get('/konfirmasi/reward', [RewardController::class, 'konfirmasiReward'])->name('konfirmasi.reward');
Route::put('/konfirmasi/reward', [RewardController::class, 'ubahStatus'])->name('admin.reward.update');

//Katalog
Route::prefix('katalog')->name('katalog.')->group(function () {
    Route::get('/', [KatalogController::class, 'index'])->name('index');
    Route::get('/create', [KatalogController::class, 'create'])->name('create');
    Route::post('/', [KatalogController::class, 'store'])->name('store');
    // Route::get('/{id}', [KatalogController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [KatalogController::class, 'edit'])->name('edit');
    Route::put('/{produk}', [KatalogController::class, 'update'])->name('update');
    Route::delete('/{id}', [KatalogController::class, 'destroy'])->name('destroy');
    Route::put('/{id}/restore', [KatalogController::class, 'restore'])->name('restore');
});

//Keranjang
Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

//Transaksi
Route::get('/checkout/preview', [TransaksiController::class, 'checkoutPreview'])->name('checkout.preview');
Route::post('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/admin/transaksi/{id}', [TransaksiController::class, 'detail'])->name('transaksi.show');
Route::get('/pelanggan/transaksi/{id}', [TransaksiController::class, 'detail'])->name('transaksi.detail');
Route::put('/transaksi/{id}/selesai', [TransaksiController::class, 'setSelesai'])->name('transaksi.selesai');
Route::put('/transaksi/{id}/update-status', [TransaksiController::class, 'updateStatus'])->name('transaksi.updateStatus');
Route::put('/transaksi/{id}/unvalid-order', [TransaksiController::class, 'batalkanOrder'])->name('transaksi.batalkan');

//Laporan Transaksi
Route::get('/laporan-transaksi', [LaporanTransaksiController::class, 'index'])->name('laporan.transaksi.index');

//Penukaran Reward
Route::post('/reward/tukar/{reward_id}', [PenukaranRewardController::class, 'tukar'])->name('reward.tukar');
