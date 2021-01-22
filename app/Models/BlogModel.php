<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class BlogModel extends Model 
{
    protected $table = 'blog';

    protected $fillable = [
                            'blog_title',
                            'category_id',
    	                    'blog_description',
                            'image',
                            'link',
                            'meta_title',
                            'meta_keywords',
                            'meta_description',
                            'image_title',
                            'image_description'
                        ];
}
	