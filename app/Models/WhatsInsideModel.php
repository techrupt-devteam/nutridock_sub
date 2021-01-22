<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class WhatsInsideModel extends Model 
{
    protected $table = 'whats_inside';

    protected $fillable = [
                            'title',
                            'unit',
                            'menu_id'
                        ];
}
	