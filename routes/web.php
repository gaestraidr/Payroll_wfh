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

// Login Page
Route::get('/', 'Auth\LoginController@showLoginForm');

// Base Route Domain
Route::group(['middleware' => ['auth', 'xss']], function() {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('home');

    // Absensi General
    Route::get('/dashboard/absensi', 'AbsensiController@index')->name('absensi');
    Route::post('dashboard/absensi', 'AbsensiController@store')->name('absensi.store');
    Route::get('/dashboard/absensi/holiday/data', 'AbsensiController@holiday')->name('absensi.holiday');
    Route::get('/dashboard/absensi/detail/{id?}', 'AbsensiController@detail')->name('absensi.detail');
    Route::get('/dashboard/absensi/detail/monthly/{month}/{id?}', 'AbsensiController@monthly')->name('absensi.monthly');
    Route::get('/dashboard/absensi/detail/print/{month}/{id?}', 'AbsensiController@print')->name('absen.print');

    // Izin General
    Route::get('/dashboard/izin/lapor', 'IzinController@index')->name('izin.lapor');
    Route::post('/dashboard/izin/lapor', 'IzinController@store')->name('izin.store');
    Route::get('/dashboard/izin/photo/{id}', 'IzinController@viewPhoto')->name('izin.photo');

    // Gaji General
    Route::get('/dashboard/gaji', 'GajiController@index')->name('gaji');
    Route::get('/dashboard/gaji/{id}/{month}', 'GajiController@gather')->name('gaji.gather');

    // Superadmin Route Domain
    Route::group(['middleware' => ['auth.role']], function() {
        // Gaji Superadmin
        Route::get('/dashboard/gaji/print/{month}/all', 'GajiController@printAll')->name('gaji.printAll');

        // Izin Superadmin
        Route::get('/dashboard/izin/moderate/', 'IzinController@moderate')->name('izin.moderate');
        Route::get('/dashboard/izin/moderate/{id}', 'IzinController@detail')->name('izin.detail');
        Route::put('/dashboard/izin/moderate/{id}/{approval}', 'IzinController@approval')->name('izin.approval');

        // Jabatan Superadmin
        Route::get('/dashboard/jabatan', 'JabatanController@index')->name('jabatan');
        Route::get('/dashboard/jabatan/create', 'JabatanController@create')->name('jabatan.create');
        Route::get('/dashboard/jabatan/edit/{id}', 'JabatanController@edit')->name('jabatan.edit');
        Route::post('/dashboard/jabatan/create', 'JabatanController@store')->name('jabatan.store');
        Route::put('/dashboard/jabatan/edit/{id}', 'JabatanController@update')->name('jabatan.update');
        Route::post('/dashboard/jabatan/delete/{id}', 'JabatanController@delete')->name('jabatan.delete');

        // Pegawai Superadmin
        Route::get('/dashboard/pegawai', 'PegawaiController@index')->name('pegawai');
        Route::get('/dashboard/pegawai/detail/{id}', 'PegawaiController@detail')->name('pegawai.detail');
        Route::get('/dashboard/pegawai/create', 'PegawaiController@create')->name('pegawai.create');
        Route::get('/dashboard/pegawai/edit/{id}', 'PegawaiController@edit')->name('pegawai.edit');
        Route::post('/dashboard/pegawai/create', 'PegawaiController@store')->name('pegawai.store');
        Route::put('/dashboard/pegawai/edit/{id}', 'PegawaiController@update')->name('pegawai.update');
        Route::post('/dashboard/pegawai/delete/{id}', 'PegawaiController@delete')->name('pegawai.delete');

    });
});

// Auth Route Domain
Auth::routes();
