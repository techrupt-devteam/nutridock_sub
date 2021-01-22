<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TopCategoriesModel extends Model 
{
    protected $table = 'topcategories';

    protected $fillable = [
                            'type',
                            'dish_name',
                            'description',
                            'image',
                            'dish_special'
                          ];
}
	