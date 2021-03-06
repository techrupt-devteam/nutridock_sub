<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class DeliveryLocation extends Model
{
    protected $table 	   = "nutri_mst_delivery_location";
    protected $primaryKey  = "delivery_location_id  ";

    protected $fillable = [
		"delivery_pincode",
		"delivery_city_id"
	];


  


}
