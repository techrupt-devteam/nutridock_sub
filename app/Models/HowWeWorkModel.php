<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class HowWeWorkModel extends Model 
{
    protected $table = 'how_we_work';

    protected $fillable = [
                            'title',
                            'icon_image',
                            'description'
                          ];
}
	