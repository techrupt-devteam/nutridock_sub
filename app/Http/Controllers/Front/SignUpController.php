<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Arr;

use App\Http\Controllers\Controller;
//use App\Http\Controllers\DateTime;
use App\Http\Requests;
use App\Providers\RouteServiceProvider;

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
use App\Models\City;
use App\Models\Notification;

use Session;
use Sentinel;
use DB;
use Validator;
use URL;
use Mail;
use Carbon\Carbon;
use Razorpay\Api\Api;

class SignUpController extends Controller
{
    function __construct() {
        // $this->PhysicalActivity = new PhysicalActivity();
    }
    
    public function index() {  
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();

        if($recent_value) {
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
        $checkExist = SubscriberMaster::where('mobile', '=', $request->mobile)->exists();
        
        if($checkExist) {
            return "Already Exist";
        } else {
            $subscriber =   SubscriberMaster::firstOrNew(
                ['email' =>  request('email')],
                ['mobile' => request('mobile')]
            );

            if($subscriber->save()) {
            $subscriberDetails =   SubscriberDetails::firstOrNew(
                ['subscriber_id' =>  $subscriber->id],
                ['subscriber_name' =>  request('name')],
                ['session_id' =>  session()->getId()]
            );


            $subscriberDetails->save();
            Session::put('subscriber_id', $subscriberDetails->id);


            return 'true';

        }
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
        $valid = DeliveryLocation::where('delivery_pincode', $request['pincode'])
        ->where('is_active', '1')
        ->where('is_deleted', '0')
        ->first();    
        
       
        $delivery_pincode = ($valid) ? $request['pincode'] : '';
        if($valid) {
            $getStateData = City::where('id', $valid['delivery_city_id'])->first();
            Session::put('delivery_pincode', $delivery_pincode);
            Session::put('delivery_city_id', $valid['delivery_city_id']);
            Session::put('delivery_state_id', $getStateData['state_id']);
        }       

       return $delivery_pincode;            
    }


    public function getSubPlanPrice(Request $request) {                  
        $getPriceDtl = SubscriptionPlanDetails::where('sub_plan_id', $request['subscription_plan_id'])
                        ->where('duration_id', $request['duration_id'])->first();                                           
            
                        
        Arr::set($data, 'duration', $getPriceDtl['duration']);
        Arr::set($data, 'price_per_meal', $getPriceDtl['price_per_meal']);
        Arr::set($data, 'discount_price', $getPriceDtl['discount_price']);        
        Arr::set($data, 'selected_meal_type_length', $request['selectedMealTypeLength']);
        Arr::set($data, 'selected_meal_type', $request['selectedMealType']);

        if($getPriceDtl['discount_price']) {
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

    public function paySuccess(Request $Request){

        $api = new Api(config('custom.razor_key'), config('custom.razor_secret'));

        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($Request['razorpay_payment_id'])->capture(array('amount'=>$Request['totalAmount']*100));      
        
		$data = [
		'transaction_id' => $payment->id,
        'razorpay_response' => json_encode($payment->toArray()),
        'payment_status' => $payment->status,
		];

        $update = SubscriberDetails::where('subscriber_id', Session::get('subscriber_id'))
        ->update($data); 

        if($update) {     
            
            $getSubscriberDtl = SubscriberDetails::where('subscriber_id', Session::get('subscriber_id'))
            
            ->first();


            $get_subscriber_details  = \DB::table('nutri_dtl_subscriber')
            ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
            ->join('nutri_mst_subscription_plan','nutri_dtl_subscriber.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
            ->where('nutri_dtl_subscriber.id','=',Session::get('subscriber_id'))
            ->select('nutri_mst_subscription_plan.sub_name','nutri_dtl_subscriber.subscriber_name','nutri_dtl_subscriber.no_of_days','nutri_dtl_subscriber.start_date','nutri_dtl_subscriber.expiry_date')
            ->first();


           
            $addNotification =  Notification::create(
                ['message' =>  $getSubscriberDtl['subscriber_name']." has been subscribed plan ".$getSubscriberDtl['sub_name']." for duration of ".$getSubscriberDtl['no_of_days']." From: ".$getSubscriberDtl['start_date']." To: ".$getSubscriberDtl['expiry_date'],
                'users_role' => 'admin',
                'user_id' => 1]
            );       
    
            $addNotification->save();  
       
         // add notification for operation manager
           $getId = DB::select("SELECT id FROM users WHERE roles = '2' AND `state` = ".Session::get('delivery_state_id')." AND `city` = ".Session::get('delivery_city_id')." AND `area` IN (SELECT id FROM `locations` WHERE `pincode` = ".Session::get('delivery_pincode').")");          
           
            $addNotificationOperation =  Notification::create(
                ['message' =>  $getSubscriberDtl['subscriber_name']." has been subscribed plan ".$getSubscriberDtl['sub_name']." for duration of ".$getSubscriberDtl['no_of_days']."days, From: ".date("d-M-Y",strtotime($getSubscriberDtl['start_date']))." To: ".date("d-M-Y",strtotime($getSubscriberDtl['expiry_date'])),
                'users_role' => 2,
                'user_id' => $getId[0]->id]
            );

            $addNotificationOperation->save();
           
        }

		return $update;    
	}

    public function checkout() {       
        //Input items of form
        $input = Input::all(); 
        $date = Carbon::now();
       
        $date = Carbon::parse($input['start_date']);
        $expiryDate = $date->addDays($input['no_of_days']-1); 
        $totalAmount = $input['salePrice'] + $input['gst_price'];      

        $data = array(
        'subscriber_name' => $input['full_name'],
        'subscriber_age' => $input['age'],
        'subscriber_gender' => $input['gender'],
        'subscriber_weight' => $input['weight'],
        'subscriber_height_in_feet' => $input['height_in_feet'],
        'subscriber_height_in_inches' => $input['height_in_inches'],
        'physical_activity_id' => $input['physical_activity_id'],
        //'avoid_or_dislike_food_id' => $input['avoid_or_dislike_food_id'],
        'other_food' => ($input['other_food']) ? $input['other_food'] : 'NULL',
        'lifestyle_disease' => $input['lifestyle_disease'],
        'food_precautions' => $input['food_precautions'],
        'is_price_per_mealorpack' => $input['age'],
        'price_per_meal' => $input['price_per_meal'],
        'discount_price' => $input['discount_price'],
        'mrp' => $input['mrp'],
        'sale_price' => $input['salePrice'],
        'gst_price' => $input['gst_price'],
        'gst_percentage' => 5,
        'total_amount' => $totalAmount,
        'start_date' => $input['start_date'],
        'expiry_date' => $expiryDate,
        'extended_date' => $expiryDate,
        'sub_plan_id' => $input['radioSubscriptionPlan'],
        'duration_id' => $input['radioDuration'],
        'no_of_days' => $input['no_of_days'],
        'meal_type_id' => $input['meal_type'],
        'address1' => $input['address1'],
        'pincode1' => $input['pincode1'],
        //'address1_deliver_mealtype' => $input['address1_meal'],
        'address2' => $input['address2'],
        'pincode2' => $input['pincode2'],
        //'address2_deliver_mealtype' => $input['address2_meal'],
        'state' => Session::get('delivery_state_id'),
        'city' => Session::get('delivery_city_id'),
        'session_id' => session()->getId(),
        'transaction_id' => '',
        'subscriber_id' => Session::get('subscriber_id'),
        'payment_status' => 'Initiated');

       
        $update = SubscriberDetails::where('subscriber_id', Session::get('subscriber_id'))
                ->update($data);         

        $arrData = ['total_amount' => $totalAmount,'subscriber_id' => Session::get('subscriber_id')];
        return $arrData;          
      
    }


    public function thankyou() {     
        $data['seo_title'] = "";
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();

        if($recent_value) {
            $recent_data = $recent_value->toArray();
        }

        return view('thank_you_signup')->with(['data' => $data,'recent_data' => $recent_data, 'seo_title' => "Thank You"]); 
    }

    public function signinModal() {      
        return view('sign_in');
    }
}
?>