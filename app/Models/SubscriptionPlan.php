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
		"is_deleted",
        "plan_description",
        "icon_image"
	];


	public static function getData(){
        $data = SubscriptionPlan::select('sub_plan_id','sub_name','city','area')
                ->where('is_active', '1')    
                ->where('is_deleted', '0')                        
                ->get()->toArray();

        return $data;
    }
}
