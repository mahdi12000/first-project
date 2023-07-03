<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Restaurant;
use App\Models\Restaurant_image;
use App\Models\User;
use App\Models\Commande;
use App\Models\ImgMenu;
use App\Models\Menu;
use App\Models\Owner;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\Table;
use Illuminate\Auth\Authenticatable;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use PasswordValidationRules;
use Laravel\Fortify\Rules\Password as PasswordRule;
use Illuminate\Contracts\Encryption\DecryptException;

use function Pest\Laravel\get;

class RestaurantController extends Controller
{
    protected function passwordRules()
    {
        return ['required', 'string', new PasswordRule];
    }

    public function login_form()
    {
        return view('Restaurant.login_form');
    }

    public function registration_form()
    {
        return view('Restaurant.registerRestaurant');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');
        $Restaurant = Restaurant::where('email', $email)->first();
        if ($Restaurant && Hash::check($password, $Restaurant->password)) {
            $Restaurant->connected = true;
            $Restaurant->save();
            Session::put('Restaurant_id', $Restaurant->id);
            return redirect()->route('Restaurant.dashboard');
        } else {
            return back();
        }
    }

    public function log_out()
    {
        $id = Session::get('Restaurant_id');
        $Restaurant = Restaurant::find($id);
        $Restaurant->connected = false;
        $Restaurant->save();
        Session::forget('Restaurant_id');
        return redirect()->route('Restaurant.login_form');
    }

