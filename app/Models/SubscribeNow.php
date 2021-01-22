<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscribeNow extends Model 
{
    protected $table = 'subscribe_now';
    protected $fillable = [
    						'name',
    						'email',
    						'phone_no',
    						'session_id',
    						'age',
    						'gender',
    						'weight',
    						'height_in_feet',
    						'height_in_inches',
    						'physical_activity_id',
    						'avoid_or_dislike_food_id',
    						'other_food',
                            'total',
                            'price',
    						'food_precautions',
    						'lifestyle_disease',
    						'start_date',
    						'subscribe_now_plan_id',
    						'subscribe_now_plan_duration_id',
    						'subscription_id',
                            'meal_type_id',
                            'address1_meal',
                            'address2_meal',
    						'address1',
    						'pincode1',
    						'address2',
    						'pincode2',
                            'comments',
                            'link',
                            'approve_status',
                            'payment_status',
                            'transaction_id'
						  ];

     public static function getData(){
        $data = SubscribeNow::select('*')
                ->where('is_deleted', 'No')                        
                ->get()->toArray();
        return $data;
    }
}

