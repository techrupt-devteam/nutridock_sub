<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class State extends Model
{
    protected $table 	   = "State";
    protected $primaryKey  = "id";
    protected $fillable = [
    	"name"
	];

}
