<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // echo ;
        return view('home');
    }

    public function changeTheme($theme) /* theme 0 ==> light , theme 1 ==> dark */
    {

        $user = Auth::user();
        if ($theme == 'dark') {
            $user->theme = 1;
        } elseif ($theme == 'light') {
            $user->theme = 0;
        } 
        $a = $user->save();
        return redirect()->back();
    }
}
