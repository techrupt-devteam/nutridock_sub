<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Module extends Model
{
    protected $table 	   = "module";
    protected $primaryKey  = "module_id";
    protected $fillable = [
		"module_name",
		"type_id",
        "module_url"
    ];

    public function ModuleType()
    {
        return $this->belongsTo('App\Model\ModuleType','type_id');
    }
}
