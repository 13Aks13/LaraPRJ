<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use File;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'goal',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $avatarPath = '/storage/avatars';

    /*
     *   Custome Methods
     */
    public function getAvatarStoragePath()
    {
        return $this->avatarPath . '/' . $this->id;
    }

    public function getAvatarStorageFullPath()
    {
        $path = public_path() . $this->getAvatarStoragePath();
        if(!is_dir($path)) {
            File::makeDirectory($path, 0775, true);
        }
        return $path;
    }

    public function getAvatarAttribute($value)
    {
        if (is_null($value)) {
            return null;
        } else {
            return $this->getAvatarStoragePath() . '/' . $value;
        }
    }

    public function deleteAvatar()
    {
        if (!is_null($this->avatar)) {
            $file = public_path() . $this->avatar;

            if (is_file($file)) {
                unlink($file);
                $this->avatar = null;
            }
        }
        return true;
    }

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'assigneTo_id', 'id');
    }

    public function createdTasks()
    {
        return $this->hasMany('App\Models\Task', 'createdBy_id', 'id');
    }

    public function isAdmin()
    {
        if ($this->role->title === 'role_admin') {
            return true;
        } else {
            return false;
        }
    }

    public function userStatus()
    {
        return $this->belongsTo('App\Models\UserStatus', 'status_id', 'id');
    }
}
