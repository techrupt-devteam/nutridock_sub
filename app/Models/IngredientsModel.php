<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class IngredientsModel extends Model 
{
    protected $table = 'ingredients';

    protected $fillable = [
                            'name',
                            'menu_id',
                            'image'
                        ];
}
	