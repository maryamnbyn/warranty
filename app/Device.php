<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'user_id', 'token','device','code'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class ,'user_device');
    }
}
