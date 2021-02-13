<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberMaster extends Model 
{
    protected $table = 'nutri_mst_subscriber';
    protected $fillable = [
    						'email',
    						'password',
    						'mobile',    						
						  ];

    
}

