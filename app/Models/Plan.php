<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Plan extends Model
{
    protected $table 	   = "nutri_mst_plan";
    protected $primaryKey  = "plan_id";
    protected $fillable = [
		"plan_name",
		"is_active",
		"is_deleted"
	];
}
