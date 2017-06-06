<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function summary(Request $request)
    {
        $from = null;
        $to = null;

        $range = $request->get('range', '');
        $users = User::where('role_id', '=', 2)->get();

        if($range !== '') {
            $dates = explode(' - ', $range);
            $from = Carbon::createFromFormat('m/d/Y', $dates[0])->toDateString() . ' 00:00:00';
            $to = Carbon::createFromFormat('m/d/Y', $dates[1])->toDateString() . ' 23:59:59';
        }
        return view('reports.summary')->with([
            'users' => $users,
            'range' => $range,
            'from' => $from,
            'to' => $to,
        ]);
    }

    public function personal(Request $request)
    {
        $from = null;
        $to = null;

        $range = $request->get('range', '');
        $user = $request->get('user', '');
        $users = User::where('role_id', '=', 2)->get();

        if($range !== '') {
            $dates = explode(' - ', $range);
            $from = Carbon::createFromFormat('m/d/Y', $dates[0])->toDateString() . ' 00:00:00';
            $to = Carbon::createFromFormat('m/d/Y', $dates[1])->toDateString() . ' 23:59:59';
        } else {
            $dates = '';
        }

        if($user !== '') {
            $user = User::find($user);
        }
        return view('reports.personal')->with([
            'users' => $users,
            'user' => $user,
            'range' => $range,
            'from' => $from,
            'to' => $to,
        ]);
    }
}
