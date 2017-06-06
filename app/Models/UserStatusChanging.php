<?php


namespace App\Models;


class UserStatusChanging
{
    public function users()
    {
        return $this->hasMany('App\Models\User');
    }

    public function userstatus()
    {
        return $this->hasMany('App\Models\UserStatus');
    }

}