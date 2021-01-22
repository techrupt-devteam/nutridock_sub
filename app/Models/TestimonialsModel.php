<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class TestimonialsModel extends Model 
{
    protected $table = 'testimonials';

    protected $fillable = [
                            'name',
                            'post',
                            'details',
                            'image'
                          ];
}
	