<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Menu;
use App\Models\Restaurant;
use App\Models\User;
use stripe\Exception\CardException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function stripe(Request $request)
    {
        $user_id = Auth::id();
        $userinfo = User::where('id', $user_id)->first();
        // Get data from user
        $menu_id = $request->input('menu_id');
        $quantity = $request->input('quantity');
        $city = $request->input('city');
        $neighborhood = $request->input('neighborhood');
        $building = $request->input('Building');
        $apartment = $request->input('Apartment');
        //Get hidden inputs
        $hidden_pay_with = $request->input('pay_with');
        $hidden_quantity = $request->input('hidden_quantity');
        $hidden_city = $request->input('hidden_city');
        $hidden_neighborhood = $request->input('hidden_neighborhood');
        $hidden_building = $request->input('hidden_Building');
        $hidden_apartment = $request->input('hidden_Apartment');
        $hidden_other = $request->input('hidden_other');
        if ($hidden_pay_with == 'coins') {
            $menu = Menu::find($menu_id);
            $price_coins = $menu->priceCoins;
            $total = $hidden_quantity * $price_coins;
            $points = $userinfo->points;
            $Restaurant_id = $menu->id_Restaurant;
            if ($points >= $price_coins) {
                $newCommande = new Commande();
                $newCommande->id_client = $user_id;
                $newCommande->id_Restaurant = $Restaurant_id;
                $newCommande->id_menu = $menu_id;
                $newCommande->city = $hidden_city;
                $newCommande->neighborhood = $hidden_neighborhood;
                $newCommande->building = $hidden_building;
                $newCommande->apartment = $hidden_apartment;
                $newCommande->total_by_coins = $total;
                $newCommande->quantity = $hidden_quantity;
                $newCommande->save();
                $points-= $price_coins;
                $userinfo->points=$points;
                $userinfo->save();
                return redirect()->back()->with('message', 'ordered successfully');
            } else{
                return redirect()->back()->with('message', 'you don’t have enough points to command');
            }
        } else {
            return view('stripe', [
                'userinfo' => $userinfo,
                'menu_id' => $menu_id,
                'hidden_pay_with' => $hidden_pay_with,
                'quantity' => $quantity,
                'city' => $city,
                'neighborhood' => $neighborhood,
                'Building' => $building,
                'Apartment' => $apartment,
                'hidden_quantity' => $hidden_quantity,
                'hidden_city' => $hidden_city,
                'hidden_neighborhood' => $hidden_neighborhood,
                'hidden_building' => $hidden_building,
                'hidden_apartment' => $hidden_apartment,
                'hidden_other' => $hidden_other
            ]);
        }
    }


    public function stripePost(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $menu_id = $request->input('menu_id');
        $user_id = auth()->id();
        $userinfo = User::find($user_id);
        $menu = Menu::find($menu_id);
        $currency = $menu->currency;
        $quantity = $request->input('quantity');
        $price = $menu->price;
        $Restaurant_id = $menu->id_Restaurant;
        $restaurant=Restaurant::find($Restaurant_id);
        $city = $request->input('city');
        $neighborhood = $request->input('neighborhood');
        $building = $request->input('Building');
        $apartment = $request->input('Apartment');
        $total = $price * $quantity;

        try {
            Charge::create([
                'amount' => $total * 100,
                'currency' => "usd",
                'source' => $request->stripeToken,
                'description' => 'Payment'
            ]);

            $newCommande = new Commande();
            $newCommande->id_client = $user_id;
            $newCommande->id_Restaurant = $Restaurant_id;
            $newCommande->id_menu = $menu_id;
            $newCommande->city = $city;
            $newCommande->neighborhood = $neighborhood;
            $newCommande->building = $building;
            $newCommande->apartment = $apartment;
            $newCommande->total = $total;
            $newCommande->quantity = $quantity;
            $newCommande->save();
            if ($restaurant->coins == 1) {
                $menu_points = $menu->pointsEarned;
                $user_points = $userinfo->points;
                $user_points += $menu_points;
                $userinfo->points = $user_points;
                $userinfo->save();
            }
            $message = "Payment successful";
        } catch (CardException $e) {
            $message = $e->getMessage();
        }

        return back()->with('message', $message);
    }
}
