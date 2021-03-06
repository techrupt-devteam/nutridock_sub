<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
use Session;

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

        $getCity = DeliveryLocation::select('delivery_city_id')
                    ->where('delivery_pincode', Session::get('delivery_pincode'))
                    ->first();
         

        $data = SubscriptionPlan::select('sub_plan_id','sub_name','city','area','icon_image')
                ->where('is_active', '1')    
                ->where('is_deleted', '0')      
                ->where('city', $getCity['delivery_city_id'])                               
                ->get()->toArray();

        return $data;
    }
}
