<?php

namespace App;

use Carbon\Carbon;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','bio','photo','type','created_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $dates=['created_at'];
   /* public function getCreatedAtAttribute($value){
        return  Carbon::parse($value)->diffForHumans();
    }*/
    // Forward
    public function profile(){
        return $this->hasOne('App\Profile');
    }
    public function papers(){
        return $this->hasManyThrough(
            'App\Paper','App\Profile','user_id','profile_id');
    }

    // Backward
    public function role(){
        return $this->belongsTo('App\Role');
    }
    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }
}
