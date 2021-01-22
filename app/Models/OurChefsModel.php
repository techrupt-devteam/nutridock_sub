<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OurChefsModel extends Model 
{
    protected $table = 'our_chefs';

    protected $fillable = [
                            'name',
                            'image',
                            'post',
                            'description'
                          ];
}
	