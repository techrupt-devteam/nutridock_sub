<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class SubscriptionPlan extends Model
{
    protected $table 	   = "nutri_mst_subscription_plan";
    protected $primaryKey  = "sub_plan_id";
    protected $fillable = [
		"sub_name",
		"city",
		"area",
		"plan_id",
		"is_active",
		"is_deleted"
	];
}
