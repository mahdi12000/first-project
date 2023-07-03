<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\infoplatController;
use App\Http\Controllers\plattersController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\stripeController;
use App\Models\Restaurant;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\get;

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

Route::get('/', [HomeController::class, 'home']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'redirect'])->name('dashboard');
});

//-------------------------- new added---------------------------------
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
//---------------------------added-------------------------------------

// ---->Route::middleware(['auth', 'restaurant'])->group(function () {
//     Route::get('/restaurant/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
// });

// function () {
//     return view('dashboard');   //bdlt had fonction b HomeController li lfo9

Route::get('/redirect', [HomeController::class, 'redirect'])->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified']);
Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

// Route::get('platters',[plattersController::class,'platters']);
// Route::get('plattersController',[plattersController::class,'platterDetail']); //juste
Route::post('/platters', [plattersController::class, 'platters'])->name('platters'); 
Route::get('/infoplatter', [infoplatController::class, 'platterInfo'])->name('infoplat');
Route::post('/confirm', [infoplatController::class, 'Book_Now'])->middleware('auth')->name('confirm');
Route::post('/comment', [infoplatController::class, 'comment'])->name('comment');
Route::post('/modifie', [infoplatController::class, 'modifie'])->name('modifie');
Route::post('/delete', [infoplatController::class, 'delete'])->name('delete');
Route::get('/restaurant', [infoplatController::class, 'restaurant_info'])->name('restaurant_info');
Route::get('/my reviews', [infoplatController::class, 'myReviews'])->middleware('auth')->name('my reviews');
Route::get('stripe', [stripeController::class, 'stripe'])->middleware('auth')->name('stripe');
Route::post('stripe', [stripeController::class, 'stripePost'])->middleware('auth')->name('stripePost');

Route::get('/myBookings', [infoplatController::class, 'myBookings'])->middleware('auth')->name('myBookings');
Route::post('delete Booking', [infoplatController::class, 'deleteBooking'])->middleware('auth')->name('booking.delete');
Route::post('editBooking', [infoplatController::class, 'editBooking'])->middleware('auth')->name('booking.edit');
Route::get('editBooking', [infoplatController::class, 'editPage'])->middleware('auth')->name('booking.editPage');

Route::get('myOrders', [infoplatController::class, 'myOrders'])->middleware('auth')->name('myOrders');
Route::post('editOrders', [infoplatController::class, 'editOrder'])->middleware('auth')->name('order.edit');
Route::post('delete Order', [infoplatController::class, 'deleteOrder'])->middleware('auth')->name('order.delete');
Route::get('editOrders', [infoplatController::class, 'editOrderPage'])->middleware('auth')->name('order.editPage');
// Route::get('myProfil',[infoplatController::class,'myProfile'])->middleware('auth')->name('profile');
Route::get('/profil',[infoplatController::class,'myProfile'])->middleware('auth')->name('profile');
Route::post('updateProfile',[infoplatController::class,'update_profile_data'])->middleware('auth')->name('updateProfile');
Route::post('updatePassword',[infoplatController::class,'update_password'])->middleware('auth')->name('updatePassword');
Route::post('/Delete_Account',[infoplatController::class,'Delete_Account'])->middleware('auth')->name('delete_account');

/*-----------------------------Restaurant Routes-----------------------------------*/
Route::prefix('Restaurant')->group(function () {
    Route::get('/login', [RestaurantController::class, 'login_form'])->name('Restaurant.login_form');
    Route::get('/registration',[RestaurantController::class, 'registration_form'])->name('registration');
    Route::post('/loginAccount', [RestaurantController::class, 'login'])->name('loginAccount');
    Route::get('/dashboard', [RestaurantController::class, 'dashboard'])->name('Restaurant.dashboard');
    Route::post('/register',[RestaurantController::class, 'create'])->name('registerRestaurant');
    Route::get('/orders',[RestaurantController::class, 'orders'])->name('Restaurant.orders');
    Route::get('/reservations',[RestaurantController::class, 'reservations'])->name('Restaurant.reservations');
    Route::get('/menus',[RestaurantController::class, 'menus'])->name('Restaurant.menus');
    Route::get('/details',[RestaurantController::class, 'menuDetails'])->name('Restaurant.menuDetails');
    Route::put('/update', [RestaurantController::class, 'update'])->name('Restaurant.update');
    Route::post('/addimage',[RestaurantController::class, 'addImages'])->name('Restaurant.addImages');
    Route::post('/image',[RestaurantController::class, 'mainImage'])->name('Restaurant.mainImage');
    Route::post('/deleteImage',[RestaurantController::class, 'deleteimg'])->name('Restaurant.delete');
    Route::post('/mainimage',[RestaurantController::class, 'main_image'])->name('Restaurant.mainImage');
    Route::post('/modifieMain',[RestaurantController::class, 'modifieMain'])->name('Restaurant.modifieMain');
    Route::post('deletemain',[RestaurantController::class, 'delete_main_image'])->name('Restaurant.deleteMain');
    Route::get('/feedbacks',[RestaurantController::class, 'feedbacks'])->name('Restaurant.feedbacks');
    Route::get('/menuFeedbacks',[RestaurantController::class, 'menu_feedbacks'])->name('Restaurant.menuFeedbacks');
    Route::get('/discounts',[RestaurantController::class, 'discounts'])->name('Restaurant.discounts');
    Route::post('/changeDiscount',[RestaurantController::class, 'change_discount'])->name('Restaurant.changeDiscount');
    Route::get('/MyRestaurant',[RestaurantController::class, 'my_restaurant'])->name('Restaurant.MyRestaurant');
    Route::post('/update',[RestaurantController::class, 'modifie_Restaunant_infos'])->name('Restaurant.update');
    Route::post('/main_image',[RestaurantController::class, 'modifie_main_image'])->name('Restaurant.main_image');
    Route::get('/newMenu',[RestaurantController::class, 'add_menu_view'])->name('Restaurant.newMenu');
    Route::post('/addMenu',[RestaurantController::class, 'add_menu'])->name('Restaurant.addMenu');
    Route::get('/tables',[RestaurantController::class, 'tables'])->name('Restaurant.tables');
    Route::post('/addTable',[RestaurantController::class, 'add_tables'])->name('Restaurant.addTable');
    Route::get('/log out',[RestaurantController::class, 'log_out'])->name('Restaurant.log_out');
});
/*----------------------------end Restaurant Routes-------------------------------------*/

/*-------------------------admine routes-------------------------------------------*/
Route::get('/clients',[HomeController::class, 'clientsInfo'])->middleware('auth')->name('admin.clients');
Route::get('/connected-Restaurants',[HomeController::class, 'connected_Restaurants'])->middleware('auth')->name('admin.connectedR');
Route::post('/action',[HomeController::class, 'blockR'])->middleware('auth')->name('admin.block');
Route::post('/action2',[HomeController::class, 'blockC'])->middleware('auth')->name('admin.blockC');
Route::post('/delete',[HomeController::class, 'delete'])->middleware('auth')->name('admin.delete');
Route::post('/block',[HomeController::class, 'block_connectedR'])->middleware('auth')->name('admin.block\_connectedR');
Route::post('/details',[HomeController::class, 'details'])->middleware('auth')->name('admin.details');
