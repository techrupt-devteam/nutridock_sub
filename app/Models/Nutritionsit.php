<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Nutritionsit extends Model
{
    protected $table 	   = "nutri_mst_nutritionsit";
    protected $primaryKey  = "nutritionsit_id";
    protected $fillable = [
		"nutritionsit_name",
		"nutritionsit_email",
		"nutritionsit_mobile",
		"nutritionsit_state",
		"nutritionsit_city",
		"nutritionsit_area"
	];

}
