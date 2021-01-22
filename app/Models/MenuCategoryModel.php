<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MenuCategoryModel extends Model 
{
    protected $table = 'categories';

    protected $fillable = [
                            'name'
                        ];
}
	