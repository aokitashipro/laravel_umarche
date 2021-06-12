<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ComponentTestController;
use App\Http\Controllers\LifeCycleTestController;
use App\Http\Controllers\User\ItemController;
use App\Http\Controllers\User\CartController;

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
    return view('user.welcome');
});

Route::middleware('auth:users')->group(function(){
        Route::get('/', [ItemController::class, 'index'])->name('items.index');
        Route::get('show/{item}', [ItemController::class, 'show'])->name('items.show');
});

Route::prefix('cart')->middleware('auth:users')->group(function(){
        Route::get('/', [CartController::class, 'index'])->name('cart.index');
        Route::post('add', [CartController::class, 'add'])->name('cart.add');   
        Route::post('delete/{item}', [CartController::class, 'delete'])->name('cart.delete');
        Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('success', [CartController::class, 'success'])->name('cart.success');
        Route::get('cancel', [CartController::class, 'cancel'])->name('cart.cancel');
});

// Route::get('/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth:users'])->name('dashboard');

Route::get('/component-test1', [ComponentTestController::class, 'showComponent1']);
Route::get('/component-test2', [ComponentTestController::class, 'showComponent2']);
Route::get('/servicecontainertest', [LifeCycleTestController::class, 'showServiceContainerTest']);
Route::get('/serviceprovidertest', [LifeCycleTestController::class, 'showServiceProviderTest']);

require __DIR__.'/auth.php';
