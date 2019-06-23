<?php

namespace App;

use App\Events\SMSCreated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;


    protected $fillable = [
        'name', 'phone'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'date
         time',
    ];

    public function devices()
    {
        return $this->belongsToMany(Device::class , );
    }

    public function products()
    {
        return $this->hasMany(Product::class );
    }

    public function sendSMS($action ,$UUID = null, $digit = null)
    {
        if (is_null($digit)) $digit = config('verify.digit');

        $random_number = rand(pow(10, $digit - 1), pow(10, $digit) - 1);

        $device =  $this->devices()->where('uu_id', $UUID)->first();

            if (! empty($device)) {

                $device->update(['code' => $random_number]);

            } else {

                $device = ($this->devices())->create(['uu_id' => $UUID , 'code' =>$random_number ]);
            }

       $text =  __('messages.'. $action , ['user' => $this->name, 'code' => $device->code]);

        event(new SMSCreated($this->phone, $text));
    }

    public function sendSMSUpdate($action , $UUID ,$phone , $digit = null)
    {
       // if (is_null($digit)) $digit = config('verify.digit');
        $digit = $digit ?? config('verify.digit');


        $random_number = rand(pow(10, $digit - 1), pow(10, $digit) - 1);

        $device =  $this->devices()->where('uu_id', $UUID)->first();

        if (! empty($device)) {

            $device->update(['code' => $random_number]);

        } else {

            $device = ($this->devices())->create(['uu_id' => $UUID , 'code' =>$random_number ]);
        }

        $text =  __('messages.'. $action , ['user' => $this->name, 'code' => $device->code]);

        event(new SMSCreated($phone, $text));
    }

}
