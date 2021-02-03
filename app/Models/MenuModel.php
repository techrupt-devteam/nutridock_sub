<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model 
{
    protected $table = 'nutri_mst_menu';

    protected $fillable = [
                            'menu_title',
                            'menu_category_id',
    	                    'menu_description',
    	                    'what_makes_dish_special',
                            'image',
                            'specification_id',
                            'multiple_image',
                            'ingredients',
                            'calories',
                            'proteins',
                            'carbohydrates',
                            'fats'
                        ];
}
	