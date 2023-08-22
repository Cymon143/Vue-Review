<?php

namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $short_school_name = Setting::where('name','short_school_name')->first();
        $school_name = Setting::where('name','school_name')->first();
        $data_school_logo = Setting::where('name','school_logo')->first();
        if($data_school_logo){
            $school_logo = $data_school_logo->value;
        }
        else{
            $school_logo = '/images/5aae503e4f037a5a4375944d8861fb6a.png';
        }
        $user = User::find(Auth::user()->id);
        if(!$user->image){
            $user->image = '/images/default_image.png';
            $user->save();
        }
        return view('home', compact('short_school_name','school_name','school_logo'));
    }
}
