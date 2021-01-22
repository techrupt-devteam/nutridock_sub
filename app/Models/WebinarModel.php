<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WebinarModel extends Model 
{
    protected $table = 'webinar';

    protected $fillable = [
                            'name',
    	                    'email',
                            'mobile',
                            'city',
                            'age',
                            'amount',
                            'webinar_date'
                        ];
}
	