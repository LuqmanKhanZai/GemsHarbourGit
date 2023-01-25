<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
         $user = Auth::user();
        if($user->type == "Admin" ){
            $sellers = User::seller()->count();
            $buyers = User::buyer()->count();
            $products = Product::count();
            return view('home',get_defined_vars());

        }else{
            Auth::logout();
            Alert()->warning('WarningAlert','Sorry, You Are UnAuthorize');
            return view('auth.login');
        }
    }

    public function profile()
    {
        $user = Auth::user();
        return view('admin.profile.index',compact('user'));
    }
}
