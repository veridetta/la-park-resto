<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\manager\DashboardController;
use App\Http\Controllers\kasir\DashboardController as KasirDashboardController;
use App\Http\Controllers\owner\DashboardController as OwnerDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
//generate password
Route::get('/generate-password', function () {
    return Hash::make('password');
});

Route::get('/dashboard', function () {
    //alihkan sesuai role
    if (Auth::user()->role == 'manager') {
        return redirect()->route('manager.dashboard');
    } elseif (Auth::user()->role == 'owner') {
        return redirect()->route('owner.dashboard');
    } elseif (Auth::user()->role == 'kasir') {
        return redirect()->route('kasir.dashboard');
    } else {
        return redirect()->route('login');
    }
})->middleware(['auth'])->name('dashboard');

Route::get('/profile', [Controller::class, 'profile'])->middleware(['auth'])->name('profile');

Route::post('/profile/{id}', [Controller::class, 'updateProfile'])->middleware(['auth'])->name('updateProfile');

Route::get('/checkRole', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }else{
        return redirect()->route('login');
    }
    if (Auth::user()->role == 'manager') {
        return redirect()->route('manager.dashboard');
    } elseif (Auth::user()->role == 'owner') {
        return redirect()->route('owner.dashboard');
    } elseif (Auth::user()->role == 'kasir') {
        return redirect()->route('kasir.dashboard');
    } else {
        return redirect()->route('login');
    }
})->name('checkRole');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return view('guest.home');
    })->name('home');

});

Route::middleware('checkRole:manager')->group(function () {
    //dashboard dari dashboard controller
    Route::get('/manager/dashboard', [DashboardController::class, 'index'])->name('manager.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('manager')->name('manager.')->group(function () {
        Route::get('/notification', [Controller::class, 'notification'])->name('notification');
        Route::resource('menu', \App\Http\Controllers\manager\MenuController::class);
        Route::prefix('menu')->name('menu.')->group(function () {
            Route::get('/{id}/viewRequirement', [\App\Http\Controllers\manager\MenuController::class, 'viewRequirement'])->name('viewRequirement');
            //add requirement
            Route::get('/{id}/addRequirement', [\App\Http\Controllers\manager\MenuController::class, 'addRequirement'])->name('addRequirement');
            Route::post('/{id}/requirement', [\App\Http\Controllers\manager\MenuController::class, 'storeRequirement'])->name('storeRequirement');
            Route::get('/deleteRequirement/{requirement_id}', [\App\Http\Controllers\manager\MenuController::class, 'destroyRequirement'])->name('deleteRequirement');
        });
        Route::resource('raw_material', \App\Http\Controllers\manager\RawMaterialController::class);
        //group route prefix raw_material
        Route::prefix('raw_material')->name('raw_material.')->group(function () {
            Route::get('/{id}/addStock', [\App\Http\Controllers\manager\RawMaterialController::class, 'addStock'])->name('addStock');
            Route::post('/{id}/stock', [\App\Http\Controllers\manager\RawMaterialController::class, 'storeStock'])->name('storeStock');
            Route::get('/{id}/history', [\App\Http\Controllers\manager\RawMaterialController::class, 'history'])->name('history');
        });
        Route::resource('user', \App\Http\Controllers\manager\UserController::class);
        Route::resource('cash', \App\Http\Controllers\manager\CashController::class);
        Route::post('/cash/filter', [\App\Http\Controllers\manager\CashController::class, 'filter'])->name('cash.filter');
        Route::get('/cash/print', [\App\Http\Controllers\manager\CashController::class, 'print'])->name('cash.print');
        Route::get('/report', [\App\Http\Controllers\manager\ReportController::class, 'index'])->name('report.index');
        Route::post('/report/filter', [\App\Http\Controllers\manager\ReportController::class, 'filter'])->name('report.filter');
        Route::get('/report/print', [\App\Http\Controllers\manager\ReportController::class, 'print'])->name('report.print');
    });

});
Route::middleware('checkRole:owner')->group(function () {
    Route::get('/owner/dashboard', [OwnerDashboardController::class, 'index'])->name('owner.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('owner')->name('owner.')->group(function () {
        Route::get('/prediction', [OwnerDashboardController::class, 'prediction'])->name('prediction');
        Route::get('/prediction/sales', [OwnerDashboardController::class, 'sales_prediction'])->name('prediction.sales');
        Route::post('/prediction/sales/filter', [OwnerDashboardController::class, 'sales_prediction_filter'])->name('prediction.sales.filter');
        Route::post('/prediction/sales/start/{menu_id}', [OwnerDashboardController::class, 'start_sales'])->name('prediction.sales.start');

        Route::get('/prediction/in', [OwnerDashboardController::class, 'in_prediction'])->name('prediction.in');
        Route::post('/prediction/in/filter', [OwnerDashboardController::class, 'in_prediction_filter'])->name('prediction.in.filter');
        Route::post('/prediction/in/start/{menu_id}', [OwnerDashboardController::class, 'start_in'])->name('prediction.in.start');

        Route::get('/prediction/out', [OwnerDashboardController::class, 'out_prediction'])->name('prediction.out');
        Route::post('/prediction/out/filter', [OwnerDashboardController::class, 'out_prediction_filter'])->name('prediction.out.filter');
        Route::post('/prediction/out/start/{menu_id}', [OwnerDashboardController::class, 'start_out'])->name('prediction.out.start');


        Route::get('/prediction/profit', [OwnerDashboardController::class, 'profit_prediction'])->name('prediction.profit');
        Route::post('/prediction/profit/filter', [OwnerDashboardController::class, 'profit_prediction_filter'])->name('prediction.profit.filter');
        Route::post('/prediction/profit/start', [OwnerDashboardController::class, 'start_profit'])->name('prediction.profit.start');
    });

});

Route::middleware('checkRole:kasir')->group(function () {
    Route::get('/kasir/dashboard', [KasirDashboardController::class, 'index'])->name('kasir.dashboard');
    //masukkan ke dalam group route prefix admin
    Route::prefix('kasir')->name('kasir.')->group(function () {
        Route::resource('sales', \App\Http\Controllers\kasir\SalesController::class);
        Route::post('/sales/filter', [\App\Http\Controllers\kasir\SalesController::class, 'filter'])->name('sales.filter');
        Route::get('/sales/print/{id}', [\App\Http\Controllers\kasir\SalesController::class, 'print'])->name('sales.print');
        Route::post('/checkStock', [\App\Http\Controllers\kasir\SalesController::class, 'checkStock'])->name('sales.checkStock');
    });

});


//buat akun kasir, manager dan owner
Route::get('/buat', function () {
    //fungsi insert bulk kasir, manager, dan owner
    $data = [
        [
            'name' => 'manager',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ],
        [
            'name' => 'owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ],
        [
            'name' => 'kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'kasir',
        ],
    ];
    //insert bulk menggunakan eloquent
    \App\Models\User::insert($data);
    return 'berhasil';

})->name('buat');

require __DIR__ . '/auth.php';
