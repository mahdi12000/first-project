<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
// use App\Http\User;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype = Auth::user()->usertype;
        $id = Auth::user()->id;
        if ($usertype == '1') {
            $restaurants = Restaurant::leftJoin('owners', 'owners.restaurant_id', 'restaurants.id')
                ->leftJoin('menu', 'menu.id_Restaurant', 'restaurants.id')
                ->leftJoin('reservations', 'reservations.id_Restaurant', 'restaurants.id')
                ->leftJoin('commandes', 'commandes.id_Restaurant', 'restaurants.id')
                ->leftJoin('reviews', 'restaurants.id', 'reviews.Restaurant_id')
                ->select(
                    'restaurants.id',
                    'restaurants.name',
                    'restaurants.blocked',
                    'owners.owner',
                    DB::raw('COUNT(DISTINCT reservations.id) as reservations'),
                    DB::raw('COUNT(DISTINCT commandes.id) as commandes'),
                    DB::raw('COUNT(DISTINCT reviews.id) as feedbacks'),
                    DB::raw('COUNT(DISTINCT menu.id) as menus')
                )
                ->groupBy('restaurants.id', 'restaurants.name', 'restaurants.blocked', 'owners.owner')
                ->get();

            $admin = User::find($id);
            return view('admin.dashboard', [
                'restaurants' => $restaurants,
                'admin' => $admin
            ]);
        } else {
            //new code
            $id = 0;
            $chosenforyou = Restaurant::inRandomOrder()->take(3)->get();
            // $chosenforyou=Restaurant::join('menu','menu.id_Restaurant','restaurants.id')
            //                 ->select('restaurants.id',DB::raw('COUNT( menu.id) as nbrMenu'))
            //                 ->groupBy('restaurants.id')
            //                 ->having('nbrMenu','>=',1)
            //                 ->inRandomOrder()
            //                 ->take(3)
            //                 ->get();
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

    public function clientsInfo()
    {
        $admin = Auth::user();
        $clients = User::leftJoin('commandes', 'users.id', 'commandes.id_client')
            ->leftJoin('reservations', 'reservations.id_client', 'users.id')
            ->leftJoin('reviews', 'users.id', 'reviews.user_id')
            ->where('users.usertype', 0)
            ->select(
                'users.id as id',
                'users.name as name',
                'users.blocked',
                DB::raw('COUNT(DISTINCT reservations.id) as reservations'),
                DB::raw('COUNT(DISTINCT commandes.id) as commandes'),
                DB::raw('COUNT(DISTINCT reviews.id) as reviews')
            )
            ->groupBy('users.id', 'users.name', 'users.blocked')
            ->get();

        return view('admin.clientsInfo', ['admin' => $admin, 'clients' => $clients]);
    }


    public function connected_Restaurants()
    {
        $admin = Auth::user();
        $connectedR = Restaurant::where('connected', true)->get();
        return view('admin.connectedR', ['admin' => $admin, 'connectedR' => $connectedR]);
    }

    public function blockC(Request $request)
    {
        $idC = $request->input('idC');
        $id = Auth::id();
        $admin = User::find($id);
        $Client = User::find($idC);
        if ($Client->blocked == false) {
            $Client->blocked = true;
            $Client->save();
        } else {
            $Client->blocked = false;
            $Client->save();
        }
        $clients = User::leftJoin('commandes', 'users.id', 'commandes.id_client')
            ->leftJoin('reservations', 'reservations.id_client', 'users.id')
            ->leftJoin('reviews', 'users.id', 'reviews.user_id')
            ->where('users.usertype', 0)
            ->select(
                'users.id as id',
                'users.name as name',
                'users.blocked',
                DB::raw('COUNT(DISTINCT reservations.id) as reservations'),
                DB::raw('COUNT(DISTINCT commandes.id) as commandes'),
                DB::raw('COUNT(DISTINCT reviews.id) as reviews')
            )
            ->groupBy('users.id', 'users.name', 'users.blocked')
            ->get();
        return view('admin.clientsInfo', ['admin' => $admin, 'clients' => $clients]);
    }

    public function blockR(Request $request)
    {
        $idR = $request->input('idR');
        $id = Auth::id();
        $admin = User::find($id);
        $Restaurant = Restaurant::where('id', $idR)->first();

        if ($Restaurant->blocked == false) {
            $Restaurant->blocked = true;
            $Restaurant->save();
        } else {
            $Restaurant->blocked = false;
            $Restaurant->save();
        }
        $restaurants = Restaurant::leftJoin('owners', 'owners.restaurant_id', 'restaurants.id')
            ->leftJoin('menu', 'menu.id_Restaurant', 'restaurants.id')
            ->leftJoin('reservations', 'reservations.id_Restaurant', 'restaurants.id')
            ->leftJoin('commandes', 'commandes.id_Restaurant', 'restaurants.id')
            ->leftJoin('reviews', 'restaurants.id', 'reviews.Restaurant_id')
            ->select(
                'restaurants.id',
                'restaurants.name',
                'restaurants.blocked',
                'owners.owner',
                DB::raw('COUNT(DISTINCT reservations.id) as reservations'),
                DB::raw('COUNT(DISTINCT commandes.id) as commandes'),
                DB::raw('COUNT(DISTINCT reviews.id) as feedbacks'),
                DB::raw('COUNT(DISTINCT menu.id) as menus')
            )
            ->groupBy('restaurants.id', 'restaurants.name', 'restaurants.blocked', 'owners.owner')
            ->get();
        return view('admin.dashboard', ['Restaurant' => $Restaurant, 'admin' => $admin, 'restaurants' => $restaurants]);
    }

    public function block_connectedR(Request $request)
    {
        $idR = $request->input('idR');
        $id = Auth::id();
        $admin = User::find($id);
        $Restaurant = Restaurant::where('id', $idR)->first();
        if ($Restaurant->blocked == false) {
            $Restaurant->blocked = true;
            $Restaurant->save();
        } else {
            $Restaurant->blocked = false;
            $Restaurant->save();
        }
        $connectedR = Restaurant::where('connected', true)->get();
        return view('admin.connectedR', ['Restaurant' => $Restaurant, 'admin' => $admin,'connectedR'=>$connectedR]);
    }

    public function delete(Request $request)
    {
        $id = Auth::user()->id;
        $admin = User::find($id);
        $idR = $request->input('idR');
        $Restaurant = Restaurant::find($idR);
        $restaurants = Restaurant::leftJoin('owners', 'owners.restaurant_id', 'restaurants.id')
            ->leftJoin('menu', 'menu.id_Restaurant', 'restaurants.id')
            ->leftJoin('reservations', 'reservations.id_Restaurant', 'restaurants.id')
            ->leftJoin('commandes', 'commandes.id_Restaurant', 'restaurants.id')
            ->leftJoin('reviews', 'restaurants.id', 'reviews.Restaurant_id')
            ->select(
                'restaurants.id',
                'restaurants.name',
                'restaurants.blocked',
                'owners.owner',
                DB::raw('COUNT(DISTINCT reservations.id) as reservations'),
                DB::raw('COUNT(DISTINCT commandes.id) as commandes'),
                DB::raw('COUNT(DISTINCT reviews.id) as feedbacks'),
                DB::raw('COUNT(DISTINCT menu.id) as menus')
            )
            ->groupBy('restaurants.id', 'restaurants.name', 'restaurants.blocked', 'owners.owner')
            ->get();
        if ($Restaurant) {
            $Restaurant->delete();
            $message = 'deleted successufully';
        } else $message = 'error';
        return view('admin.dashboard', ['Restaurant' => $Restaurant, 'admin' => $admin, 'restaurants' => $restaurants]);
    }

    public function details(Request $request)
    {
        $id = Auth::user()->id;
        $admin = User::find($id);
        $idR = $request->input('idR');
        $Restaurant = Restaurant::find($idR);
        return view('admin.details', ['Restaurant' => $Restaurant, 'admin' => $admin]);
    }
}