    public function dashboard()
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $restaurant = Restaurant::leftJoin('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            $total_orders = Commande::where('id_Restaurant', $id)->count();


            $total_reservations = Reservation::where('id_Restaurant', $id)->count();

            $total_menu = Menu::where('id_Restaurant', $id)->count();

            $total_feedbacks = Review::where('Restaurant_id', $id)->count();

            $earnings_orders = Restaurant::join('commandes', 'restaurants.id', 'commandes.id_Restaurant')
                ->join('menu', 'menu.id_Restaurant', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->select(DB::raw('SUM(menu.price) as earnings'))
                ->first()
                ->earnings;
            $currency = Restaurant::select('currency')->where('id', $id)->first();
            $earnings_reservations = Restaurant::join('reservations', 'restaurants.id', 'reservations.id_Restaurant')
                ->join('menu', 'menu.id_Restaurant', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->select(DB::raw('SUM(menu.price) as earnings'))
                ->first()
                ->earnings;
            $total_earnings = $earnings_orders + $earnings_reservations;

            //---------------daily turover for the last 7 days (orders)---------------
            // Obtenez la date d'il y a 7 jours
            $sevenDaysAgo = Carbon::now()->subDays(7)->toDateString();
            // dd($sevenDaysAgo);

            // Effectuez la requête pour obtenir les chiffres d'affaires quotidiens
            $dailyOrdersEarnings = Restaurant::join('commandes', 'restaurants.id', 'commandes.id_Restaurant')
                ->join('menu', 'menu.id_Restaurant', 'restaurants.id')
                ->where('commandes.date', '>=', $sevenDaysAgo)
                ->where('restaurants.id', $id)
                ->groupBy('commandes.date')
                ->select('commandes.date', DB::raw('SUM(menu.price) as earnings'))
                ->get();

            // Convertir les résultats en JSON
            $dailyOrdersEarningsJson = $dailyOrdersEarnings->toJson();
            // dd($dailyOrdersEarningsJson);

            //---------------daily turnover for the last 7 days (reservations)--------------
            // Effectuez la requête pour obtenir les chiffres d'affaires quotidiens
            $dailyReservationsEarnings = Restaurant::join('reservations', 'restaurants.id', 'reservations.id_Restaurant')
                ->join('menu', 'menu.id_Restaurant', 'restaurants.id')
                ->where('reservations.date', '>=', $sevenDaysAgo)
                ->where('restaurants.id', $id)
                ->groupBy('reservations.date')
                ->select('reservations.date', DB::raw('SUM(menu.price) as earnings'))
                ->get();
            // Convertir les résultats en JSON
            $dailyReservationsEarningsJson = $dailyReservationsEarnings->toJson();
            // dd($dailyReservationsEarningsJson);

            //-----------------------total earnings per day----------------------------
            //extraire les derniers 7 jours
            $dates = [];
            $startDays = Carbon::parse($sevenDaysAgo);
            for ($i = 0; $i < 7; $i++) {
                $dates[] = $startDays->format('Y-m-d');
                $startDays->addDay();
            }

            $dailyEarnings = [];
            $earning = 0;

            //faire une boucle sur les dates
            foreach ($dates as $date) {
                $orderEarning = $dailyOrdersEarnings->firstWhere('date', $date);
                $reservationEarning = $dailyReservationsEarnings->firstWhere('date', $date);

                if ($orderEarning) {
                    $earning += $orderEarning->earnings;
                }

                if ($reservationEarning) {
                    $earning += $reservationEarning->earnings;
                }

                $dailyEarnings[] = [
                    'date' => $date,
                    'earnings' => $earning,
                ];
                $earning = 0;
            }
            // dd($dailyEarnings);

            // Convertir les résultats en JSON
            $dailyEarningsJson = json_encode($dailyEarnings, JSON_NUMERIC_CHECK);
            // dd($dailyEarningsJson);

            //---------------------------daily orders last 7 days---------------------------------
            $dailyOrders = Restaurant::join('commandes', 'restaurants.id', 'commandes.id_Restaurant')
                ->where('commandes.date', '>=', $sevenDaysAgo)
                ->where('restaurants.id', $id)
                ->groupBy('commandes.date')
                ->select('commandes.date', DB::raw('COUNT(*) as dailyOrders'))
                ->get();
            // convert results to json
            $dailyOrdersJson = $dailyOrders->toJson();

            //---------------------------daily reservations last 7 days-----------------------
            $dailyReservations = Restaurant::join('reservations', 'restaurants.id', 'reservations.id_Restaurant')
                ->where('reservations.date', '>=', $sevenDaysAgo)
                ->where('restaurants.id', $id)
                ->groupBy('reservations.date')
                ->select('reservations.date', DB::raw('COUNT(*) as dailyReservations'))
                ->get();
            // convert results to json
            $dailyReservationsJson = $dailyReservations->toJson();
            // dd($dailyReservationsJson);

            //-------------------------the four most ordered menus---------------------
            $mostOrderd = Restaurant::join('commandes', 'restaurants.id', 'commandes.id_Restaurant')
                ->join('menu', 'Commandes.id_menu', 'menu.id')
                ->where('restaurants.id', $id)
                ->groupBy('menu.plat')
                ->select('menu.plat as label', DB::raw('COUNT(*) as value'))
                ->orderBy('value', 'desc')
                ->limit(4)
                ->get();

            $mostOrderdJson = $mostOrderd->toJson();
            // dd($mostOrderdJson);
            //------------------------------customer feedbacks---------------------------
            $customerfeedbacksJson = Restaurant::join('reviews', 'reviews.Restaurant_id', 'restaurants.id')
                ->inRandomOrder()
                ->limit(2)
                ->get()
                ->toJson();
            $ownerJson = Owner::where('restaurant_id', $id)->first();
            $randomFeebacks = Review::join('users', 'users.id', 'reviews.user_id')
                ->inRandomOrder()
                ->where('Restaurant_id', $id)->limit(2)->get();
            // dd($randomFeebacks);

            return view('Restaurant.RestaurantDashboard', [
                'restaurant' => $restaurant,
                'total_orders' => $total_orders,
                'total_reservations' => $total_reservations,
                'total_menu' => $total_menu,
                'total_feedbacks' => $total_feedbacks,
                'total_earnings' => $total_earnings,
                'currency' => $currency,
                'dailyReservationsEarningsJson' => $dailyReservationsEarningsJson,
                'dailyOrdersEarningsJson' => $dailyOrdersEarningsJson,
                'dailyEarningsJson' => $dailyEarningsJson,
                'dailyReservationsJson' => $dailyReservationsJson,
                'dailyOrdersJson' => $dailyOrdersJson,
                'mostOrderdJson' => $mostOrderdJson,
                'customerfeedbacksJson' => $customerfeedbacksJson,
                'ownerJson' => $ownerJson,
                'randomFeebacks' => $randomFeebacks
            ]);
        } else {
            return redirect()->route('Restaurant.login_form');
        }
    }

    public function create(Request $request)
    {
        $data = $request->all();
        if ($data['coins'] == 'yes') $coin = 1;
        else $coin = 0;
        $email = $data['email'];
        $emailExist = DB::table('restaurants')->where('email', $email)->exists();
        // dd($emailExist);
        if (!$emailExist) {
            $newRestaurant = new Restaurant();
            $newRestaurant->name = $data['name'];
            $newRestaurant->email = $data['email'];
            $newRestaurant->password = Hash::make($data['password']);
            $newRestaurant->city = $data['city'];
            $newRestaurant->numberPhone = $data['numberphone'];
            $newRestaurant->small_Presentation = $data['description'];
            $newRestaurant->coins = $coin;
            $newRestaurant->country = $data['country'];
            $newRestaurant->currency = $data['currency'];
            $newRestaurant->neighborhood = $data['neighborhood'];
            $newRestaurant->timeOpen = $data['openning_time'];
            $newRestaurant->timeClose = $data['closing_time'];
            $newRestaurant->other = $data['other'] ?? null;

            $newRestaurant->save();

            $owner = new Owner();
            $owner->restaurant_id = $newRestaurant->id;
            $owner->save();
            return view('Restaurant.login_form');
        } else {
            return redirect()->back()->with('message', 'email already exist');
        }
    }

    public function orders()
    {

        $id = Session::get('Restaurant_id');
        if ($id) {
            $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            $date = Carbon::today();
            // dd($date);
            $orders = Commande::select(
                'commandes.id as id',
                'commandes.date as date',
                'commandes.quantity as quantity',
                'commandes.time as time',
                'menu.plat as plat',
                'commandes.total as total',
                'commandes.city as city',
                'users.name as user',
                'commandes.neighborhood as neighborhood',
                'commandes.building as building',
                'commandes.apartment as apartment',
                'restaurants.currency as currency',
                'commandes.livred as livred'
            )
                ->join('users', 'commandes.id_client', 'users.id')
                ->join('menu', 'menu.id', 'commandes.id_menu')
                ->join('restaurants', 'restaurants.id', 'commandes.id_Restaurant')
                ->where('commandes.id_Restaurant', $id)
                ->whereDate('commandes.date', $date)
                ->get();
            return view('Restaurant.orders', [
                'restaurant' => $restaurant,
                'orders' => $orders
            ]);
        } else {
            return redirect()->route('Restaurant.login_form');
        }
    }

    public function reservations()
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            $date = Carbon::today();
            $reservations = Reservation::select(
                'reservations.id as id',
                'users.name as name',
                'menu.plat as plat',
                'menu.description as description',
                'menu.main_image as main_image',
                'menu.id as id',
                'tables.placeNumber as placeNumber',
                'reservations.date as date',
                'reservations.time as time'
            )
                ->join('menu', 'menu.id', 'reservations.menuID')
                ->join('tables', 'tables.id', 'reservations.id_table')
                ->join('users', 'reservations.id_client', 'users.id')
                ->where('reservations.id_Restaurant', $id)
                ->whereDate('reservations.date', $date)
                ->get();
            // dd($reservations);
            return view('Restaurant.reservations', [
                'reservations' => $reservations,
                'restaurant' => $restaurant,
            ]);
        } else return redirect()->route('Restaurant.login_form');
    }

    public function menus()
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            $compteur = 0;
            $menus = Menu::where('menu.id_Restaurant', $id)
                ->get();
            return view('Restaurant.menu', [
                'menus' => $menus,
                'restaurant' => $restaurant
            ]);
        } else return redirect()->route('Restaurant.login_form');
    }

    public function menuDetails(Request $request)
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            $menu_id = $request->input('menu_id');
            $menu = Menu::find($menu_id);
            $images = ImgMenu::where('id_menu', $menu_id)->get();
            return view('Restaurant.menuDetails', [
                'menu' => $menu,
                'images' => $images,
                'restaurant' => $restaurant
            ]);
        } else redirect()->route('Restaurant.login_form');
    }

    public function update(Request $request)
    {
        $menu_id = $request->input('menu_id');
        $plat = $request->input('menu');
        $description = $request->input('description');
        $price = $request->input('price');
        $coins = $request->input('priceCoins');
        $pointsEarned = $request->input('earned');
        $menu = Menu::find($menu_id);
        if ($menu) {
            $menu->plat = $plat;
            $menu->description = $description;
            $menu->price = $price;
            $menu->priceCoins = $coins;
            $menu->pointsEarned = $pointsEarned;
            $menu->save();
            $message = 'updated successfully';
        } else {
            $message = 'update failed';
        }
        return redirect()->back()->with('message', $message);
    }

    public function addImages(Request $request)
    {
        $images = $request->file('images');
        $menu_id = $request->input('menu_id');
        foreach ($images as $image) {
            $imageName = 'images/' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $image_menu = new ImgMenu();
            $image_menu->id_menu = $menu_id;
            $image_menu->link = $imageName;
            $image_menu->save();
        }
        return redirect()->back()->with('succes', 'image uploaded successfully');
    }

    public function deleteimg(Request $request)
    {
        $image_id = $request->input('image_id');
        $image = ImgMenu::find($image_id);
        $image->delete();
        return redirect()->back();
    }

    public function main_image(Request $request)
    {
        $image = $request->file('image');
        $menu_id = $request->input('menu_id');
        $imageName = 'images/' . $image->getClientOriginalName();
        $image->move(public_path('images'), $imageName);
        $menu = Menu::find($menu_id);
        $menu->main_image = $imageName;
        $menu->save();
        return redirect()->back()->with('succes', 'image uploaded successfully');
    }

    public function modifieMain(Request $request)
    {
        $main_image = $request->file('main_image');
        $menu_id = $request->input('menu_id');
        $imageName = 'images/' . $main_image->getClientOriginalName();
        $main_image->move(public_path('images'), $imageName);
        $menu = Menu::find($menu_id);
        $menu->main_image = $imageName;
        $menu->save();
        return redirect()->back()->with('succes', 'image updated successfully');
    }

    public function delete_main_image(Request $request)
    {
        $menu_id = $request->input('menu_id');
        $menu = Menu::find($menu_id);
        $menu->main_image = "images/defaultmain2.jpeg";
        $menu->save();
        return redirect()->back()->with('succes', 'image deleted successfully');
    }

    public function feedbacks()
    {
        $id = Session::get('Restaurant_id');
        $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
            ->where('restaurants.id', $id)
            ->first();
        $menus = Menu::where('id_Restaurant', $id)->get();
        return view('Restaurant.feedbacks', ['menus' => $menus, 'restaurant' => $restaurant]);
    }

    public function menu_feedbacks(Request $request)
    {
        $id = Session::get('Restaurant_id');
        $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
            ->where('restaurants.id', $id)
            ->first();
        $menu_id = $request->input('menu_id');
        $feedbacks = Review::join('users', 'users.id', 'reviews.user_id')
            ->where('reviews.menu_id', $menu_id)
            ->get();
        return view('Restaurant.menuFeedbacks', [
            'feedbacks' => $feedbacks,
            'restaurant' => $restaurant
        ]);
    }
    //this methode diplay discounts view
    public function discounts(Request $request)
    {
        $id = Session::get('Restaurant_id');
        $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
            ->where('restaurants.id', $id)
            ->first();
        $menus = Menu::where('menu.id_Restaurant', $id)
            ->get();
        return view('Restaurant.discounts', ['menus' => $menus, 'restaurant' => $restaurant]);
    }

    public function change_discount(Request $request)
    {
        $menu_id = $request->input('menu_id');
        $discount = $request->input('percentage');
        $menu = Menu::find($menu_id);
        $menu->discount = $discount;
        $menu->save();
        return redirect()->back();
    }
    //this function return MyRestaurant view
    public function my_restaurant()
    {
        $id = Session::get('Restaurant_id');
        $restaurant = Restaurant::join('owners', 'restaurants.id', 'owners.restaurant_id')
            ->where('restaurants.id', $id)
            ->first();
        $message = '';
        return view('Restaurant.MyRestaurant', ['restaurant' => $restaurant,])->with('message');
    }

    public function modifie_Restaunant_infos(Request $request)
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $owner_image = $request->file('owner_image');
            $owner_name = $request->input('owner');
            $restaurant_name = $request->input('restaurant_name');
            $email = $request->input('email');
            $password = $request->input('password');
            $confirm_password = $request->input('confirm_password');
            $number_phone = $request->input('number_phone');
            $presentation = $request->input('presentation');
            $opening_time = $request->input('opening_time');
            $closing_time = $request->input('closing_time');
            $country = $request->input('country');
            $city = $request->input('city');
            $neighborhood = $request->input('neighborhood');
            $currency = $request->input('currency');
            $other = $request->input('other');
            if ($request->input('coins') == 'yes') $accept = true;
            else $accept = false;
            $owner = Owner::where('restaurant_id', $id)->first();
            $restaurant = Restaurant::find($id);
            $message = '';
            if ($password != $confirm_password) {
                $message = 'Passwords do not match. Please make sure both passwords are identical.';
                return redirect()->back()->with('message', $message);
            } else if (strlen($password) < 8) {
                $message = 'The password must be at least 8 characters.';
                return redirect()->back()->with('message', $message);
            } else {
                if ($owner_image) {
                    $image_name = 'images/' . $owner_image->getClientOriginalName();
                    $owner->profile = $image_name;
                    $owner->save();
                }
                if ($owner_name) {
                    $owner->owner = $owner_name;
                    $owner->save();
                }
                if ($restaurant_name) {
                    $restaurant->name = $restaurant_name;
                    $restaurant->save();
                }
                if ($email) {
                    $restaurant->email = $email;
                    $restaurant->save();
                }
                if ($number_phone) {
                    $restaurant->numberPhone = $number_phone;
                    $restaurant->save();
                }
                if ($presentation) {
                    $restaurant->small_Presentation = $presentation;
                    $restaurant->save();
                }
                if ($opening_time) {
                    $restaurant->timeOpen = $opening_time;
                    $restaurant->save();
                }
                if ($closing_time) {
                    $restaurant->timeClose = $closing_time;
                    $restaurant->save();
                }
                if ($country) {
                    $restaurant->country = $country;
                    $restaurant->save();
                }
                if ($city) {
                    $restaurant->city = $city;
                    $restaurant->save();
                }
                if ($neighborhood) {
                    $restaurant->neighborhood = $neighborhood;
                    $restaurant->save();
                }
                if ($other) {
                    $restaurant->other = $other;
                    $restaurant->save();
                }
                if ($currency) {
                    $restaurant->currency = $currency;
                    $restaurant->save();
                }
                $restaurant->coins = $accept;
                $restaurant->save();
                $message = "updated successfully.";
                return redirect()->back()->with('message', $message);
            }
        } else return redirect()->route('Restaurant.login_form');
    }

    public function modifie_main_image(Request $request)
    {
        $id = Session::get('Restaurant_id');
        $image = $request->file('image');
        $image_name = 'images/' . $image->getClientOriginalName();
        $restaurant = Restaurant::find($id);
        $restaurant->main_image = $image_name;
        $restaurant->save();
        return redirect()->back();
    }

    public function add_menu_view()
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            return view('Restaurant.addMenu', ['restaurant' => $restaurant]);
        } else return redirect()->route('Restaurant.login_form');
    }

    public function add_menu(Request $request)
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $mainImage = $request->file('main_image');
            $image_name = 'images/' . $mainImage->getClientOriginalName();
            $menu = $request->input('menu');
            $description = $request->input('description');
            $price = $request->input('price');
            // $currency = $request->input('currency');

            $new_menu = new Menu();
            $new_menu->id_Restaurant = $id;
            $new_menu->main_image = $image_name;
            $new_menu->plat = $menu;
            $new_menu->description = $description;
            $mainImage->move(public_path('images'), $image_name);
            $new_menu->price = $price;
            // $new_menu->currency = $currency;
            $new_menu->save();
            $newMenu_id = $new_menu->id;
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $image) {
                    $imageName = 'images/' . $image->getClientOriginalName();
                    $image->move(public_path('images'), $imageName);
                    $image_menu = new ImgMenu();
                    $image_menu->id_menu = $newMenu_id;
                    $image_menu->link = $imageName;
                    $image_menu->save();
                }
            }
            return redirect()->back()->with('message', 'inserted successfully');
        } else return redirect()->route('Restaurant.login_form');
    }

    public function tables()
    {
        $id = Session::get('Restaurant_id');
        if ($id) {
            $tables = Table::where('id_Restaurant', $id)->get();
            $restaurant = Restaurant::join('owners', 'owners.restaurant_id', 'restaurants.id')
                ->where('restaurants.id', $id)
                ->first();
            return view('Restaurant.tables', ['tables' => $tables, 'restaurant' => $restaurant]);
        } else return redirect()->route('Restaurant.login_form');
    }

    public function add_tables(Request $request)
    {
        $id = Session::get('Restaurant_id');
        // dd($id);
        if ($id) {
            $places = $request->input('table');
            $new_table = new Table();
            $new_table->placeNumber = $places;
            $new_table->id_Restaurant = $id;
            $new_table->save();
            return redirect()->back()->with('message', 'add it successfully');
        } else return redirect()->route('Restaurant.login_form');
    }
}
