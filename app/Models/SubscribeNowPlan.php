<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class SubscribeNowPlan extends Model 
{
    protected $table = 'subscribe_now_plan';
    protected $fillable = ['subscribe_now_plan_id ','subscribe_now_plan_name'];

    public static function getData(){
        $getData = SubscribeNowPlan::select('subscribe_now_plan_id','subscribe_now_plan_name')
                ->where('is_active', '1')                          
                ->get()->toArray();        
       
        foreach($getData as $getDataValue) {        
            Arr::set($data,'name', $getDataValue['subscribe_now_plan_name']);            
            
            $getSubscribeNowPlanData = SubscribeNowPlanDuration::select('subscribe_now_plan_duration_id','subscribe_now_duration','subscribe_now_price_per_meal','subscribe_now_pkg_price')
                        ->where('subscribe_now_plan_id', $getDataValue['subscribe_now_plan_id']) 
                        ->where('is_active', '1')                          
                        ->get()->toArray();

            Arr::set($data,'duration', $getSubscribeNowPlanData);             

        }        
         
        return $data;
    }
}
?>