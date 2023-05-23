<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Restaurant;

class RestaurantController extends Controller
{
    public function index(){
        return view('Restaurant.login_form');
    }

    public function dashboard(){
        return view('Restaurant.dashboard');
    }

    public function login(Request $request){
        $data=$request->all();
        // dd($data);
        $bool=0;
        if(Auth::guard('Restaurant')->attempt(['email'=>$data['email'],'password'=>$data['password']])){
           $bool=1;
            return redirect()->route('Restaurant.dashborad')->with('bool', $bool);
        }
        else{
            return back()->with('bool', $bool);
        }
    }
}
