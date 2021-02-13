<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscriberDetails extends Model 
{
    protected $table = 'nutri_dtl_subscriber';
    protected $fillable = [
    						'subscriber_id',
    						'subscriber_name',
    						'subscriber_age',
                            'subscriber_gender',  
                            'subscriber_weight',      						
                            'subscriber_height_in_feet',  
                            'subscriber_height_in_inches',  
                            'physical_activity_id',  
                            'avoid_or_dislike_food_id',  
                            'other_food',  
                            'lifestyle_disease',  
                            'food_precautions',  
                            'coupon_code_id',  
                            'total',  
                            'discount',  
                            'price',  
                            'start_date',  
                            'expiry_date',  
                            'extended_date',  
                            'sub_plan_id',  
                            'duration_id',  
                            'meal_type_id',  
                            'address1',  
                            'pincode1',  
                            'address1_deliver_mealtype',  
                            'address2',  
                            'pincode2', 
                            'address2_deliver_mealtype',  
                            'state',  
                            'city',  
                            'session_id',  
                            'transaction_id',  
                            'subscription_id',  
						  ];

    
}

