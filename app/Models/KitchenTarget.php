<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitchenTarget extends Model
{
    protected $table 	   = "nutri_trn_kitchen_target";
    protected $primaryKey  = "target_kitchen_id";
    protected $fillable    = 
    [
    	"kitchen_id",
		"month",
		"year",
		"target_amt",
		"achive_amt",
		"user_id",
		
    ];
}
