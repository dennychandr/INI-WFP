<?php

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

Auth::routes();

Route::get('/dashboard', 'HomeController@index');
Route::post('/dashboard/filter', 'HomeController@filterdate');


Route::get('/konfigurasi', 'MoneyController@config')->name('konfigurasi');
Route::get('/konfigurasi/subkategori/{id}', 'MoneyController@subkategori');
Route::get('/laporanpengeluaranpemasukan', 'MoneyController@laporanpengeluaranpemasukan');
Route::get('/laporantrendpemasukan', 'MoneyController@laporantrendpemasukan');
Route::get('/laporantrendpengeluaran', 'MoneyController@laporantrendpengeluaran');
Route::get('/tabunganberencana', 'MoneyController@tabunganberencana');



Route::get('/transaksi/cetakpdf', 'MoneyController@cetakpdf');
Route::get('/transaksi/cetakexcel', 'MoneyController@cetakexcel');



Route::post('/konfigurasi/tambahpemasukan', 'MoneyController@storekategoripemasukan');
Route::post('/konfigurasi/tambahpengeluaran', 'MoneyController@storekategoripengeluaran');
Route::post('/konfigurasi/tambahsubkategori/{id}', 'MoneyController@storesubkategori');
Route::post('/tabunganberencana/tambahtabunganberencana', 'MoneyController@storetabunganberencana');
Route::post('/transaksi/tambahtransaksipemasukan', 'MoneyController@storetransaksipemasukan');
Route::post('/transaksi/tambahtransaksipengeluaran', 'MoneyController@storetransaksipengeluaran');

Route::post('/konfigurasi/deletekategori/{id}', 'MoneyController@deletekategori');
Route::post('/konfigurasi/ubahsaldo', 'MoneyController@updatesaldo');
Route::post('/konfigurasi/deletesubkategori/{id}/{kid}', 'MoneyController@deletesubkategori');
Route::post('/konfigurasi/deletetabungan/{id}', 'MoneyController@deletetabungan');
Route::post('/tabunganberencana/updatenominaltabungan', 'MoneyController@updatenominaltabungan');
Route::post('/tabunganberencana/updatetabungan', 'MoneyController@updatetabungan');
Route::post('/konfigurasi/updatekategoripemasukan', 'MoneyController@updatekategoripemasukan');
Route::post('/konfigurasi/updatekategoripengeluaran', 'MoneyController@updatekategoripengeluaran');
Route::post('/konfigurasi/updatesubkategori', 'MoneyController@updatesubkategori');
Route::post('/konfigurasi/reminder', 'MoneyController@addreminder');