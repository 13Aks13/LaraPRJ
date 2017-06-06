<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::where('role_id', '=', '2')->where('isBlocked', '=', false)->get();

        return view('dashboard')->with(['users' => $users]);
    }
}
