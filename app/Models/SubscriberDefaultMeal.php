<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberDefaultMeal extends Model 
{
    protected $table = 'nutri_subscriber_meal_program';
    protected $fillable = [
							'sub_plan_id',
							'duration_id', 
							'day',
							'mealtype',   
							'menu_id',
							'subcriber_id',
							'nutritionist_id',
							'meal_on_date',
							'compenset_date',
							'skip_meal_flag'
                         ];
}