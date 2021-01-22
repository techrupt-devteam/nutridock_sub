<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SurveyModel extends Model 
{
    protected $table = 'survey';

    protected $fillable = [
                            'download_app',
    	                    'comments',
    	                    'refrains'
                        ];
}
	