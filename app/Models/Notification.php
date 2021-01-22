<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
	use SoftDeletes;
	
    protected $table 	   = "promotional_notification";
    protected $primaryKey  = "id";

    protected $fillable = [
		"title",
		"description",
		"notification_type",
		"region",
		"users",
		"created_at",
		"updated_at",
    ];
}