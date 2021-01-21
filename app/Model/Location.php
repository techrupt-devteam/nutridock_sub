<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Location extends Model
{
    protected $table 	   = "locations";
    protected $primaryKey  = "id";
    protected $fillable = [
		"city_id",
		"area",
		"is_active"
	];

}
