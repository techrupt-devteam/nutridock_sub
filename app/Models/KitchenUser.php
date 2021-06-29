<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KitchenUser extends Model
{
    protected $table 	   = "nutri_mst_kitchen_users";
    protected $primaryKey  = "kitchen_user_id ";
    protected $fillable    = 
    [
    	"kitchen_id",
		"user_id",
		"role_id",
		"created_at",
		"updated_at",
		"deleted_at"
		
    ];
}
