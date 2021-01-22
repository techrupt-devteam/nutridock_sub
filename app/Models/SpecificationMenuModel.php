<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SpecificationMenuModel extends Model 
{
    protected $table = 'menu_specification';

    protected $fillable = [
                            'menu_id',
                            'icon_image',
                            'specification_id'
                        ];
}
	