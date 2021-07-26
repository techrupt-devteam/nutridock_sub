<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Link extends Model 
{
    protected $table = 'nutri_mst_link';

    protected $fillable = [
                            'story_id',
                            'link_name',
                            'link',
                            'cdate',
    	                    'short_description',
    	                    'image',
                            'is_active'
                        ];
}
	