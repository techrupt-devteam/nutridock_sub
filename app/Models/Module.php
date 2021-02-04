<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Eloquent;
class Module extends Model
{
    protected $table 	   = "module";
    protected $primaryKey  = "module_id";
    protected $fillable = [
		"module_name",
		"parent_id",
        "type_id",
        "module_url",
        "module_url_slug"

    ];

    public function ModuleType()
    {
        return $this->belongsTo('App\Models\ModuleType','type_id');
    }
}
