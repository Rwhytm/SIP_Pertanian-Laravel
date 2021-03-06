<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    return view('welcome');
});
Route::group(
    
    [['middleware' => ['role:pembeli', 'role:admin']],'namespace' => 'Users', 'prefix' => 'users'],
    function(){
        Route::get('home', 'UserController@index')->name('home user');
        Route::get('home/terbaru', 'UserController@terbaru')->name('terbaru');
        Route::get('home/terlama', 'UserController@terlama')->name('terlama');
        Route::get('home/dari-tinggi', 'UserController@daritinggi')->name('hargatinggi');
        Route::get('home/dari-rendah', 'UserController@darirendah')->name('hargarendah');


        Route::get('filter-kategori/{id}', 'UserController@kategori')->name('filter.kategori');
        

        // pemesanan produk user
        Route::get('tampil-produk/{id}', 'UserController@produk')->name('tampil.produk');
        Route::post('keranjang', 'UserController@tambah')->name('keranjang');
        Route::get('keranjang/{id}', 'UserController@keranjang')->name('tampil keranjang');
        Route::delete('keranjang/hapus/{id}', 'UserController@hapus')->name('hapus keranjang');
        Route::post('preorder', 'UserController@preorder')->name('preorder');
        Route::put('terima-pesanan/{id}', 'UserController@terimapesanan')->name('terima.pesanan');

        Route::get('pesanan','UserController@bayar')->name('bayar');
        Route::put('checkout', 'UserController@checkout')->name('checkout');
        Route::get('konfirmasi/{id}','UserController@konfirmasi')->name('konfirmasi');
        Route::get('pesanan-saya', 'UserController@pesanansaya')->name('pesanansaya');
        Route::get('riwayat-pesanan', 'UserController@riwayatpesanan')->name('riwayatpesanan');
        Route::get('pesanan-terkonfirmasi', 'UserController@pesananterkonfirmasi')->name('pesananterkonfirmasi');
        Route::get('pesanan-dibayar', 'UserController@pesanandiproses')->name('pesanandiproses');
        Route::put('konfirmasi/pesanan/{id}','UserController@konfirmasipesanan')->name('konfirmasipesanan');


        Route::get('cari','UserController@cari')->name('cari.produk');

    }
);



// Grup role admin
Route::group(
    
    [['middleware' => ['role:admin']],'namespace' => 'Admin', 'prefix' => 'admin'],
    function(){

        // pesanan user
        Route::get('list-pesanan', 'DashboardController@pesananpending')->name('pesanan.pending');
        Route::get('pesanan-sukses', 'DashboardController@pesanansukses')->name('pesanan.sukses');
        Route::get('pesanan-dibayar', 'DashboardController@pesanandibayar')->name('pesanan.dibayar');
        Route::get('pesanan-diproses', 'DashboardController@pesananproses')->name('pesanan.diproses');
        Route::get('pesanan-cancel', 'DashboardController@pesanangagal')->name('pesanan.gagal');
        Route::get('pre-order', 'DashboardController@pesananpreorder')->name('preorder');
        Route::put('proses-pesanan/{id}', 'DashboardController@prosespesanan')->name('proses.pesanan');
        Route::put('cancel-pesanan/{id}', 'DashboardController@cancelpesanan')->name('cancel.pesanan');
        

        // dashboard
        Route::get('dashboard', 'DashboardController@index')->name('dashboard admin');
        Route::get('profile/{id}', 'DashboardController@profil')->name('profil admin');

        // tabel user
        Route::get('list-users', 'DashboardController@user')->name('admin_user');

        //table informasi
        Route::get('pengguna-baru', 'DashboardController@userbaru')->name('user.baru');
        Route::get('barang-baru', 'DashboardController@barangbaru')->name('barang.baru');

        // produk
        Route::get('produk', 'ProdukController@index')->name('produk admin');
        Route::get('produk/tambah', 'ProdukController@tambah');
        Route::get('produk/edit/{id}', 'ProdukController@edit')->name('produk.edit');
        Route::put('produk/update/{id}', 'ProdukController@update')->name('produk.update');
        Route::post('produk/store', 'ProdukController@store')->name('produk store');
        Route::delete('produk/hapus/{id}', 'ProdukController@hapus')->name('produk.hapus');

        // kategori
        Route::get('kategori', 'KategoriController@index')->name('kategori utama');
        Route::get('kategori/tambah', 'KategoriController@tambah')->name('kategori tambah');
        Route::post('kategori/store', 'KategoriController@store')->name('kategori store');
        Route::delete('kategori/hapus/{id}', 'KategoriController@hapus')->name('kategori.hapus');
        Route::get('kategori/edit/{id}', 'KategoriController@edit')->name('kategori.edit');
        Route::put('kategori/update/{id}', 'KategoriController@update')->name('kategori.update');

        // route image produk
        Route::get('produk/{id}/images', 'ProdukController@images')->name('produk.image');
        Route::get('produk/{id}/add-image', 'ProdukController@addImage')->name('add.image');
        Route::post('produk/images/{id}', 'ProdukController@upload_image')->name('upload_image');
        Route::delete('produk/images/{id}', 'ProdukController@remove_image')->name('hapus.image');

        //route download bukti
        Route::get('download-bukti/{id}', 'DashboardController@download')->name('download bukti');
    }
);

Route::get('login/user', 'Auth\LoginController@showLoginForm')->name('login2');
Route::post('login/success', 'Auth\LoginController@login');

Auth::routes();
Route::get('/invoice/{id}', 'Users\UserController@invoice')->name('invoice');
Route::get('/home', 'HomeController@index')->name('home');
// Route::get('generate-pdf/','PDFController@generatePDF')->name('bikin pdf');

// Route::get('/send-email', 'EmailController@Email');
