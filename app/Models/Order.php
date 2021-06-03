<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table 	   = "nutri_trn_order_history";
    protected $primaryKey  = "order_id";
    protected $fillable    = 
    [	
		"bill_no",
		"bill_id",
		"order_no",
		"order_status",
		"menu_id",
		"program_id",
		"order_resend",
		"mealtype",				
		"subscriber_id",	
		"subscriber_dtl_id",
		"nutritionist_id",	
		"mobile",	
		"state",	
		"city",
		"customer_key",	
		"bill_date",
		"created_at",
		"updated_at",
		"login_user_id",
	];
}
