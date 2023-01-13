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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return redirect('/login');
})->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('sites', 'SitesController');
/**
 * Export site & download route
 */
Route::get('sites_export', [\App\Http\Controllers\SitesController::class, 'export'])->name('sites.export');

/**
 * AirTable routes
 */
Route::get('airtable/index/{id}', [\App\Http\Controllers\AirTableController::class, 'index'])->name('airtable.index');
