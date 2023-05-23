<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
// use App\Http\User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype = Auth::user()->usertype;
        if ($usertype == '1') {
            return view('admin.dashboard');
        } else {
            //new code
            $id = 0;
            $test = Restaurant::all();
            $chosenforyou = Restaurant::inRandomOrder()->take(3)->get();
            $somerestaurants = Restaurant::inRandomOrder()->take(3)->get();
            $getCoins = Restaurant::where('coins', 1)->inRandomOrder()->take(3)->get();
            $userid = Auth::id();
            $userinfo = User::where('id', $userid)->first();
            return view('dashboard', ['somerestaurants' => $somerestaurants, 'chosenforyou' => $chosenforyou, 'getCoins' => $getCoins, 'id' => $id, 'userinfo' => $userinfo]);
        }
    }

    public function welcome()
    {
        $id = 0;
        $test = Restaurant::all();
        $chosenforyou = Restaurant::inRandomOrder()->take(3)->get();
        $somerestaurants = Restaurant::inRandomOrder()->take(3)->get();
        $getCoins = Restaurant::where('coins', 1)->inRandomOrder()->take(3)->get();
        $userid = Auth::id();
        $userinfo = User::where('id', $userid)->first();
        return view('dashboard', ['somerestaurants' => $somerestaurants, 'chosenforyou' => $chosenforyou, 'getCoins' => $getCoins, 'id' => $id, 'userinfo' => $userinfo]);
    }

    public function restaurants()
    {
        $id = 0;
        $chosenforyou = Restaurant::join('restaurant_images', 'restaurants.id', 'restaurant_images.restaurant_id')->inRandomOrder()->take(3)->get();
        $somerestaurants = Restaurant::join('restaurant_images', 'restaurants.id', 'restaurant_images.restaurant_id')->inRandomOrder()->take(3)->get();
        $getCoins = Restaurant::join('restaurant_images', 'restaurants.id', 'restaurant_images.restaurant_id')->where('restaurants.coins', 1)->inRandomOrder()->take(3)->get();
        return view('/welcome', ['somerestaurants' => $somerestaurants, 'chosenforyou' => $chosenforyou, 'getCoins' => $getCoins, 'id' => $id]);
    }

    public function home()      //redendance!! '\welcome'!
    {
        $id = 0;
        $chosenforyou = Restaurant::join('restaurant_images', 'restaurants.id', 'restaurant_images.restaurant_id')->inRandomOrder()->take(3)->get();
        $somerestaurants = Restaurant::join('restaurant_images', 'restaurants.id', 'restaurant_images.restaurant_id')->inRandomOrder()->take(3)->get();
        $getCoins = Restaurant::join('restaurant_images', 'restaurants.id', 'restaurant_images.restaurant_id')->where('restaurants.coins', 1)->inRandomOrder()->take(3)->get();
        $userid = Auth::id();
        $userinfo = User::where('id', $userid)->get();
        return view('/welcome', ['somerestaurants' => $somerestaurants, 'chosenforyou' => $chosenforyou, 'getCoins' => $getCoins, 'id' => $id, 'userinfo' => $userinfo]);
    }
}
