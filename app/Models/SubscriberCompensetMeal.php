<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberCompensetMeal extends Model 
{
    protected $table = 'nutri_subscriber_compenset_meal_program';
    protected $fillable = [
							'program_id',
							'sub_plan_id',
							'duration_id', 
							'day',
							'mealtype',   
							'menu_id',
							'is_active',
							'subcriber_id',
							'nutritionist_id',
							'meal_on_date',
							'compenset_date',
							'skip_meal_flag',
							'is_deleted'
                         ];
}