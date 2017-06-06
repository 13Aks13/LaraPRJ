<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\UserStatus;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $statuses = UserStatus::all();
        $users = User::where('role_id', '=', 2)->where('isBlocked', '=', false)->get();

        return view('home')->with(['users' => $users, 'statuses' => $statuses]);
    }

    public function dashboard()
    {
        $user = Auth::user();
        $statuses = UserStatus::all();

        return view('pages.dashboard')->with(['user' => $user, 'statuses' => $statuses]);

    }

}
