<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Products;
use App\Http\Livewire\Coins;
use App\Http\Livewire\Pos;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Permisos;
use App\Http\Livewire\Asignar;
use App\Http\Livewire\Users;
use App\Http\Livewire\Cashout;
use App\Http\Livewire\Reports;
use App\Http\Controllers\ExportController;
use App\Http\Livewire\Dash;
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
    return view('auth/login');
});

Auth::routes();
Route::get('/home', Dash::class);

Route::middleware(['auth'])->group(function () {

Route::group(['middleware' => ['role:Admin']], function () {

Route::get('categories', Categories::class);
Route::get('products', Products::class);
Route::get('coins', Coins::class);
Route::get('pos', Pos::class);
Route::get('roles', Roles::class);
Route::get('permisos', Permisos::class);
Route::get('asignar', Asignar::class);
Route::get('users', Users::class);
Route::get('cashout', Cashout::class);
Route::get('reports', Reports::class);
});

Route::get('categories', Categories::class);
Route::get('products', Products::class);
Route::get('pos', Pos::class);
Route::get('cashout', Cashout::class);
Route::get('reports', Reports::class);


});

//reportes PDF
Route::get('report/pdf/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reportPDF']);
Route::get('report/pdf/{user}/{type}', [ExportController::class, 'reportPDF']);
Route::get('report/pdf', [ExportController::class, 'invPDF']);
Route::get('report/pdf/{u}/{f1}/{f2}', [ExportController::class, 'cierrePDF']);
Route::get('report/pdf/{id}', [ExportController::class, 'proformaPDF']);
//reportes excel
Route::get('report/excel/{user}/{type}/{f1}/{f2}', [ExportController::class, 'reporteExcel']);
Route::get('report/excel/{user}/{type}', [ExportController::class, 'reporteExcel']);



//
/*
//Route::group(['middleware' => ['role:Admin']], function () {
*/
