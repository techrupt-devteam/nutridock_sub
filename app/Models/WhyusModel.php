<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WhyusModel extends Model 
{
    protected $table = 'why_us';

    protected $fillable = [
                            'description',
                            'title',
                            'title_description',
                            'image'
                          ];
}
	