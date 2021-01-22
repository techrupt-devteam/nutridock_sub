<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BenefitsModel extends Model 
{
    protected $table = 'benefits';

    protected $fillable = [
                            'title',
                            'blog_id',
    	                    'title_description',
    	                    'description',
                            'image'
                        ];
}
	