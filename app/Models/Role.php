<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Role extends Model
{
    protected $table 	   = "role";
    protected $primaryKey  = "role_id";
    protected $fillable = [
		"role_name"
	];

	public function Module()
    {
        return $this->hasMany('App\Models\Module','type_id');
    }

    

}
