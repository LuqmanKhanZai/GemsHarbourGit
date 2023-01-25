<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;

// -----------------User Signup----------------------------
Route::post('signup',[ApiController::class,'signup']);
// -----------------User Login-----------------------------
Route::post('login',[ApiController::class,'login']);
// -----------------Social Login-----------------------------
Route::post('social_login',[ApiController::class,'social_login']);
// -----------------Forgot Password Send Login--------------------------------------
Route::post('forgot_password',[ApiController::class,'ForgotPassword']);
// -----------------OTP Checking--------------------------------------
Route::post('otp_checking',[ApiController::class,'OtpChecking']);
// -----------------Reset Password Check--------------------------------------
Route::post('reset_password',[ApiController::class,'ResetPassword']);

Route::get('random_product',[ProductController::class,'RandomProduct']);
// Category
Route::resource('category',CategoryController::class);

Route::get('random_category',[CategoryController::class,'random']);

Route::get('category_product/{id}',[CategoryController::class,'CategoryProduct']);

// Get All Stores
Route::get('get_store',[StoreController::class,'index']);

Route::group(['middleware' => ['auth:sanctum']],function(){

    Route::get('user',[ApiController::class,'user']);

    Route::post('update_profile',[ApiController::class,'Update_Profile']);

    Route::resource('product',ProductController::class);

    Route::post('update_product',[ProductController::class,'update_product']);

    Route::get('product_by_user',[ProductController::class,'ProductToUser']);

    Route::post('product_watch',[ProductController::class,'ProductWatch']);

    Route::post('product_wishlist',[ProductController::class,'ProductWishlist']);

    Route::post('product_feedback',[ProductController::class,'ProductFeedback']);

    Route::post('product_offer',[ProductController::class,'ProductOffer']);

    Route::get('product_watch_list',[ProductController::class,'ProductWatchList']);

    Route::get('user_order_product',[ProductController::class,'UserProductOrder']);

    Route::get('user_product_feedback',[ProductController::class,'UserProductFeedback']);

    Route::get('product_feedback_list/{id}',[ProductController::class,'ProductFeedbackList']);

    Route::post('product_search',[ProductController::class,'ProductSearch']);

    Route::post('product_bid',[ProductController::class,'ProductBid']);

    Route::get('seller_product_bid',[ProductController::class,'SellerProductBid']);

    Route::get('buyer_product_bid',[ProductController::class,'BuyerProductBid']);

    Route::post('add_store',[StoreController::class,'store']);

    Route::post('update_store',[StoreController::class,'update_store']);

   

    Route::get('total_store',[StoreController::class,'TotalStore']);

    Route::post('send_message',[ContactController::class,'store']);

    Route::get('switch_account',[ApiController::class,'SwitchAccount']);

    Route::post('support_message',[ApiController::class,'SupportMessage']);

    Route::get('get_support_message',[ApiController::class,'GetSupportMessage']);

    Route::get('user_offer',[ApiController::class,'UserOffer']);

    Route::post('order_store',[OrderController::class,'store']);

    Route::get('order_list',[OrderController::class,'OrderList']);

    Route::post('bid_status',[ProductController::class,'BidStatus']);

    Route::post('offer_status',[ProductController::class,'OfferStatus']);

    Route::get('get_seller_offer',[ProductController::class,'GetSellerOffer']);

    Route::post('buyer_block',[ProductController::class,'BuyerBlock']);

    Route::get('seller_sale',[OrderController::class,'SellerSale']);

    Route::get('get_block_buyer',[OrderController::class,'BlockBuyer']);

    Route::get('block_buyer_delete/{buyer_id}',[OrderController::class,'BlockBuyerDelete']);

    Route::post('seller_sale_status',[OrderController::class,'SellerSaleStatus']);

    Route::get('user_purchase/{buyer_id}',[OrderController::class,'UserPurcahse']);

    Route::get('seller_product_feedback',[ProductController::class,'SellerProductFeedback']);

});
