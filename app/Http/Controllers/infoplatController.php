<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\ImgMenu;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Table;
use App\Models\User;
use illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;

class infoplatController extends Controller
{
    public function platterInfo(Request $request)
    {
        $platterid = $request->input('menu_id');
        $main_menu = Menu::inRandomOrder()->where('id', $platterid)
            ->take(1)
            ->first();
        $menu = Menu::join('restaurants', 'restaurants.id', 'menu.id_Restaurant')
            ->where('menu.id', $platterid)
            ->first();
        $imagesMenu = ImgMenu::inRandomOrder()
            ->where('id_menu', $platterid)
            ->take(4)
            ->get();
        /*mochkil hna*/
        $reviews = Review::join('users', 'users.id', 'reviews.user_id')
            ->select('reviews.id as review_id', 'users.id as user_id', 'reviews.*', 'users.*')
            ->where('reviews.menu_id', $platterid)
            ->get();
            //dd($reviews);
        $comments = Review::where('menu_id', $platterid)->get();
        $userid = Auth::id();
        $userinfo = User::where('id', $userid)->first();
        $id = 0;
        return view('infoPlat', [
            'menu' => $menu,
            'imagesMenu' => $imagesMenu,
            'userinfo' => $userinfo,
            'id' => $id,
            'main_menu' => $main_menu,
            'reviews' => $reviews,
            'menu_id' => $platterid
        ]);
    }

    public function Book_Now(Request $request)
    {
        $id_menu = $request->input('id_menu');
        $user_id = Auth::id();
        $nbrPlace = $request->input('places');
        $date = $request->input('date');
        $time = $request->input('time');

        $menu_info = Menu::where('id', $id_menu)->first();
        $user_info = User::where('id', $user_id)->first();
        $id_Restaurant = $menu_info->id_Restaurant;
        $restaurant = Restaurant::where('id', $id_Restaurant)->first();
        // dd($restaurant);
        $Tables = $restaurant->tables();
        $reservations = Reservation::get();
        // $Restaurant_info = null;
        $table_id = null;
        $disponile = true;
        foreach ($Tables as $table) {
            $table_id = $table->id;
            $Restaurant_id = $table->id_Restaurant;
            // $Restaurant_info = Restaurant::where('id', 1)->first();
            foreach ($reservations as $reservation) {
                if ($reservation->id_table == $table_id) {
                    if ($reservation->date == $date) {
                        //dd($reservation->id);
                        // dd($time);
                        // $reservationMinutes = date('i', strtotime($reservation->time));
                        // $reservationHour = date('H', strtotime($reservation->time));
                        // $hours = date('i', strtotime($time));
                        // $minutes = date('H', strtotime($time));

                        $reservationTime = strtotime($reservation->time);
                        $temps = strtotime($time);
                        //dd($temps==$reservationTime);
                        //dd($reservationHour >$hours);
                        if ($temps == $reservationTime) {
                            //dd($reservationTime==$temps);
                            $disponile = false;
                            //dd($disponile);
                        }
                    }
                }
            }
            if ($disponile == true) {
                //je veux ajouter une reservation a la table reservations
                $newReservation = new Reservation();
                $newReservation->id_client = $user_id;
                $newReservation->id_Restaurant = $Restaurant_id;
                $newReservation->id_table = $table_id;
                $newReservation->time = $time;
                $newReservation->date = $date;
                $newReservation->save();
                break;
            }
        }
        // dd($user_info);
        /* --->maintenant je dois travailler sur le designe de la page!! */

        return view('reservation_informations', [
            'userinfo' => $user_info,
            'Restaurant_info' => $restaurant,
            'table_id' => $table_id,
            'time' => $time,
            'date' => $date,
            'menu_info' => $menu_info,
            'nbrPlace' => $nbrPlace,
            'disponible' => $disponile
        ]);
    }

    public function comment(Request $request)
    {
        $user_id = Auth::id();
        $menu_id = $request->input('menu_id');
        // $note=$request->input('note');
        $Menu = Menu::where('id', $menu_id)
            ->first();
        $restaurant_id = $Menu->id_Restaurant;
        $comment_input = $request->input('comment');
        $comment = new Review();
        $comment->review = $comment_input;
        $comment->menu_id = $menu_id;
        $comment->user_id = $user_id;
        $comment->Restaurant_id = $restaurant_id;
        $comment->note = 8;
        $comment->save();
        $comment_id = $comment->id;
        //stock id in the session
        session()->flash('newCommentId', $comment_id);
        //back to the last page
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $comment_id = $request->input('comment_id');
        // dd($comment_id);
        $comment = Review::find($comment_id);
        $comment->delete();
        return redirect()->back();
    }

    public function modifie(Request $request)
    {
        $comment_id = $request->input('comment_id');
        $newComment = $request->input('newComment');
        $comment = Review::where('id', $comment_id)->first();
        // dd($comment);
        $comment->review = $newComment;
        $comment->save();
        //back to the last page
        return redirect()->back();
    }

    public function restaurant_info(Request $request)
    {
        $restaurant_id = $request->input('restaurant_id');
        $menus = Menu::where('id_Restaurant', $restaurant_id)->get();
        $userid = Auth::id();
        $userinfo = User::where('id', $userid)->first();
        $br = 0;
        return view('restaurant_info', ['menus' => $menus, 'br' => $br, 'userinfo' => $userinfo]);
    }
}
