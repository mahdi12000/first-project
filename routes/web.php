<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\infoplatController;
use App\Http\Controllers\plattersController;
use App\Http\Controllers\RestaurantController;

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
// Route::get('/',[HomeController::class,'restaurants']); xxxxx

Route::get('/',[HomeController::class,'home']);

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard',[HomeController::class,'redirect'])->name('dashboard');
});

// ---->Route::middleware(['auth', 'restaurant'])->group(function () {
//     Route::get('/restaurant/dashboard', [RestaurantController::class, 'dashboard'])->name('restaurant.dashboard');
// });

// function () {
//     return view('dashboard');   //bdlt had fonction b HomeController li lfo9

Route::get('/redirect',[HomeController::class,'redirect']);
Route::get('/',[HomeController::class,'welcome'])->name('welcome');

// Route::get('platters',[plattersController::class,'platters']);
// Route::get('plattersController',[plattersController::class,'platterDetail']); //juste
Route::post('/platters',[plattersController::class,'platters'])->name('platters'); //juste
Route::get('/infoplatter',[infoplatController::class,'platterInfo'])->name('infoplat');
Route::post('/confirm',[infoplatController::class,'Book_Now'])->middleware('auth')->name('confirm');
Route::post('/comment',[infoplatController::class,'comment'])->name('comment');
Route::post('/modifie',[infoplatController::class,'modifie'])->name('modifie');
Route::post('/delete',[infoplatController::class,'delete'])->name('delete');
Route::get('/restaurant',[infoplatController::class,'restaurant_info'])->name('restaurant_info');

/*-----------------------Restaurant Route------------------------*/
Route::prefix('Restaurant')->group(function(){
    Route::get('/login',[RestaurantController::class,'index'])->name('login_form');
    Route::get('/login/owner',[RestaurantController::class,'login'])->name('Restaurant.login');
    Route::get('/dashboard',[RestaurantController::class,'dashboard'])->name('Restaurant.dashboard')->middleware('Restaurant');

});
/*-----------------------end Restaurant Route--------------------*/