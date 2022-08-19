<?php
use App\Http\Controllers\AdminController;
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

Route::get("/ticketdashboard",[AdminController::class,'dashboardData']);
Route::get("/openticketdashboard",[AdminController::class,'opendashboardData']);
Route::get("/closeticketdashboard",[AdminController::class,'closedashboardData']);

Route::get("/get/{id}",[AdminController::class,'getfiledata'])->name('getfiledata');