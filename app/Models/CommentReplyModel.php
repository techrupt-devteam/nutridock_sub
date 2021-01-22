<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CommentReplyModel extends Model 
{
    protected $table = 'comments_reply';

    protected $fillable = [
                            'comment_id',
                            'reply',
    	                    'blog_id',
    	                    'message'
                          ];
}
	