<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class PushNotification extends Model
{
    protected $table 	   = "nutri_mst_push_notification";
    protected $primaryKey  = "push_notification_id";
    protected $fillable = [
		"notification_name",
		"kitchen_id",
		"state_id",
		"city_id",
		"area_id",
		"user_id",
		"is_active",
		"is_deleted"
	];
}
