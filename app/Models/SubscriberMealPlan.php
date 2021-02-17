<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberMealPlan extends Model 
{
    protected $table = 'nutri_mst_subscriber_meal_program';
    protected $fillable = [
    						'subcriber_id',
							'nutritionist_id',
							'sub_plan_id',
							'breakfast',
							'lunch',
							'dinner',
							'snack',
							'is_active',	
							'is_deleted'    						
						  ];

    
}

