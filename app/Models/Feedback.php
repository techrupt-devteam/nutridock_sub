<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'nutri_mst_feedback';

    protected $fillable = [
                            'name',
                            'email',
                            'mobile_no',
                            'feedback',
                            'city',
                            'area',
                            'updated_at',
                            'created_at'
                          ];
}
	