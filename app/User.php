<?php

namespace App;

use Carbon\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements JWTSubject
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

    //protected $with = ['profile'];

    public function setPasswordAttribute($value){
        $this->attributes['password'] = bcrypt($value);
    }
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
        return $this->hasOne('App\Models\Profile');
    }
    public function papers(){
        return $this->hasManyThrough(
            'App\Models\Paper','App\Models\Profile','user_id','profile_id');
    }

    // Backward
    public function role(){
        return $this->belongsTo('App\Models\Role');
    }
    /**
     * Send a password reset email to the user
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordToken($token));
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            'type' => $this->type,
        ];
    }
}
