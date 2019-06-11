<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firebase extends Model
{
    protected $fillable = [
        'user_id', 'token','device','code'
    ];

    public function makeVerifyCode($digit = null)
    {
        if (is_null($digit)){

            $digit = config('verify.digit');
        }

        $random_number = rand(pow(10, $digit - 1), pow(10, $digit) - 1);
        $this->update([
            'code' => $random_number
        ]);

        return $this->code;
    }
}
