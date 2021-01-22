<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriptionModel extends Model 
{
    protected $table = 'subscription';

    protected $fillable = [
                            'email',
                            'name'
                          ];
}
	