<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubChartController;


Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Yessssssssssssssssss";
});

Route::get('/', function () {
    return view('auth.login');
});
Auth::routes();

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']],function (){

    Route::prefix('admin')->as('admin.')->controller(HomeController::class)
    ->group(function() {
        Route:: get('profile', 'profile')->name('profile');

    });

    Route::prefix('buyer')->as('buyer.')->controller(BuyerController::class)
    ->group(function() {
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('status', 'status')->name('status');
        Route::post('modal', 'modal')->name('modal');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('seller')->as('seller.')->controller(SellerController::class)
    ->group(function() {
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('status', 'status')->name('status');
        Route::post('modal', 'modal')->name('modal');
        Route::post('update', 'update')->name('update');
    });

    Route::prefix('category')->as('category.')->controller(CategoryController::class)
    ->group(function() {
        Route::get('index', 'index')->name('index');
        Route::post('store', 'store')->name('store');
        Route::post('status', 'status')->name('status');
        Route::post('modal', 'modal')->name('modal');
        Route::post('update', 'update')->name('update');
        Route::get('delete/{id}', 'destroy')->name('delete');
    });

    Route::prefix('store')->as('store.')->controller(StoreController::class)
    ->group(function() {
        Route::get('index', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        // Route:: post('modal', 'modal')->name('modal');
        // Route:: post('update', 'update')->name('update');
    });

    Route::prefix('product')->as('product.')->controller(ProductController::class)
    ->group(function() {
        Route::get('index', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('status', 'status')->name('status');
        Route::post('modal', 'modal')->name('modal');
        Route::get('delete/{id}', 'destroy')->name('delete');
        Route::patch('update/{id}', 'update')->name('update');
        Route::get('image_delete/{id}', 'image_delete')->name('image_delete');
    });
    Route::get('contact', [ContactController::class, 'index'])->name('contact');

    Route::get('send-mail', [MailController::class, 'index']);

});

Route::get('account/verify/{token}', [MailController::class, 'verifyAccount'])->name('user.verify');