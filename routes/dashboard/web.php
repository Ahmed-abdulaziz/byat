<?php

use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllers\Dashboard\RegisterContrroller;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\NewadvController;
use App\Http\Controllers\Frontend\RegisterController as FrontendRegisterController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::middleware(['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'])->prefix(LaravelLocalization::setLocale().'/dashboard')->name('dashboard.')->group(function () {

            route::get('getlogin',[RegisterContrroller::class , 'getlogin'])->name('getlogin');
            route::post('login','RegisterContrroller@login')->name('login');
            route::post('logout','RegisterContrroller@logout')->name('logout');
            Route::get('getsubarea',[DashboardController::class,'getsubarea'])->name('dashboard.getsubarea');
            Route::get('getsubmodel',[DashboardController::class,'getsubmodel'])->name('dashboard.getsubmodel');
            Route::middleware(['auth:admin'])->group(function () {
            
            Route::get('/statistic', 'DashboardController@index')->name('statistic');
            
            //user routes
            
            Route::get('change/status/{id}/{type}','appUserController@change_status')->name('change-status');
            Route::get('app-user-requirments','appUserController@user_requirments')->name('app-user-requirments');
            Route::get('user-requirments/{id}/{type}','appUserController@change_user_requirments')->name('user-requirements');
            Route::get('approve-Balance-recovery/{id}','DashboardController@restBalance_recovery')->name('approve-Balance-recovery');
            Route::get('Auctions','AuctionsController@index')->name("Auctions");
            Route::get('winner-Auctions','AuctionsController@auction_winner')->name("auction_winner");
            Route::get('Auctions-edit/{id}','AuctionsController@edit')->name("Auction-edit");
            Route::post('Auctions-delete-img','AuctionsController@delete_image')->name("delete_image");
            Route::post('Auctions-update/{id}','AuctionsController@update')->name("auction-update");
            Route::get('winner-Auctions-details/{id}','AuctionsController@auction_winner_details')->name("auction_winner_details");
            
            Route::post('send_recharge_card/{id}','appUserController@send_recharge_card')->name("send_recharge_card");
            Route::post('add_balance_to_wallet/{id}','appUserController@add_balance_to_wallet')->name("add_balance_to_wallet");
             Route::post('add_number_adv_free/{id}','appUserController@add_number_adv_free')->name("add_number_adv_free");
            
            Route::get('advertisments-edit/{id}','advController@editadv')->name("advertisments-edit");
            Route::get('advertisment-details/{id}/{type?}','advController@show_adv')->name("advertisment-details");
            Route::post('advertisments-delete-img','advController@delete_image')->name("advertisments_delete_image");
            Route::post('advertisments-update/{id}','advController@updateadv')->name("advertisments-update");
            
             Route::get('auction-details/{id}','AuctionsController@show_auction')->name("auction-details");
            
            
             Route::get('adv-requierments-edit/{id}','advController@editadv_requierments')->name("adv-requierments-edit");
             Route::post('advertisments-update-requierments/{id}','advController@advertisments_update_requierments')->name("advertisments-update-requierments");
             
             Route::get('advertisments-create/{user_id}','advController@create')->name("advertisments-create");
             
             Route::post('delete_image_requierments','advController@delete_image_requierments')->name("delete_image_requierments");
             
            Route::post('get_filters','advController@get_filters')->name("get_filters");
            Route::post('get_child','advController@get_child')->name("get_child");
             
             Route::post('get_sub_catgories','DashboardController@get_sub_catgories')->name("get_sub_catgories");
              Route::post('check_examination_certificate','DashboardController@check_examination_certificate')->name("check_examination_certificate");
             
            Route::get('freeAuctions', 'AuctionsController@freeAuctions')->name("free-Auctions");
            Route::get('freeAuctions-edit/{id}', 'AuctionsController@freeAuctions_edit')->name("free-Auctions-edit");
            Route::post('freeAuctions-update/{id}', 'AuctionsController@freeAuctions_update')->name("free-Auctions-update");
            
            
            Route::get('deposit_amount_edit', 'dailyadvConrooller@deposit_amount')->name("deposit_amount");
            Route::get('deposit-amount-edit/{id}', 'dailyadvConrooller@deposit_amount_edit')->name("deposit_amount_edit");
            Route::post('deposit-amount-update/{id}', 'dailyadvConrooller@deposit_amount_update')->name("deposit_amount_update");
            
            Route::resource('users', 'UserController')->except(['show']);
            Route::resource('aboutapp', 'aboutappController')->except(['show']);
            Route::resource('complines', 'MessagesController')->except(['show']);
            Route::resource('usingplocy', 'usingPlocyController')->except(['show']);
            Route::resource('suggestion', 'suggestionController')->except(['show']);
            Route::resource('brands', 'brandController');
            Route::resource('commeAdv', 'CommadvController');
            Route::resource('paymentPlaces', 'PaymentPlacesController');
            Route::resource('banks', 'BanksController');
            Route::resource('payments', 'paymentsController');
            Route::resource('copons', 'CoponsController');
            Route::resource('reports', 'ReportsController');
            Route::resource('FreeAdvertisments', 'FreeAdvertismentsController');
            Route::resource('MonthlyWithdrawals', 'MonthlyWithdrawalsController');
            
            Route::get('Copon-reports','CoponsController@reports')->name('Copon-reports');
            
             Route::get('competitor-MonthlyWithdrawals/{id}','MonthlyWithdrawalsController@competitor')->name('competitor-MonthlyWithdrawals');
            
                Route::post('random-winner-MonthlyWithdrawals', 'MonthlyWithdrawalsController@random_winner')->name("random-winner-MonthlyWithdrawals");
                Route::get('winner-MonthlyWithdrawals/{id}','MonthlyWithdrawalsController@winner')->name('winner-MonthlyWithdrawals');
                
                Route::get('close-MonthlyWithdrawals/{id}','MonthlyWithdrawalsController@close')->name('close-MonthlyWithdrawals');

             
            Route::get('report_users','ReportsController@report_users')->name('report_users');
            Route::get('cash_payment_requests','appUserController@cash_payment_requests')->name('cash_payment_requests');
            
             Route::get('cash_request_status/{id}/{status}','appUserController@cash_request_status')->name('cash_request_status');

            Route::resource('catgoiries', 'catgoreisController');
            Route::get('hide-show/{catid}/{type}','catgoreisController@hide_show')->name('hide_show');
            Route::get('subcatgoiries/{id}','catgoreisController@subcat')->name('subcatgoiries');
            Route::post('subcatgoiries','catgoreisController@storesubcat')->name('storesubcat');
            Route::get('order_filters/{catid}','catgoreisController@order_filters')->name('order_filters');
            Route::get('auctions_introduction_video','AuctionsController@auctions_introduction_video')->name('auctions_introduction_video');
            Route::post('update_auctions_introduction_video','AuctionsController@update_auctions_introduction_video')->name('update_auctions_introduction_video');

            Route::post('storeorder_filters/{catid}','catgoreisController@storeorder_filters')->name('storeorder_filters');
            Route::resource('cartype', 'carTypeController');
            Route::resource('appuser', 'appUserController');
            Route::resource('advertismnets', 'advController');
            Route::resource('updateprofile', 'updateProfile');
            Route::get('makespcial/{id}','advController@makespcial')->name('makespcial');
            Route::get('makespcialx/{id}','advController@makespcialx')->name('makespcialx');
            Route::get('statsics/{type}','StatasticConroller@show')->name('statsics');
            Route::resource('notificationText', 'NotficationtextController');
            Route::resource('dailuadvcount', 'dailyadvConrooller');
            Route::resource('advvalue', 'advValueConrooller');
            Route::resource('afadvstring', 'afadvstring');
            Route::get('afauctionstring','AuctionsController@afterstring')->name('afauctionstring');
            Route::get('afauctionstring-edit/{id}','AuctionsController@afterstringedit')->name('afterstringedit');
            Route::post('afauctionstring-update/{id}','AuctionsController@afterstringupdate')->name('afterstringupdate');
            Route::resource('banar', 'banarController');
            Route::resource('packages', 'packagesContollerController');
            Route::post('sendnotifaction','sendGenralNotfications@sendnotifaction')->name('sendnotifaction');
            Route::get('getnotifview','sendGenralNotfications@index')->name('getnotifview');
            Route::resource('cites', 'citesController')->except(['show']);
            Route::resource('area','areaController');
            Route::resource('callus', 'callusContoller')->except(['show']);
            Route::resource('userpays', 'UserPaysController')->except(['show']);
            Route::resource('usersub', 'UserSubController')->except(['show']);
            Route::get('subscriptions', 'packagesContollerController@subscriptions')->name("subscriptions");
            Route::get('subscription-reports/{type}', 'packagesContollerController@subscriptions_reports')->name("subscriptions-reports");
            Route::post('active-subscriptions/{id}', 'packagesContollerController@active_subscriptions')->name("active_subscriptions");
            Route::get('Balance-recovery', 'DashboardController@showBalance_recovery')->name("Balance_recovery");
            Route::get('codes', 'CodesController@index')->name("codes");
            Route::get('add-codes', 'CodesController@create')->name("add-codes");
            Route::post('add-codes', 'CodesController@store')->name("store-codes");
            Route::post('delete-codes/{id}', 'CodesController@destroy')->name("delete-codes");
            
            Route::get('Balance-list', 'DashboardController@Balance_list')->name("Balance_list");
            Route::get('wallet-reports', 'DashboardController@wallet_reports')->name("wallet_reports");
            Route::get('adv-updated', 'advController@update_requirements')->name("update_adv_requirements");
            Route::get('adv-updated-status/{id}/{status}', 'advController@update_requirements_change_status')->name("update_requirements_change_status");
            Route::get('adv-active/{id}/{status}', 'advController@change_status')->name("adv-active");
            Route::get('Auctions-change-status/{id}/{status}', 'AuctionsController@change_status')->name("Auctions-change-status");
            
            Route::get('filters/{cat_id}', 'catgoreisController@filters')->name("filters");
            Route::get('add-filters/{cat_id}', 'catgoreisController@add_filters')->name("add_filters");
            Route::post('store-filters/{cat_id}', 'catgoreisController@store_filters')->name("store_filters");
            Route::get('edit-filters/{id}', 'catgoreisController@edit_filters')->name("edit_filters");
            
            Route::post('update-componant-filter', 'catgoreisController@update_componant_filter')->name("update_componant_filter");
            Route::post('delete-componant-filter', 'catgoreisController@delete_componant_filter')->name("delete_componant_filter");
            Route::post('update-componant-image', 'catgoreisController@update_componant_image')->name("update_componant_image");
            
            Route::post('update-filters/{cat_id}', 'catgoreisController@update_filters')->name("update_filters");
            
            Route::post('delete-filters/{id}', 'catgoreisController@destroy_filters')->name("destroy_filters");

             Route::post('GetCategoryItems','catgoreisController@GetCategoryItems')->name('GetCategoryItems');
             
             
            Route::get('order_banners', 'banarController@order_banners')->name("order_banners");
            Route::post('storeorder_banners', 'banarController@storeorder_banners')->name("storeorder_banners");
 
            
            Route::get('ad_duration', 'advController@ad_duration')->name("ad_duration");
            Route::post('ad_duration_update', 'advController@ad_duration_update')->name("ad_duration_update");
            
            Route::get('auction_duration', 'AuctionsController@auction_duration')->name("auction_duration");
            Route::post('auction_duration_update', 'AuctionsController@auction_duration_update')->name("auction_duration_update");
            
            Route::get('maximum_auction_duration', 'AuctionsController@maximum_auction_duration')->name("maximum_auction_duration");
            Route::post('maximum_auction_duration_update', 'AuctionsController@maximum_auction_duration_update')->name("maximum_auction_duration_update");

        });//end of dashboard routes
    });


