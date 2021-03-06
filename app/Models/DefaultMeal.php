<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class DefaultMeal extends Model 
{
    protected $table = 'nutri_mst_default_meal';
    protected $fillable = [
							'sub_plan_id',
							'duration_id', 
							'day',
							'mealtype',   
							'menu_id'
                         ];
}