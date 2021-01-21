<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class City extends Model
{
    protected $table 	   = "city";
    protected $primaryKey  = "id";
    protected $fillable = [
    	"city_name",
    	"state_id"
	];

}
