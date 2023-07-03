<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class plattersController extends Controller
{
    public function platters(Request $request)
    {
        $platter = $request->input('food');
        $place = $request->input('place');
        $platters = Restaurant::join('menu', 'menu.id_Restaurant', 'restaurants.id')
            ->select(
                'restaurants.name',
                'restaurants.other',
                'restaurants.neighborhood',
                'restaurants.timeOpen',
                'restaurants.timeClose',
                'restaurants.main_image',
                'restaurants.id',
                'restaurants.city',
                'restaurants.coins',
                'menu.pointsEarned',
                'menu.id',
                'menu.price',
                'menu.discount',
                'menu.priceCoins',
                'restaurants.currency'
            )
            ->where('menu.plat', $platter)
            ->where('city', $place)
            ->get();
        $userid = Auth::id();
        $userinfo = User::where('id', $userid)->first();
        // dd($platters);
        return view('platters', ['platters' => $platters, 'userinfo' => $userinfo]);
    }

    // public function platterDetail(Request $request){
    //     $idmenu=$request->input('id');
    //     $platterinfo=Menu::join('img_munus','img_menus.id','menu.id')
    //                      ->where('menu.id',$idmenu)->first();
    //     return view('platterDetail',['platterinfo'=>$platterinfo]);
    // }
}
