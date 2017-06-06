<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 27.04.17
 * Time: 8:19
 */

namespace App\Http\Controllers;

use App\Models\UserStatusChanging;
use Illuminate\Http\Request;


class UserStatusChangingController
{
    public function store(Request $request)
    {
        $user_status_changing = new UserStatusChanging();
        $user_status_changing->save($request->all());
    }

}