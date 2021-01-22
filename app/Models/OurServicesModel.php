<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OurServicesModel extends Model 
{
    protected $table = 'our_services';

    protected $fillable = [
                            'description',
                            'icon_image',
                            'title',
                            'title_description'
                          ];
}
	