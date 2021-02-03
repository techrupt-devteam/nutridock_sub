<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SpecificationModel extends Model 
{
    protected $table = 'nutri_mst_menu_specification';
    protected $primaryKey  = "id";
    protected $fillable = [
                            'specification_title',
                            'icon_image'
                          ];
}
	