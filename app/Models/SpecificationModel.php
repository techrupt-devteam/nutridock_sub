<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SpecificationModel extends Model 
{
    protected $table = 'specification';

    protected $fillable = [
                            'name'
                        ];
}
	