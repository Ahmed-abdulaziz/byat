<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::middleware('cheaklang')->group(function (){
    /////appSettings
    Route::post('signup','Api\UserAuth@signup');
   
    Route::post('login','Api\UserAuth@login');
     Route::post('login_socail','Api\UserAuth@login_socail');
    Route::post('socail','Api\UserAuth@socail');
    Route::get('appSettings','Api\appSettingsApiController@index')->name('appSettings');
    
    Route::get('sendmesagesms','Api\appSettingsApiController@sendsms')->name('sendsms');
    
  
      
    Route::post('getCode','Api\UserAuth@getCode');
    Route::post('checkhone','Api\UserAuth@checkphone');
    Route::post('checkcode','Api\UserAuth@checkcode');
    Route::post('cheackPhonnumber','Api\UserAuth@checkphone');
    Route::post('sendmessage','Api\messagesController@store')->name('sendmessage');
    Route::get('adv_home','Api\HomeController@index');
    Route::get('auction_home','Api\HomeController@index_auction');
    Route::post('commercialadds','Api\HomeController@commercialadds');
    Route::post('singlecommercialadds','Api\HomeController@singlecommercialadds');
    Route::post('search','Api\AdvertimnetsController@search');
    Route::get('cities','Api\DynamicdataController@cities');
    Route::post('areas','Api\DynamicdataController@areas');
     Route::get('areas','Api\DynamicdataController@allareas');
    Route::get('categories','Api\DynamicdataController@categories');
    Route::get('pymentPlace','Api\DynamicdataController@pymentPlace');
    Route::post('subCatgoires','Api\DynamicdataController@subCatgoires');
    Route::post('getBrands','Api\DynamicdataController@getBrands');
    Route::post('packages','Api\DynamicdataController@packages');
    Route::get('banks','Api\DynamicdataController@banks');
    Route::post('getModels','Api\DynamicdataController@getcarModels');
    Route::get('realstateTypes','Api\DynamicdataController@realstateTypes');
    Route::get('realstateperiod','Api\DynamicdataController@realstateperiod');
    Route::post('single_add','Api\AdvertimnetsController@singleAdv');
    Route::post('getRecomended','Api\HomescreenController@getRecomended');
    Route::post('latest','Api\HomescreenController@getlatest');
    Route::post('homescreen','Api\HomescreenController@homescreen');
    Route::post('rearange','Api\FilterAndRearange@rearange');
    Route::post('filter','Api\FilterAndRearange@filter');
    Route::post('getadds','Api\FilterAndRearange@getadds');
    Route::post('catgoryadv','Api\FilterAndRearange@catgoryadv');
    Route::post('sendmessage','Api\messagesController@store');
    Route::post('restpass','Api\UserAuth@restpassword');
    Route::get('getgifts','Api\HomeController@getgifts');
    
    
   Route::post('testnoti','Api\AuctionsController@textnoti');
   
   Route::post('sub_Catgoires','Api\DynamicdataController@subCatgoires_new');
   
    Route::post('app-search','Api\DynamicdataController@search');
    
    Route::post('show/auction','Api\AuctionsController@show');
    
    Route::post('visitor','Api\DynamicdataController@visitor');
      
    Route::get('show/all/auctions','Api\AuctionsController@showall');
    Route::post('show/category/all/auctions','Api\AuctionsController@showall_by_cat');
    
    Route::post('show/category/all/advertimnets','Api\AdvertimnetsController@showall_by_cat');
    Route::post('show/advertimnets','Api\AdvertimnetsController@show');
    Route::get('show/all/advertimnets','Api\AdvertimnetsController@showall');
    
    Route::get('banners','Api\DynamicdataController@getbanners');
    Route::get('deposit-amount','Api\appSettingsApiController@deposit_amount');
    
    Route::post('filter-by-area/Advertimnets','Api\AdvertimnetsController@filter_by_area');
    
    Route::post('filter-by-area/Auctions','Api\AuctionsController@filter_by_area');
    
    Route::post('checktoken','Api\UserAuth@checktoken');
    
    Route::get('filters/{id}/{type?}','Api\DynamicdataController@filters');
    Route::get('filter_details/{id}','Api\DynamicdataController@filter_details');
    Route::get('filter_child/{filter_id}/{componant}','Api\DynamicdataController@filter_child');
    
    
    Route::get('examination_image_catgorie/{id}','Api\DynamicdataController@examination_image_catgorie');
    Route::get('reports/{section}','Api\DynamicdataController@reports');
    
    Route::get('read_notification/{id}','Api\AppUsersController@read_notifications');
    
    Route::get('test_corn','Api\AuctionsController@test_corn');
    
    Route::get('last_auction_user/{id}','Api\AuctionsController@last_auction_user');
    
    Route::post('pay_auction','Api\AuctionsController@pay_auction');
    
    
    Route::get('payment','Api\paymentController@payment')->name('api.payment');
    Route::get('paymentpackage','Api\paymentController@paymentpackage')->name('api.paymentpackage');
    Route::get('payment_error','Api\paymentController@payment_error')->name('api.payment_error');

});
Route::middleware(['cheaklang','app_users:app_users'])->group(function (){
    
    Route::post('deleteuser','Api\AppUsersController@deleteuser');
    Route::post('create/auctions','Api\AuctionsController@store');
    Route::get('showuser/auctions/{id}','Api\AuctionsController@show_user_auctions');
    Route::get('auction-user/{id}','Api\AuctionsController@get_all_user_auctions');
    Route::post('auction-user','Api\AuctionsController@user_auction');
    Route::post('check_payment_wallet','Api\AuctionsController@check_payment_wallet');
    
    Route::post('my-notifications','Api\AppUsersController@my_notifications');
    Route::post('delete-notification','Api\AppUsersController@delete_notification');
    Route::post('wallet-amount-users-wallets','Api\AppUsersController@wallet_amount_users_wallets');
    Route::post('charge-wallet','Api\AppUsersController@charge_wallet');
    Route::post('balance-recovery','Api\AppUsersController@balance_recovery');
    Route::post('deposit-payment','Api\AuctionsController@depoist_payment');
    Route::get('showuser/advertimnets/{id}','Api\AdvertimnetsController@show_user_advertimnets');
    
    Route::get('check-user-count-adv/{id}','Api\AdvertimnetsController@check_user_count_advertimnets');
    Route::get('check-user-count-auctions/{id}','Api\AuctionsController@check_user_count_auctions');
    Route::post('packages_subscriptions','Api\DynamicdataController@packages_subscriptions');
    Route::post('update/advertimnets','Api\AdvertimnetsController@update');
    
    Route::post('change-user-name','Api\AppUsersController@change_user_name');
    Route::post('change-email','Api\AppUsersController@change_email');
    Route::post('change-password','Api\UserAuth@change_password');
    Route::post('updatephone','Api\UserAuth@updatephone');
    Route::post('updateimage','Api\UserAuth@updateimage');
    Route::post('fcmsave','Api\UserAuth@savefsmtoken');
    Route::get('logout','Api\UserAuth@logout');
    Route::post('newAdd','Api\AdvertimnetsController@create');
    Route::post('updateAdd','Api\AdvertimnetsController@update');
    Route::post('banadv','Api\AdvertimnetsController@banadv');
    Route::post('addremovefav','Api\AdvertimnetsController@addtoremovefav');
    Route::post('addImages','Api\AdvertimnetsController@addImages');
    
    Route::get('favorites/{type}','Api\DynamicdataController@favorites');
    Route::post('favorite_action','Api\DynamicdataController@favorite_action');
    
    Route::post('deleteimage','Api\AdvertimnetsController@deleteimage');
    Route::delete('deleteadv/{id}','Api\AdvertimnetsController@deleteadv');
    Route::post('banusers','Api\AppUsersController@banusers');
    Route::post('updateProfile','Api\AppUsersController@updateProfile');
    Route::get('myadv','Api\AppUsersController@myadv');
    Route::get('myfav','Api\AppUsersController@myfav');
    Route::post('updateAdv','Api\AdvertimnetsController@update');
    Route::post('sendpaymentImag','Api\AppUsersController@payment');
    Route::post('updateProfile','Api\UpdateConteoller@updatall');
    Route::post('userProfile','Api\AppUsersController@userProfile');
    
    
    Route::get('user_profile/{id}','Api\AppUsersController@user_profile');
    
    
    Route::post('filtration','Api\AdvertimnetsController@filtration');
    Route::post('auctions_filtration','Api\AuctionsController@filtration');
    
    Route::get('repost/{id}','Api\AdvertimnetsController@repost');
    
    Route::get('repost-auction/{id}','Api\AuctionsController@repost');
    
    Route::post('copons','Api\CoponsController@index');
    
    Route::post('make-report','Api\DynamicdataController@makereport');
    
    Route::get('mybills','Api\AppUsersController@mybills');
    
    Route::post('paid_to_show_last_bid','Api\AuctionsController@paid_to_show_last_user_auction');

});
