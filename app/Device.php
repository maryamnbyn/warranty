<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $table = "devices";

    protected $fillable = [
        'user_id', 'token','uu_id','code'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
