<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Commande;
use App\Models\Menu;
use App\Models\ImgMenu;
use App\Models\Reservation;
use App\Models\Restaurant;
use App\Models\Review;
use App\Models\Table;
use App\Models\User;
use DateInterval;
use DateTime;
use Exception;
use illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        /*probleme here*/
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
        //add 60 min to $time
        $ObjEndTime1 = new DateTime($time);
        $ObjEndTime1->add(new DateInterval('PT60M'));
        $endTime = $ObjEndTime1->format('H:i');

        $menu_info = Menu::where('id', $id_menu)->first();
        $user_info = User::where('id', $user_id)->first();
        $id_Restaurant = $menu_info->id_Restaurant;
        $restaurant = Restaurant::where('id', $id_Restaurant)->first();
        $Tables = $restaurant->tables;
        $reservations = Reservation::get();
        $table_id = null;
        $disponile = true;
        foreach ($Tables as $table) {
            $table_id = $table->id;
            $Restaurant_id = $table->id_Restaurant;
            foreach ($reservations as $reservation) {
                if ($reservation->id_table == $table_id) {
                    if ($reservation->date == $date) {
                        $reservationTime = strtotime($reservation->time);
                        $temps = strtotime($time);
                        $EndTime = strtotime($endTime);
                        if ($reservationTime <= $temps && $temps <= $EndTime) {
                            $disponile = false;
                        }
                    }
                }
            }
            if ($disponile == true) {
                $newReservation = new Reservation();
                $newReservation->id_client = $user_id;
                $newReservation->id_Restaurant = $Restaurant_id;
                $newReservation->id_table = $table_id;
                $newReservation->menuID = $id_menu;
                $newReservation->time = $time;
                $newReservation->date = $date;
                $newReservation->save();
                /* I will activate this option when the customer could validate his
                   presence at the time of reservation */
                // if ($restaurant->coins == 1) {
                //     $menu_points = $menu_info->pointsEarned;
                //     $user_points = $user_info->points;
                //     $user_points += $menu_points;
                //     $user_info->points = $user_points;
                //     $user_info->save();
                // }
                break;
            }
        }
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
        $comment->review = $newComment;
        $comment->save();
        //back to the last page
        return redirect()->back();
    }

    public function restaurant_info(Request $request)
    {
        $restaurant_id = $request->input('restaurant_id');
        $Restaurant = Restaurant::where('id', $restaurant_id)->first();
        $menus = Menu::where('id_Restaurant', $restaurant_id)->get();
        $userid = Auth::id();
        $userinfo = User::where('id', $userid)->first();
        $br = 0;
        return view('restaurant_info', ['menus' => $menus, 'br' => $br, 'userinfo' => $userinfo, 'restaurant' => $Restaurant]);
    }

    public function myReviews()
    {
        $user_id = auth::id();
        $userinfo = User::where('id', $user_id)->first();
        $reviews = Review::join('restaurants', 'restaurants.id', 'reviews.Restaurant_id')
            ->join('menu', 'menu.id_Restaurant', 'reviews.Restaurant_id')
            ->select('restaurants.name', 'menu.plat', 'reviews.review')
            ->where('user_id', $user_id)
            ->get();
        return view('reviews', [
            'userinfo' => $userinfo,
            'reviews' => $reviews
        ]);
    }

    public function myBookings()
    {
        $user_id = Auth::id();
        $userinfo = User::where('id', $user_id)->first();
        $myBookings = Reservation::select('reservations.id as id', 'restaurants.name as name', 'menu.plat as plat', 'menu.price as price', 'tables.placeNumber', 'reservations.date as date', 'reservations.time as time')
            ->join('restaurants', 'reservations.id_Restaurant', 'restaurants.id')
            ->join('menu', 'menu.id', 'reservations.menuID')
            ->join('tables', 'tables.id', 'reservations.id_table')
            ->where('id_client', $user_id)
            ->get();
        return view('myBookings', [
            'userinfo' => $userinfo,
            'myBookings' => $myBookings
        ]);
    }

    public function deleteBooking(Request $request)
    {
        $id = $request->input('booking_id');
        // dd($id);
        $booking = Reservation::find($id);
        // dd($booking);
        $booking->delete();
        return redirect()->back()->with('succes', 'Booking deleted successfully');
    }

    public function editBooking(Request $request)
    {
        $booking_id = $request->input('booking_id');
        $date = $request->input('date');
        $time = $request->input('time');
        $booking = Reservation::find($booking_id);
        // dd($booking);
        if ($booking) {
            // Mettez à jour les valeurs de date et d'heure du booking
            $booking->date = $date;
            $booking->time = $time;
            $booking->save();

            return redirect()->back()->with('success', 'Booking edited successfully');
        } else {
            return redirect()->back()->with('error', 'Booking not found');
        }
    }


    public function editPage(Request $request)
    {
        $user_id = Auth::id();
        $userinfo = User::where('id', $user_id)->first();
        $booking_id = $request->input('booking_id');
        $booking = Reservation::find($booking_id);
        // dd($booking);
        return view('editBooking', [
            'booking_id' => $booking_id,
            'userinfo' => $userinfo,
            'booking' => $booking
        ]);
    }

    public function myOrders(Request $request)
    {
        $user_id = Auth::id();
        $userinfo = User::where('id', $user_id)->first();
        $myorders = Commande::select(
            'commandes.id as id',
            'commandes.date as date',
            'restaurants.name as name',
            'menu.plat as plat',
            'commandes.total as total',
            'commandes.total_by_coins',
            'commandes.city as city',
            'commandes.neighborhood as neighborhood',
            'commandes.building as building',
            'commandes.apartment as apartment',
            'restaurants.currency as currency'
        )
            ->join('restaurants', 'commandes.id_Restaurant', 'restaurants.id', 'commandes.livred')
            ->join('menu', 'menu.id', 'commandes.id_menu')
            ->join('users', 'users.id', 'commandes.id_client')
            ->where('id_client', $user_id)
            ->get();
            // dd($myorders);
        return view('myorders', [
            'userinfo' => $userinfo,
            'myorders' => $myorders
        ]);
    }

    public function deleteOrder(Request $request)
    {
        $id = $request->input('order_id');
        // dd($id);
        $order = Commande::find($id);
        // dd($order);
        $order->delete();
        return redirect()->back()->with('succes', 'order deleted successfully');
    }

    public function editOrderPage(Request $request)
    {
        $user_id = Auth::id();
        $userinfo = User::where('id', $user_id)->first();
        $order_id = $request->input('order_id');
        $order = Commande::find($order_id);
        // dd($order);
        return view('editOrder', [
            'order_id' => $order_id,
            'userinfo' => $userinfo,
            'order' => $order
        ]);
    }

    public function editOrder(Request $request)
    {
        $Order_id = $request->input('order_id');
        // dd($Order_id);
        $city = $request->input('city');
        $neighborhood = $request->input('neighborhood');
        $building = $request->input('building');
        $apartment = $request->input('apartment');
        $order = Commande::find($Order_id);
        // dd($order);
        if ($order) {
            // Mettez à jour les valeurs de date et d'heure du order
            $order->city = $city;
            $order->neighborhood = $neighborhood;
            $order->building = $building;
            $order->apartment = $apartment;
            $order->save();
            return redirect()->back()->with('success', 'Order edited successfully');
        } else {
            return redirect()->back()->with('error', 'Order not found');
        }
    }

    public function myProfile()
    {
        $user_id = Auth::id();
        $userinfo = User::where('id', $user_id)->first();
        return view('profile', [
            'userinfo' => $userinfo
        ]);
    }

    public function update_profile_data(Request $request)
    {
        $data = $request->all();
        $user_id = Auth::id();
        $user = User::find($user_id);
        $image = $data['image'];
        $image_name = 'images/' . $image->getClientOriginalName();
        $image->move(public_path('images', $image_name));
        $user->pictureLink = $image_name;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->country = $data['country'];
        $user->city = $data['city'];
        $user->neighborhood = $data['neighborhood'];
        $user->building = $data['building'];
        $user->apartment = $data['apartment'];
        $user->other_specif = $data['other'];
        $user->save();
        return view('profile', ['userinfo' => $user]);
    }

    public function update_password(Request $request)
    {
        $user_id = Auth::id();
        $user = User::find($user_id);
        $data = $request->all();
        if ($user && Hash::check($data['current_password'], $user->password)) {
            if ($data['new_password'] == $data['confirm_password']) {
                if (strlen($data['new_password']) < 8) {
                    return redirect()->back()->with('message', 'The password must be at least 8 characters.');
                } else {
                    $user->password = Hash::make($data['new_password']);
                    $user->save();
                    return redirect()->back()->with('message', 'updated successfully');
                }
            }
        } else {
            return redirect()->back()->with('message', 'incorrect password!');
        }
    }

    public function Delete_Account(Request $request)
    {
        $user = Auth::user();
        $password = $request->input('password_confirmation');
        $message = '';
        if (Hash::check($password, $user->password)) {
            User::where('id', $user->id)->delete();
            return view('welcome');
        } else {
            $message = 'invalid password';
            return view('profile', ['userinfo' => $user])->with('message', $message);
        }
    }
}
