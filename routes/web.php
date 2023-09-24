<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\teller_prossessController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    // Dashboard
    Route::controller(teller_prossessController::class)->group(function () {

        Route::get('/dashboard', "index")->name('admin.index');
        Route::get('/data', "data")->name('admin.data');
        Route::post('/getUsers', "getUsers")->name('admin.getUsers');
        Route::post('/store', "store")->name('admin.store');
        Route::post('/update', "update")->name('admin.update');
        Route::get('/edit', "edit")->name('admin.edit');
        Route::get('/delete', "destroy")->name('admin.delete');
        Route::get('/export/processes', 'processessExport')->name('admin.processessExport');

    });
});

require __DIR__ . '/auth.php';
