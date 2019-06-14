<?php

namespace App;

use App\Events\SMSCreated;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'date
         time',
    ];

    public function devices()
    {
        return $this->belongsToMany(Device::class , 'user_device' );
    }

    public function sendSMS($action ,$UUID = null, $digit = null)
    {
        if (is_null($digit)) $digit = config('verify.digit');

        $random_number = rand(pow(10, $digit - 1), pow(10, $digit) - 1);

        $device =  $this->devices()->where('device', $UUID)->first();

            if (! empty($device)) {

                // Update Existed Device
                $device->update(['code' => $random_number]);

            } else {
                //Create new Device
                $device = ($this->devices())->create(['device' => $UUID , 'code' =>$random_number ]);
            }

        // Create SMS Message
       $text =  __('messages.'. $action , ['user' => $this->name, 'code' => $device->code]);

       // Send Verification SMS
        event(new SMSCreated($this->phone, $text));
    }


    public function sendSMSUpdate($action , $UUID ,$phone , $digit = null)
    {
        if (is_null($digit)) $digit = config('verify.digit');

        $random_number = rand(pow(10, $digit - 1), pow(10, $digit) - 1);

        $device =  $this->devices()->where('device', $UUID)->first();

        if (! empty($device)) {

            // Update Existed Device
            $device->update(['code' => $random_number]);

        } else {
            //Create new Device
            $device = ($this->devices())->create(['device' => $UUID , 'code' =>$random_number ]);
        }

        // Create SMS Message
        $text =  __('messages.'. $action , ['user' => $this->name, 'code' => $device->code]);

        // Send Verification SMS
        event(new SMSCreated($phone, $text));
    }

}
