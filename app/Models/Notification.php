<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{

    protected $table 	   = "nutri_notification";
    protected $primaryKey  = "notification_id";
    protected $fillable = [
		"message",
		"users_role",
		"user_id",
		"is_active",
		"created_at",
		"updated_at",
    ];
}