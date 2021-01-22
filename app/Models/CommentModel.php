<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CommentModel extends Model 
{
    protected $table = 'comments';

    protected $fillable = [
                            'name',
                            'email',
                            'website',
    	                    'message',
    	                    'blog_id',
    	                    'created_at'
                          ];
}
	