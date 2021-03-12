<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Gst extends Model
{
    protected $table 	   = "nutri_mst_gst_setting";
    protected $primaryKey  = "gst_id";
    protected $fillable = [
		"state_id",
		"cgst",
		"sgst",
		"igst"
	];
}
