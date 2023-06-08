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



use App\Http\Controllers\Dashboard\RegisterContrroller;
use App\Http\Controllers\Frontend\AdvController;
use App\Http\Controllers\Frontend\AppsettingController;
use App\Http\Controllers\Frontend\AppuserController;
use App\Http\Controllers\Frontend\FrontHomeController;
use App\Http\Controllers\Frontend\loginController;
use App\Http\Controllers\Frontend\RegisterController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

//
// Route::get('/clear-cache', function() {
// 	 $exitCode = Artisan::call('config:cache');
//     $exitCode = Artisan::call('cache:clear');
//     $exitCode = Artisan::call('view:clear');
//     $exitCode = Artisan::call('route:cache');

// });




Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        route::get('login',[RegisterContrroller::class,'getlogin'])->name('login');

//        route::get('aboutapp',[AppsettingController::class,'aboutapp'])->name('aboutapp');
//        route::get('usingpolicy',[AppsettingController::class,'usingpolicy'])->name('usingpolicy');
//        route::get('callus',[AppsettingController::class,'callus'])->name('callus');
//        route::post('sendmessage',[AppsettingController::class,'sendmessage'])->name('sendmessage');
//        route::get('signup',[RegisterController::class,'index'])->name('signup');
//        route::post('newuser',[RegisterController::class,'newuser'])->name('newuser');
//        route::post('validatef',[loginController::class,'validatef'])->name('validatef');
        route::get('/',[FrontHomeController::class,'index'])->name('home');
        route::get('/privacy',[FrontHomeController::class,'privacy'])->name('privacy');
//        route::get('allcat',[FrontHomeController::class,'allcategories'])->name('allcat');
//        route::get('getcat/{id}',[FrontHomeController::class,'getcat'])->name('getcat');
//        route::get('getsubcat/{id}',[FrontHomeController::class,'getsubcat'])->name('getsubcat');
//        route::get('alladdlater',[FrontHomeController::class,'alladdlater'])->name('alladdlater');
//        route::get('allbrandadv/{id}',[FrontHomeController::class,'allbrandadv'])->name('allbrandadv');
//        route::get('search',[FrontHomeController::class,'search'])->name('search');
//        route::get('singleadv/{id}',[FrontHomeController::class,'singleadv'])->name('singleadv');
//        route::get('commericaldds',[FrontHomeController::class,'commericaldds'])->name('commericaldds');
//        route::get('getcommericaldds/{id}',[FrontHomeController::class,'getcommericaldds'])->name('getcommericaldds');
//        Route::middleware(['auth:customer'])->group(function () {
//            route::get('profile',[AppuserController::class,'profile'])->name('profile');
//            route::get('myads',[AppuserController::class,'myads'])->name('myads');
//            route::get('myfav',[AppuserController::class,'myfav'])->name('myfav');
//            route::post('userUpdateProfile',[AppuserController::class,'userUpdateProfile'])->name('userUpdateProfile');
//            route::get('sigout',[loginController::class,'sigout'])->name('sigout');
//            route::get('addindex/{id}',[AdvController::class,'index'])->name('addindex');
//            route::post('storeadv',[AdvController::class,'store'])->name('storeadv');
//            route::get('addRemoveFav/{id}',[AdvController::class,'addRemoveFav'])->name('addRemoveFav');
//
//
//        });
    });
