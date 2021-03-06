<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class SubscriptionPlanDetails extends Model
{
    protected $table 	   = "nutri_dtl_subscription_duration";
    protected $primaryKey  = "duration_id ";
    protected $fillable = [
		"duration",
		"price_per_meal",
		"price_per_pack",
		"discount_price",
		"sub_plan_id"
	];

}
