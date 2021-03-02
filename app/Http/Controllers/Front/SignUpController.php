<?php

namespace App\Http\Controllers\Front;

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
use App\Models\SubscriptionPlan;
use App\Models\SubscriberMaster;
use App\Models\SubscriberDetails;
use App\Models\SubscriptionPlanDetails;
use App\Models\DeliveryLocation;


use Session;
use Sentinel;
use DB;
use Validator;
use URL;
use Mail;
use Razorpay\Api\Api;

class SignUpController extends Controller
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

         /* Start: get data for subscription plan */
         Arr::set($data, 'getSubscriptionPlan', SubscriptionPlan::getData());
         /* End: get data for subscription plan */ 

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
        
        return view('sign_up')->with(['data' => $data,'recent_data' => $recent_data, 'seo_title' => "Subscribe Now"]); 
    }  


    public function storeBasicDetails(Request $request) { 

        $subscriber =   SubscriberMaster::firstOrNew(
                            ['email' =>  request('email')],
                            ['mobile' => request('mobile')]
                        );

        if($subscriber->save()) {

            $subscriberDetails =   SubscriberDetails::firstOrNew(
                ['subscriber_id' =>  $subscriber->id],
                ['subscriber_name' =>  request('name')]
            );
            $subscriberDetails->save();
            return 'true';
        } else {
            return 'false';
        }
       
    }

    /* FUNCTION: Get Plan Details */
    public function getSubscriptionPlanDetails(Request $request) {
        $getSubscriptionPlanDetails = SubscriptionPlanDetails::where('sub_plan_id', $request['plan_id'])
                                      ->orderBy('duration', 'ASC')->get();
        return $getSubscriptionPlanDetails;       
    }

  

     /* FUNCTION: Get Plan Details */
     public function getCheckValidPin(Request $request) {
        $valid = DeliveryLocation::where('delivery_pincode', $request['pincode'])->exists();
        $delivery_pincode = ($valid) ? $request['pincode'] : '';
        Session::put('delivery_pincode', $delivery_pincode);

        return $delivery_pincode;            
    }


    public function getSubPlanPrice(Request $request)
    {
        $getPriceDtl = SubscriptionPlanDetails::where('sub_plan_id', $request['subscription_plan_id'])
                        ->where('duration', $request['duration_id'])->first();  
                        
        Arr::set($data, 'duration', $getPriceDtl['duration']);
        Arr::set($data, 'price_per_meal', $getPriceDtl['price_per_meal']);
        Arr::set($data, 'discount_price', $getPriceDtl['discount_price']);        
        Arr::set($data, 'selected_meal_type_length', $request['selectedMealTypeLength']);
        Arr::set($data, 'selected_meal_type', $request['selectedMealType']);

        if($getPriceDtl['discount_price']){
            $salePrice = $getPriceDtl['discount_price'] * $getPriceDtl['duration'] * $request['selectedMealTypeLength'];
            Arr::set($data, 'salePrice', $salePrice);

            $totalPrice = $getPriceDtl['price_per_meal'] * $getPriceDtl['duration'] * $request['selectedMealTypeLength']; 
            Arr::set($data, 'totalPrice', $totalPrice);

        } else if($getPriceDtl['price_per_meal']) {
            $salePrice = $getPriceDtl['price_per_meal'] * $getPriceDtl['duration'] * $request['selectedMealTypeLength']; 
            Arr::set($data, 'salePrice', $salePrice);

            $totalPrice = "";
            Arr::set($data, 'totalPrice', $totalPrice);

        } else if($getPriceDtl['price_per_pack']) {
            $salePrice = $getPriceDtl['price_per_pack'];
            Arr::set($data, 'salePrice', $salePrice);

            $totalPrice = "";
            Arr::set($data, 'totalPrice', $totalPrice);
        }

        return $data;
                                            
    }
}
?>