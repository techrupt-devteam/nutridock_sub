<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SubscribeNowPlanDuration extends Model 
{
    protected $table = 'subscribe_now_plan_duration';
    protected $fillable = [
        'subscribe_now_plan_duration_id',
        'subscribe_now_plan_id',
        'subscribe_now_duration',
        'subscribe_now_price_per_meal',
        'subscribe_now_pkg_price'
        ];

   
}
?>