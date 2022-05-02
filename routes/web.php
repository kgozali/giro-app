<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ReportController;

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

Route::get('/', [MainController::class, 'welcome'])->middleware('auth.basic')->name("welcome");

Route::prefix('giro')->group(function() {
    Route::get('/', [MainController::class, 'index'])->middleware('auth.basic')->name("giro_index");

    Route::get('/new', [TransactionsController::class, 'new'])->middleware('auth.basic')->name("new_giro");
    
    Route::get('/view/{id}', [TransactionsController::class, 'view'])->middleware('auth.basic')->name("view_giro");
    
    Route::post('/submit', [TransactionsController::class, 'submit'])->middleware('auth.basic')->name("submit_giro");
    
    Route::post('/submit/edit/{id}', [TransactionsController::class, 'edit'])->middleware('auth.basic')->name("edit_giro");
    
    Route::get('/monthly', [ReportController::class, 'getMonthlyReport'])->middleware('auth.basic')->name("select_monthly_report_giro");
    
    Route::get('/periodic', [ReportController::class, 'getPeriodicReport'])->middleware('auth.basic')->name("select_periodic_report_giro");
    
    Route::get('/periodic/month', [ReportController::class, 'getMonthlyPeriodicReport'])->middleware('auth.basic')->name("select_monthly_periodic_report_giro");
    
    Route::get('/book', [ReportController::class, 'getGiroBookReport'])->middleware('auth.basic')->name("select_giro_book_report_giro");
});
