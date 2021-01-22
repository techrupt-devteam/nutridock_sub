<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Session;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Auth;
//use Session;

// use Tymon\JWTAuth\Contracts\JWTSubject;

class WebAdmin extends Model implements Authenticatable, CanResetPasswordContract
{
    use AuthenticableTrait, CanResetPassword, Notifiable;

    protected $hidden = array('password', 'remember_token');

    


    protected $table = 'users';

    //protected $fillable = ['user_name','name','email','password','contact','address','profile_image','role','otp','expired_on'];

     protected $fillable = ['name','email','password'];

  
}