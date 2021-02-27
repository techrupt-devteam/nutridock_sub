<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class AssignSubcriptionplanMenu extends Model 
{
    protected $table = 'nutri_mst_assign_subscription_plan_menu';
    protected $fillable = [
                            'sub_plan_id',
                            'menu_id'
                         ];
}
	