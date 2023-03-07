<?php

use App\Events\AdminMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CupponController;
use App\Http\Controllers\customer\AddressController;
use App\Http\Controllers\customer\StripePaymentController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ManageUsersController;
use App\Http\Controllers\Order as ControllersOrder;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\CustomerController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\customer\TicketViewController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketViewController as AdminTicketViewController;
use App\Http\Controllers\customer\TicketController as CustomerTicket;
use App\Http\Controllers\customer\ConversionController as CustomerConversion;
use App\Models\Order;
use Illuminate\Support\Facades\Artisan;

use App\Events\Message;
use App\Events\testEvent;
use App\Http\Controllers\ConversionController;
use App\Http\Controllers\customer\CustomerOrderController;
use App\Http\Controllers\customer\CustomerProductsController;
use App\Http\Controllers\Payment\PaypalColtroller;
use App\Http\Controllers\Payment\VerifyPayment;
use Illuminate\Http\Request;



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
    return view('welcome');
});

Route::get('/event', function () {

    event(new testEvent('this test message to azad 2', 6));

});
// Route::get('/admin-event', function () {

//     event(new AdminMessage('this test message to azad 2', 52));

// });
Route::get('/customer-listen', function () {

    return view('customerSend');

});
Route::get('/listen', function () {

    return view('index');

});

Route::get('/chat/room', [ConversionController::class, 'chatRoom'])->middleware('admin.auth');



Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::view('/dashoboard', 'admin.dashboard');
// Route::view('/home', 'shop.home');
Route::get('/home', [HomeController::class, 'index']);

Route::view('/user-login', 'auth.login');
Route::view('/user-register', 'auth.register');

Route::view('/contact', 'shop.contact')->name('contact');

Route::group(['prefix' => 'admin'], function() {
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::view('/login','auth.admin.login')->name('admin.login');
        Route::view('/register', 'auth.admin.register')->name('newadmin.register');
        Route::post('/auth',[AdminController::class, 'authenticate'])->name('admin.auth');
        Route::post('/admin-register',[AdminController::class, 'register'])->name('admin.register');
    });
    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard',[AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');

        Route::get('/manage-users', [ManageUsersController::class, 'manageUsers'])->name('manage.users');
        Route::get('/user/edit/{id}', [ManageUsersController::class, 'editUsers'])->name('edit.user');
        Route::post('/delete/user/{id}', [ManageUsersController::class, 'deleteUser'])->name('delete.user');
        Route::post('/updae-users', [ManageUsersController::class, 'updateUsers'])->name('update.users');

        Route::get('/orders', [ManageUsersController::class, 'orders'])->name('admin.orders');
        Route::get('/update-orders', [ManageUsersController::class, 'updateUrders'])->name('update.orders');

        Route::get('/products', [ProductController::class, 'adminProducts'])->name('admin.products');
        Route::get('/product/edit/{id}', [ProductController::class, 'editProduct'])->name('edit.product');
        Route::post('/update-product', [ProductController::class, 'updateProduct'])->name('update.product');
        Route::post('/delete/product/{id}', [ProductController::class, 'deleteProduct'])->name('delete.product');

        Route::get('/category', [CategoryController::class, 'category'])->name('product.category');
        Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
        Route::post('/delete/category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
        Route::post('/update-category', [CategoryController  ::class, 'updateCategory'])->name('update.category');

        Route::get('/cuppons', [CupponController::class, 'cuppons'])->name('product.cuppons');
        Route::get('/cuppon/edit/{id}', [CupponController::class, 'editCuppon'])->name('edit.cuppon');
        Route::post('/delete/cuppon/{id}', [CupponController::class, 'deleteCuppon'])->name('delete.cuppon');
        Route::post('/update-cuppon', [CupponController  ::class, 'updateCuppon'])->name('update.cuppon');

        Route::get('/discounts', [DiscountController::class, 'discounts'])->name('product.discounts');
        Route::get('/discount/edit/{id}', [DiscountController::class, 'editDiscount'])->name('edit.discount');
        Route::post('/delete/discount/{id}', [DiscountController::class, 'deleteDiscount'])->name('delete.discount');
        Route::post('/update/discount', [DiscountController  ::class, 'updateDiscount'])->name('update.discount');

        // order route
        Route::get('/orders', [OrderController::class, 'orders'])->name('product.orders');
        Route::get('/order/edit/{id}', [OrderController::class, 'editOrder'])->name('edit.order');
        Route::post('/delete/order/{id}', [OrderController::class, 'deleteOrder'])->name('delete.order');
        Route::post('/update/order', [OrderController  ::class, 'updateOrder'])->name('update.order');

        //manage ticket route
        Route::get('/tickets', [TicketController::class, 'tickets'])->name('manage.tickets');
        Route::get('/ticket/edit/{id}', [TicketController::class, 'editTicket'])->name('edit.ticket');
        Route::post('/delete/ticket/{id}', [TicketController::class, 'deleteTicket'])->name('delete.ticket');
        Route::post('/update/ticket', [TicketController::class, 'updateTicket'])->name('update.ticket');
        Route::get('/ticket/read/notification/{uid}', [TicketController::class, 'readAsNotification'])->name('ticket.readAs.notification');

        //new ticket
        Route::get('ticket/all', [TicketController::class, 'allTicket'])->name('ticket.all');
        Route::get('view/ticket/{id}', [AdminTicketViewController::class, 'viewTicket'])->name('admin.view.ticket');
        Route::post('/replay/{id}', [AdminTicketViewController::class, 'adminReply'])->name('admin.replay');

        //conversion
        Route::get('/conversation/{id}', [ ConversionController::class, 'index'])->name('conversation');
        Route::post('/send-message', [ConversionController::class, 'sendMessage']);
        Route::get('/chat/room', [ConversionController::class, 'chatRoom']);


        //notification


    });
});

