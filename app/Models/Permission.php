<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Permission extends Model
{
    protected $table 	   = "permission";
    protected $primaryKey  = "per_id";
    protected $fillable = [
		"role_id",
		"type_id",
        "permission_access"
    ];

    public function ModuleType()
    {
        return $this->belongsTo('App\Models\ModuleType','type_id');
    }




}
