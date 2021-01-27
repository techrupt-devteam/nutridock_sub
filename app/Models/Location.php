<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Location extends Model
{
    protected $table 	   = "locations";
    protected $primaryKey  = "id";
    protected $fillable = [
		"city",
		"area",
		"state",
		"is_active"
	];

}
