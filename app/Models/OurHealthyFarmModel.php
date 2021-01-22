<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OurHealthyFarmModel extends Model 
{
    protected $table = 'our_healthy_farm';

    protected $fillable = [
                            'description',
                            'title',
                            'title_description'
                          ];
}
	