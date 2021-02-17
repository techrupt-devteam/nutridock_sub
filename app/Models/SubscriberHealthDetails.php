<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberHealthDetails extends Model 
{
    protected $table = 'nutri_mst_subscriber_health_details';
    protected $fillable = [ 
    						'subcriber_id',
							'nutritionist_id',
							'current_wt',
							'bmr',
							'bmi',
							'body_fat',
							'req_calories',
							'protein',
							'fat',
							'fiber',
							'carbs',
							'is_active',
							'is_delete'		
						  ];

    
}


