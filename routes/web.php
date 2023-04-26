<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

//------------------
//FRONTAND
//------------------

//------------------
//Partner part
//------------------
Route::prefix('')->middleware('cookieUid')->group(function () {
    Route::get('partner-conditions', 'Partner\PartnerController@partnerСonditions')->name('partner-conditions');
    Route::get('partner-register-form', 'Partner\PartnerController@registerForm')->name('partner-register-form');
    Route::get('partner-login-form', 'Partner\PartnerController@loginForm')->name('partner-login-form');
    Route::post('partner-register-create', 'Partner\PartnerController@create')->name('partner-register-create');
    Route::post('partner-login', 'Partner\PartnerController@login')->name('partner-login');
    Route::post('partner-logout', 'Partner\PartnerController@logout')->name('partner-logout');

    //Kabinet
    Route::prefix('')->middleware('partner')->group(function () {
        Route::get('partner', 'Partner\PartnerController@index')->name('partner');
        Route::post('change-partner-info', 'Partner\PartnerController@changePartnerInfo')->name('change-partner-info');
        Route::get('partner-cash-out-form', 'Partner\PartnerController@partnerCashOutForm')->name('partner-cash-out-form');
        Route::post('partner-cash-out-form-request', 'Partner\PartnerController@partnerCashOutFormRequest')->name('partner-cash-out-form-request');
    });
});
//------------------
//Partner part
//------------------

//-----------------------
//Site public part
//-----------------------
Route::prefix('')->middleware('cookieUid')->middleware('cookieReferal')->group(function () {

    Route::get('/', 'HomeController@index')->name('home');
    Route::get('contacts', 'HomeController@contacts')->name('contacts');
    Route::get('category/{alias}', 'CategoryController@index')->name('category');
    Route::get('brand/{alias}', 'BrandController@index')->name('brand');
    Route::get('product/{alias}', 'ProductController@index')->name('product');

    //Buy
    Route::get('making-checkout/{id}', 'ProductCheckoutController@making')->name('making-checkout');
    Route::post('order-processing', 'ProductCheckoutController@orderProcessing')->name('order-processing');
    // Route::get('checkout/{id}', 'ProductCheckoutController@checkout')->name('checkout');

    //Catalog
    Route::get('catalog', 'CatalogController@index')->name('catalog');
    Route::get('catalog/brand/{alias}', 'CatalogController@brand')->name('brand');
    Route::get('catalog/category/{alias}', 'CatalogController@category')->name('category');

    //Likes
    Route::post('like', 'LikesController@like')->name('like');
    Route::get('like-count', 'LikesController@getCountLikesForPerson')->name('like-count');
    Route::get('wishlist', 'LikesController@wishlist')->name('wishlist');

    //Blog
    Route::get('blog-post/{alias}', 'Blog\BlogController@post')->name('blog-post');
    Route::get('blog-category/{alias}', 'Blog\BlogController@category')->name('blog-category');
    Route::get('blog', 'Blog\BlogController@index')->name('blog');

    //Cart
    Route::post('cart', 'CartController@cart')->name('cart');
    Route::get('cart-count', 'CartController@getCountCartForPerson')->name('cart-count');
    Route::get('cartlist', 'CartController@cartlist')->name('cartlist');

    //Chat
    Route::post('modal-chat-message', 'ChatController@modalChatMessage')->name('modal-chat-message');
    Route::get('chats', 'ChatController@chats')->name('chats')->middleware('auth');
    Route::get('chat-room/{id}', 'ChatController@chatRoom')->name('chat-room')->middleware('auth');
    Route::match(['post'],'past-message', 'ChatController@createMessage')->name('past-message')->middleware('auth');
    Route::post('update-messages', 'ChatController@updateMessages')->name('update-messages')->middleware('auth');

});
//-----------------------
//Site public part
//-----------------------


