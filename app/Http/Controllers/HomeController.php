<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Validator;
use App\Http\Services\User as ServiceUser;
use App\Http\Services\Main;
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
    public function loginDr() {
        //print "ddd";
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (!Auth::check()) {
            return View("auth.main");
        }
        else if (Auth::User()->type == "user") {
            return Redirect()->route("users.main",['year' => 2022,'month' => '09','day' => 20]);
        }
        else {
            return Redirect()->route("doctor.main");
        }
    }

 
    public function register() {
        return View("auth.register");
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    
    
}
