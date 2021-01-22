<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AboutusModel extends Model 
{
    protected $table = 'about_us';

    protected $fillable = [
                            'title',
                            'about',
                            'our_mission',
                            'our_goals'
                          ];
}
	