//------------------
//ADMINPART
//------------------
Route::prefix('admin')->middleware('auth')->middleware('admin')->group(function () {


    Route::get('/', 'Admin\HomeController@index')->name('admin-home');

    //ExportFileProduct
    Route::prefix('export-file-product')->group(function () {
        Route::get('index', 'Admin\ExportFileProduct@index')->name('admin-export-file-product-index');
        Route::match(['get', 'post'],'create', 'Admin\ExportFileProduct@create')->name('admin-export-file-product-create');
        Route::match(['get', 'post'],'update/{id}', 'Admin\ExportFileProduct@update')->name('admin-export-file-product-update');
        Route::match(['post'],'checkbox-action', 'Admin\ExportFileProduct@checkboxAction')->name('admin-export-file-product-checkbox-action');
        Route::post('delete/{id}', 'Admin\ExportFileProduct@delete')->name('admin-export-file-product-delete');
    });

    // category
    Route::prefix('category')->group(function () {
        
        Route::get('index', 'Admin\CategoryController@index')->name('admin-category-index');
        Route::match(['get', 'post'],'create', 'Admin\CategoryController@create')->name('admin-category-create');
        Route::match(['get', 'post'],'update/{id}', 'Admin\CategoryController@update')->name('admin-category-update');
        Route::post('delete/{id}', 'Admin\CategoryController@delete')->name('admin-category-delete');
    });

    // brand
    Route::prefix('brand')->group(function () {
        
        Route::get('index', 'Admin\BrandController@index')->name('admin-brand-index');
        Route::match(['get', 'post'], 'create', 'Admin\BrandController@create')->name('admin-brand-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\BrandController@update')->name('admin-brand-update');
        Route::post('delete/{id}', 'Admin\BrandController@delete')->name('admin-brand-delete');
    });

    // orders
    Route::prefix('orders')->group(function () {
        
            Route::get('index', 'Admin\OrderController@index')->name('admin-orders-index');
            Route::post('index', 'Admin\OrderController@index')->name('admin-orders-index-search');
            Route::post('checkbox-action', 'Admin\OrderController@checkboxAction')->name('admin-orders-checkbox-action');
            Route::match(['get', 'post'], 'create', 'Admin\OrderController@create')->name('admin-orders-create');
            Route::match(['get', 'post'], 'update/{id}', 'Admin\OrderController@update')->name('admin-orders-update');
            Route::post('delete/{id}', 'Admin\OrderController@delete')->name('admin-orders-delete');
    });

    // castomers
    // Route::prefix('castomers')->group(function () {
        
    //     Route::get('index', 'Admin\CastomerController@index')->name('admin-orders-index');
    //     Route::post('index', 'Admin\CastomerController@index')->name('admin-orders-index-search');
    //     Route::post('checkbox-action', 'Admin\CastomerController@checkboxAction')->name('admin-orders-checkbox-action');
    //     // Route::match(['get', 'post'], 'create', 'Admin\CastomerController@create')->name('admin-orders-create');
    //     // Route::match(['get', 'post'], 'update/{id}', 'Admin\CastomerController@update')->name('admin-orders-update');
    //     Route::post('delete/{id}', 'Admin\CastomerController@delete')->name('admin-orders-delete');
    // });

    // partners
    Route::prefix('partners')->group(function () {
        
        Route::get('index', 'Admin\PartnerController@index')->name('admin-partners-index');
        Route::get('view/{id}', 'Admin\PartnerController@index')->name('admin-partners-view');//инфо по конкретному партнеру
        Route::match(['get', 'post'], 'create', 'Admin\PartnerController@create')->name('admin-partners-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\PartnerController@update')->name('admin-partners-update');
        Route::post('delete/{id}', 'Admin\PartnerController@delete')->name('admin-partners-delete');
        //Ajax
        Route::get('get-partner-active-orders/{partnerId}', 'Admin\PartnerController@getPartnerActiveOrders')->name('get-partner-active-orders');
        Route::get('get-partner-all-orders/{partnerId}', 'Admin\PartnerController@getPartnerAllOrders')->name('get-partner-all-orders');
        Route::get('get-partner-transactions-info/{partnerId}', 'Admin\PartnerController@getPartnerTransactionsInfo')->name('get-partner-transactions-info');
        Route::get('request-withdraw-info/{partnerId}/{status}', 'Admin\PartnerController@getRequestWithdrawInfo')->name('request-withdraw-info');
        Route::match(['get', 'post'], 'update-request-withdraw/{id}', 'Admin\PartnerController@updateRequestWithdraw')->name('update-request-withdraw');
    });

    // shipping-methods
    Route::prefix('shipping-methods')->group(function () {
        
        Route::get('index', 'Admin\ShippingMethodsController@index')->name('admin-shipping-methods-index');
        Route::match(['get', 'post'], 'create', 'Admin\ShippingMethodsController@create')->name('admin-shipping-methods-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\ShippingMethodsController@update')->name('admin-shipping-methods-update');
        Route::post('delete/{id}', 'Admin\ShippingMethodsController@delete')->name('admin-shipping-methods-delete');
    });
    
    // contacts
    Route::prefix('contacts')->group(function () {
        
        Route::get('index', 'Admin\ContactsController@index')->name('admin-contacts-index');
        Route::match(['get', 'post'], 'create', 'Admin\ContactsController@create')->name('admin-contacts-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\ContactsController@update')->name('admin-contacts-update');
        Route::post('delete/{id}', 'Admin\ContactsController@delete')->name('admin-contacts-delete');
    });

    // footer-menu
    Route::prefix('footer-menu')->group(function () {
        
        Route::get('index', 'Admin\FooterMenuController@index')->name('admin-footer-menu-index');
        Route::match(['get', 'post'], 'create', 'Admin\FooterMenuController@create')->name('admin-footer-menu-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\FooterMenuController@update')->name('admin-footer-menu-update');
        Route::post('delete/{id}', 'Admin\FooterMenuController@delete')->name('admin-footer-menu-delete');
    });

    // header-menu
    Route::prefix('header-menu')->group(function () {
        
        Route::get('index', 'Admin\HeaderMenuController@index')->name('admin-header-menu-index');
        Route::match(['get', 'post'], 'create', 'Admin\HeaderMenuController@create')->name('admin-header-menu-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\HeaderMenuController@update')->name('admin-header-menu-update');
        Route::post('delete/{id}', 'Admin\HeaderMenuController@delete')->name('admin-header-menu-delete');
    });

    // product-owner
    Route::prefix('product-owner')->group(function () {
        
        Route::get('index', 'Admin\ProductOwnersController@index')->name('admin-product-owner-index');
        Route::match(['get', 'post'], 'create', 'Admin\ProductOwnersController@create')->name('admin-product-owner-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\ProductOwnersController@update')->name('admin-product-owner-update');
        Route::post('delete/{id}', 'Admin\ProductOwnersController@delete')->name('admin-product-owner-delete');
    });

    // product
    Route::prefix('product')->group(function () {
        Route::get('index', 'Admin\ProductsController@index')->name('admin-product-index');
        Route::post('index', 'Admin\ProductsController@index')->name('admin-product-index-search');
        Route::match(['get', 'post'], 'create', 'Admin\ProductsController@create')->name('admin-product-create');
        Route::match(['get', 'post'], 'update/{id}', 'Admin\ProductsController@update')->name('admin-product-update');
        Route::post('delete/{id}', 'Admin\ProductsController@delete')->name('admin-product-delete');
    });

});
//------------------
//ADMINPART
//------------------
Auth::routes();


//--------------
//Meta data part
//--------------
Route::get('/sitemap.xml', 'SitemapXmlController@index')->name('sitemap');

//rss
Route::get('/rss', 'RssController@index')->name('rss');
Route::get('/rss-{alias}', 'RssController@theme')->name('rss-theme');
Route::get('/all-active-products', 'RssController@getActiveProductUrls')->name('all-products');
Route::get('/all-feeds', 'RssController@getActiveRssFeeds')->name('all-feeds');
Route::get('/robots.txt', 'RobotsTxtController@index')->name('robots');
//--------------
//Meta data part
//--------------





