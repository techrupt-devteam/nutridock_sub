<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleType extends Model
{
    protected $table 	   = "module_type";
    protected $primaryKey  = "type_id";
    protected $fillable = [
		"type_name",
		"type_id"
    ];
    public function Module()
    {
        return $this->hasMany('App\Models\Module','type_id');
    } 

    public function Permission()
    {
        return $this->hasMany('App\Models\Permission','type_id');
    }
}
