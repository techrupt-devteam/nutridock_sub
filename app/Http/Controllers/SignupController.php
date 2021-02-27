<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Controllers\DateTime;
use App\Http\Requests;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Arr;


/* All the models included */
use App\Models\PhysicalActivity;
use App\Models\SubscribeNowPlan;
use App\Models\FoodAvoid;
use App\Models\MealType;
use App\Models\SubscribeNow;

use Session;
use Sentinel;
use DB;
use Validator;
use URL;
use Mail;
use Razorpay\Api\Api;

class SubscribeController extends Controller
{
    function __construct()
    {
        // $this->PhysicalActivity = new PhysicalActivity();
    }
    
    public function index() {  
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;

        /* Start: get data for physical_activity */
        Arr::set($data, 'getPhysicalActivityData', PhysicalActivity::getData());
        /* End: get data for physical_activity */

        /* Start: get data for Subscribe Now Plan details */
        Arr::set($data, 'getSubscribeNowPlan', SubscribeNowPlan::getData());
        /* End: get data  for Subscribe Now Plan details */

        /* Start: get data for Food Avoid details */
        Arr::set($data, 'getFoodAvoidData', FoodAvoid::getData());
        /* End: get data  for Food Avoid details */

        /* Start: get data for Meal Type details */
        Arr::set($data, 'getMealTypeData', MealType::getData());
        /* End: get data for Meal Type details */

        /* Start: get data for Subscribe Now details */
        Arr::set($data, 'getSubscribeNowData', SubscribeNow::getData());
        /* End: get data for Subscribe Now details */
        
        return view('subscribe')->with(['data' => $data,'recent_data' => $recent_data, 'seo_title' => "Subscribe Now"]); 
    }  


     

}
?>