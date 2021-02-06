<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    protected $table 	   = "nutri_mst_kitchen";
    protected $primaryKey  = "kitchen_id ";
    protected $fillable    = 
    [
    	"kitchen_name",
		"state_id",
		"city_id",
		"area_id",
		"pincode",
		"address",
		"nutritionsit_id",
		"user_id",
		"menu_id",
		"sub_plan_id",
		"area_id",
		"customer_key",
		"is_deleted",
		""
    ];
}
