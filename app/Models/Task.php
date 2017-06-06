<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'points',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\Note');
    }

    public function CreatedBy()
    {
        return $this->belongsTo('App\Models\User', 'createdBy_id', 'id');
    }

    public function AssigneTo()
    {
        return $this->belongsTo('App\Models\User', 'assigneTo_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }
}
