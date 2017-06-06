<?php
/**
 * Created by PhpStorm.
 * User: adreik
 * Date: 25.04.17
 * Time: 11:21
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStatus extends Model
{

    /*
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'color'
    ];


    /*
     *   Custome Methods
     */
    public function getStatusName()
    {
        return $this->name;
    }

    public function getStatusColor()
    {
        return $this->color;
    }


    public function users()
    {
        return $this->hasMany('App\Models\User');
    }


}