<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Eloquent;
class  AssignLocationMenu extends Model
{
    protected $table 	   = "nutri_mst_assign_location_menu";
    protected $primaryKey  = "assign_menu_id";
    protected $fillable    = [
		"menu_id",
		"state_id",
		"city_id",
		"area_id",
		"is_active",
		"is_deleted"
	];

}
