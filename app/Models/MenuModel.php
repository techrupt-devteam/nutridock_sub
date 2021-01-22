<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model 
{
    protected $table = 'menu';

    protected $fillable = [
                            'menu_title',
                            'menu_category_id',
    	                    'menu_description',
    	                    'what_makes_dish_special',
                            'image',
                            'multiple_image',
                            'specification',
                            'ingredients'
                        ];
}
	