// Route::get('/checkout/{id}', [CheckoutController::class, 'checkout'])->name('manage.checkout');


Route::group(['prefix' => 'user'], function() {
    Route::group(['middleware' => 'guest'], function(){
        // Route::get('/checkout/{id}', [CheckoutController::class, 'checkout'])->name('manage.checkout');
    });
    Route::group(['middleware' => 'auth'], function(){
    });
});


Route::group(['prefix' => 'customer'], function() {
    Route::group(['middleware' => 'guest'], function(){
        Route::post('/login', [CustomerController::class, 'login'])->name('customer.login');

        Route::post('/checkout-login',[CustomerController::class, 'loginFromCheckout'])->name('customer.loginFromCheckout');
        Route::post('/auth',[CustomerController::class, 'authenticate'])->name('customer.auth');
        Route::post('/register',[CustomerController::class, 'register'])->name('customer.register');

        Route::get('/checkout/{id}', [CheckoutController::class, 'checkout'])->name('manage.checkout');
        Route::post('/verify-cuppon', [CustomerController::class, 'verifyCuppon'])->name('verify.cuppon');

    });
    Route::group(['middleware' => 'customer.auth'], function(){
        Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');

        Route::get('/dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');

        Route::get('/my-profile', [CustomerController::class, 'customerProfile'])->name('customer.profile');

        Route::get('/address', [AddressController::class, 'address'])->name('customer.address');
        Route::get('/address/edit/{id}', [AddressController::class, 'editAddress'])->name('edit.address');
        Route::post('/delete/address/{id}', [AddressController::class, 'deleteAddress'])->name('delete.address');
        Route::post('/update-address', [AddressController::class, 'updateAddress'])->name('update.address');

        // order
        Route::get('/customer-order', [CustomerOrderController::class, 'CustomerOrder'])->name('customer.order');

        // manage customer product
        Route::get('/customer-prodcuts', [CustomerProductsController::class, 'CustomerProducts'])->name('customer.products');
        Route::get('/service-details-info', [CustomerProductsController::class, 'ServiceInfo'])->name('service.detailsinfo');


        // Route::get('/category/edit/{id}', [CategoryController::class, 'editCategory'])->name('edit.category');
        // Route::post('/delete/category/{id}', [CategoryController::class, 'deleteCategory'])->name('delete.category');
        // Route::post('/update-category', [CategoryController  ::class, 'updateCategory'])->name('update.category');

        //ticket
        Route::get('/ticket/list', [CustomerTicket::class, 'index'])->name('customer.ticket.list');
        Route::get('/ticket', [CustomerTicket::class, 'ticket'])->name('customer.ticket');
        Route::post('/generate/ticket', [CustomerTicket::class, 'generateTicket'])->name('customer.generate.ticket');

        Route::get('ticket/all', [CustomerTicket::class, 'allTicket'])->name('customer.ticket.all');
        Route::get('view/ticket/{id}', [TicketViewController::class, 'viewTicket'])->name('customer.view.ticket');
        //replay
        Route::post('/replay/{id}', [TicketViewController::class, 'replayCustomer'])->name('customer.replay');

        //conversion
        Route::get('/conversion/{id}', [CustomerConversion::class, 'conversionOpen'])->name('customer.conversion');
        Route::get('/receive-message', [CustomerConversion::class, 'receiveMessage']);
        Route::post('/send-message', [CustomerConversion::class, 'sendMessage']);

        Route::get('/paypal-payment', [PaypalColtroller::class, 'paypalPayment'])->name('paypal.payment');
        Route::get('/veriy-payment/{cartId}/{payment_type}', [VerifyPayment::class, 'vefityPayment'])->name('verify.payment');

        Route::controller(StripePaymentController::class)->group(function(){
            Route::get('stripe', 'stripe')->name('make.payment');
            Route::post('stripe', 'stripePost')->name('stripe.post');
        });
    });
});

Route::view('/ticket', 'layouts.generate_ticket');






