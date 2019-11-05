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


Route::get('/konfigurasi', 'MoneyController@config')->name('konfigurasi');
Route::get('/konfigurasi/subkategori/{id}', 'MoneyController@subkategori');
Route::get('/laporan', 'MoneyController@laporan');
Route::get('/tabunganberencana', 'MoneyController@tabunganberencana');



Route::get('/transaksi/cetakpdf', 'MoneyController@cetakpdf');
Route::get('/transaksi/cetakexcel', 'MoneyController@cetakexcel');



Route::post('/konfigurasi/tambahpemasukan', 'MoneyController@storekategoripemasukan');
Route::post('/konfigurasi/tambahpengeluaran', 'MoneyController@storekategoripengeluaran');
Route::post('/konfigurasi/tambahsubkategori/{id}', 'MoneyController@storesubkategori');
Route::post('/tabunganberencana/tambahtabunganberencana', 'MoneyController@storetabunganberencana');
Route::post('/transaksi/tambahtransaksipemasukan', 'MoneyController@storetransaksipemasukan');
Route::post('/transaksi/tambahtransaksipengeluaran', 'MoneyController@storetransaksipengeluaran');