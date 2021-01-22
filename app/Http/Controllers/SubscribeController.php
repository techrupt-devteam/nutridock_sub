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


    public function SubscribeNowPlanDuration(Request $request){
        $value = request()->segment(2);
        $duration_data = [];
        $duration_value     = \DB::table('subscribe_now_plan_duration')
                        ->where('subscribe_now_duration',$value)
                         //->where('subscribe_now_plan_duration_id',$value)
                        ->get();
        if($duration_value)
        {
            $duration_data = $duration_value->toArray();
        }
        $data['duration_data'] = $duration_data;
        //print_r($duration_data); die;
        echo json_encode($data);
    }

    public function getMealTypeDataAjax(Request $request)
    {
        $arr_rules['_token']         = "required";
        $mela_type  =   $request->input('value');

        $meal_data = [];
        $meal_value     = \DB::table('meal_type')->where('meal_type_name',$mela_type)->get();
        if($meal_value)
        {
            $meal_data = $meal_value->toArray();
        }
        $data['meal_data']  = $meal_data;

        print_r($data['meal_data']); die;
    }
    public function postFormDetails(Request $request)
    { 
        $arr_rules['_token']         = "required";
        $arr_data['name']   =   $request->input('full_name', null);
        $arr_data['email']   =   $request->input('email', null);
        $arr_data['phone_no']   =   $request->input('phone_no', null);

        $subacribe_now_value     = \DB::table('subscribe_now')->where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->get();

        $subacribe_now_data_exit = $subacribe_now_value->toArray();

        

        if($subacribe_now_data_exit){
            foreach($subacribe_now_data_exit as $row){
                $payment_status = $row->payment_status;
                $start_date = $row->start_date;
                $duration_plane_id = $row->subscribe_now_plan_duration_id;
            }

            $now_plan_duration     = \DB::table('subscribe_now_plan_duration')->where('subscribe_now_plan_duration_id',$duration_plane_id)->get();
            //$duration_value = '';
            foreach($now_plan_duration as $plan_row){
                $duration_value = $plan_row->subscribe_now_duration;
            }

            if($payment_status != 'Paid'){
                $personal_data_status = SubscribeNow::create($arr_data);
            }else{
                $todays_date = date_create();//'2021-01-05'
                $start_date_value = date_create($start_date);//'2020-12-30'
                $diff = date_diff($start_date_value,$todays_date);
                $date_diff =  $diff->format('%a');
               
                if($date_diff > $duration_value){
                    $personal_data_status = SubscribeNow::create($arr_data);
                    
                }else{
                    $data['message'] = "error";
                    echo json_encode($data);
                }
            }
        }else{
            $personal_data_status = SubscribeNow::create($arr_data);
            $data['message'] = "success";
            echo json_encode($data);
        }


    }


    public function postPersonalDetails(Request $request)
    {
        $arr_rules['_token']         = "required";
        $arr_data['phone_no']   =   $request->input('phone_no', null);
        $arr_data['name']   =   $request->input('full_name', null);
        $arr_data['email']   =   $request->input('email', null);

        $subacribe_now_value     = \DB::table('subscribe_now')->where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->get();

        $subacribe_now_data_exit = $subacribe_now_value->toArray();

        foreach($subacribe_now_data_exit as $row){
            $payment_status = $row->payment_status;
            $start_date = $row->start_date;
            $duration_plane_id = $row->subscribe_now_plan_duration_id;
        }
        

        $now_plan_duration     = \DB::table('subscribe_now_plan_duration')->where('subscribe_now_plan_duration_id',$duration_plane_id)->get();
        //$duration_value = '';
        foreach($now_plan_duration as $plan_row){
            $duration_value = $plan_row->subscribe_now_duration;
        }
        

        if($subacribe_now_data_exit){
            if($payment_status != 'Paid'){


                SubscribeNow::where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->where('payment_status',' ')->delete();

                //SubscribeNow::where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->update($arr_data);
                $avoid_or_dislike_food = $request->input('avoid_or_dislike_food_id'); 
                $address1_meal = $request->input('address1_meal');
                $address2_meal = $request->input('address2_meal');
                
                //print_r($address1_meal); die;
                if($avoid_or_dislike_food){
                    $avoid_or_dislike_food_value = implode(',',$avoid_or_dislike_food);    
                }else{
                    $avoid_or_dislike_food_value = '';
                }
                
              /*  if($address1_meal){
                    $address1_meal_value = implode(',',$address1_meal);    
                }else{
                    $address1_meal_value = '';
                }

                if($address2_meal){
                    $address2_meal_value = implode(',',$address2_meal);    
                }else{
                    $address2_meal_value = '';
                }
            */
            

                $original_date = $request->input('start_date',null);
                $start_date = strtotime($original_date);
                $new_date = date("Y-m-d", $start_date);
                $arr_data['session_id']   = Session::getId();

                $arr_data['age']   =   $request->input('age',null);
                $arr_data['gender']   =   $request->input('gender',null);
                $arr_data['weight']   =   $request->input('weight',null);
                $arr_data['height_in_feet']   = $request->input('height_in_feet',null);
                $arr_data['height_in_inches']   =   $request->input('height_in_inches',null);
                $arr_data['physical_activity_id']   =   $request->input('physical_activity_id',null);
                $arr_data['other_food']   =   $request->input('other_food');
                $arr_data['avoid_or_dislike_food_id'] = $avoid_or_dislike_food_value;
                $arr_data['total'] = $request->input('total');
                $arr_data['price'] = 1;
                $arr_data['food_precautions']   = $request->input('food_precautions',null);
                $arr_data['lifestyle_disease']   = $request->input('lifestyle_disease',null);
                $arr_data['start_date']   =  $new_date;
                $arr_data['subscribe_now_plan_id']   = 1;
                $arr_data['subscribe_now_plan_duration_id']   = $request->input('subscribe_now_plan_duration_id',null);
                $arr_data['meal_type_id'] = $request->input('meal_type_id',null);
                $arr_data['address1_meal'] = $address1_meal;
                $arr_data['address2_meal'] = $address2_meal;
                $arr_data['approve_status'] = 'Disapprove';
                /*$arr_data['subscription_id']= "subs".date('my').'-100'. rand(1,99);*/
                $arr_data['subscription_id'] = '100'.rand(1,999);
                $arr_data['address1']   = $request->input('address1',null);
                $arr_data['pincode1']   = $request->input('pincode1',null);
                $arr_data['address2']   = $request->input('address2',null);
                $arr_data['pincode2']   = $request->input('pincode2',null);
           
                //$personal_data_status = SubscribeNow::where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->update($arr_data);
                $personal_data_status = SubscribeNow::create($arr_data);
                $valu_data = [];
                $value = \DB::table('subscribe_now')->where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->get();

                if(!empty($value))
                {
                    $valu_data = $value->toArray();
                }

                 if($valu_data){
                    foreach($valu_data as $row){
                        $price = $row->price;
                        $name = $row->name;
                        $email = $row->email;
                        $phone_no = $row->phone_no;
                        $address = $row->address1;
                        $pincode = $row->pincode1;
                        $id = $row->id;
                    }
                        $data['amount'] = $price;
                        $data['name'] = $name;
                        $data['email'] = $email;
                        $data['phone_no'] = $phone_no;
                        $data['address'] = $address;
                        $data['pincode'] = $pincode;
                        $data['id'] = $id;
                        echo json_encode($data);
                }
            }else{

                $todays_date = date_create();//'2021-02-01'
                $start_date_value = date_create($start_date);//'2020-12-30'
                $diff = date_diff($start_date_value,$todays_date);
                $date_diff =  $diff->format('%a');
                
                if($date_diff > $duration_value){

                $original_date = $request->input('start_date',null);
                $start_date = strtotime($original_date);
                $new_date = date("Y-m-d", $start_date);
                $arr_data['session_id']   = Session::getId();

                $arr_data['age']   =   $request->input('age',null);
                $arr_data['gender']   =   $request->input('gender',null);
                $arr_data['weight']   =   $request->input('weight',null);
                $arr_data['height_in_feet']   = $request->input('height_in_feet',null);
                $arr_data['height_in_inches']   =   $request->input('height_in_inches',null);
                $arr_data['physical_activity_id']   =   $request->input('physical_activity_id',null);
                $arr_data['other_food']   =   $request->input('other_food');
                $arr_data['avoid_or_dislike_food_id'] = $avoid_or_dislike_food_value;
                $arr_data['total'] = $request->input('total');
                $arr_data['price'] = $request->input('price');
                $arr_data['food_precautions']   = $request->input('food_precautions',null);
                $arr_data['lifestyle_disease']   = $request->input('lifestyle_disease',null);
                $arr_data['start_date']   =  $new_date;
                $arr_data['subscribe_now_plan_id']   = 1;
                $arr_data['subscribe_now_plan_duration_id']   = $request->input('subscribe_now_plan_duration_id',null);
                
                $arr_data['meal_type_id'] = $request->input('meal_type_id',null);
                $arr_data['address1_meal'] = $address1_meal;
                $arr_data['address2_meal'] = $address2_meal;
                $arr_data['approve_status'] = 'Disapprove';
                /*$arr_data['subscription_id']= "subs".date('my').'-100'. rand(1,99);*/
                $arr_data['subscription_id'] = '100'.rand(1,999);
                
                $arr_data['address1']   = $request->input('address1',null);
                $arr_data['pincode1']   = $request->input('pincode1',null);
                $arr_data['address2']   = $request->input('address2',null);
                $arr_data['pincode2']   = $request->input('pincode2',null);

                $personal_data_status = SubscribeNow::where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->update($arr_data);

                $valu_data = [];
                $value = \DB::table('subscribe_now')->where('phone_no',$arr_data['phone_no'])->where('name',$arr_data['name'])->where('email',$arr_data['email'])->get();

                if(!empty($value))
                {
                    $valu_data = $value->toArray();
                }

                 if($valu_data){
                    foreach($valu_data as $row){
                        $price = $row->price;
                        $name = $row->name;
                        $email = $row->email;
                        $phone_no = $row->phone_no;
                        $address = $row->address1;
                        $pincode = $row->pincode1;
                        $id = $row->id;
                    }
                        $data['amount'] = $price;
                        $data['name'] = $name;
                        $data['email'] = $email;
                        $data['phone_no'] = $phone_no;
                        $data['address'] = $address;
                        $data['pincode'] = $pincode;
                        $data['id'] = $id;
                        echo json_encode($data);
                }
                    
                }else{
                    $alreadyexits = "Your plane is already going.";
                    echo json_encode($alreadyexits);
                }
            }
            
        }
        Session::flash('success', 'You have successfully subscribed to the nutridock');
    }
    
    function subscription_payment1(Request $request)
    {
        $data['seo_title'] = "";
        /*Recent Data*/
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
        
        return view('subscription-payment',$data);
    }

    function subscription_payment(Request $request)
    {
       
        $id = $request->input('id');
        $subscribe_now = \DB::table('subscribe_now')->where(['id'=>$id])->first();     

        $amount_ = $subscribe_now->price;

        date_default_timezone_set("Asia/Kolkata");
        try 
        {
            $api      = new Api('rzp_test_KcySdv9YlIpqGP', 'J0vxLAtdGexEcM7O60MnQ5O0');
            //
            //'rzp_test_KcySdv9YlIpqGP', 'J0vxLAtdGexEcM7O60MnQ5O0'
            //
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'))->capture(array('amount'=>$amount_*100));
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'));
        }
        catch(Exception $e) 
        {
            //header("Location: http://localhost/nutridock/failed.php");
            return view('failed');
            exit();
        }
        if($payment->status=="captured")
        {
            //echo"1"; die;
            \DB::table('subscribe_now')->where(['id'=>$id])->update(['payment_status'=>'Paid','transaction_id'=>$request->input('razorpay_payment_id')]);
            $to = $subscribe_now->email;
            $subscribe_now_plan_duration_id = $subscribe_now->subscribe_now_plan_duration_id;
            
            $data['name'] = $subscribe_now->name;
            $data['subscription_id'] = $subscribe_now->subscription_id;
            $data['phone_no'] = $subscribe_now->phone_no;
            $data['start_date'] = $subscribe_now->start_date;
            $data['subscribe_now_plan_duration_id'] = $subscribe_now->subscribe_now_plan_duration_id;
            $data['other_food'] = $subscribe_now->other_food;
            
            $data['meal_type_id'] = $subscribe_now->meal_type_id;
            $data['avoid_or_dislike_food_id'] = $subscribe_now->avoid_or_dislike_food_id;
            $explode_data = explode(",",$data['avoid_or_dislike_food_id']);
            
            $subscribe_plan = \DB::table('subscribe_now_plan_duration')->where(['subscribe_now_plan_duration_id'=>$subscribe_now_plan_duration_id])->first(); 
            $data['subscribe_plan'] = $subscribe_plan->subscribe_now_duration;
            
            
           $cc = 'laxmipagare99@gmail.com'; //fnb.nsk@nutridock.com
           //$bcc = array('kitchen.nsk@nutridock.com','marketing@nutridock.com','nutritionist@nutridock.com'); 
            $subject = 'Confirmation email';
           
            Mail::send('subscribenowmail', $data, function($message) use($to, $subject, $cc) {
                $message->to($to);
                $message->cc($cc);
                $message->setContentType('text/html');
                //$message->bcc($bcc);
                $message->subject($subject);
                $message->from('pagarelaxmi@gmail.com','Nutridock');//
            });

            $data['seo_title'] = "";
            /*Recent Data*/
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
           return view('subscription-success',$data);
        }
    }

      
    public function subscription_success()
    {
        $data['seo_title'] = "";
        /*Recent Data*/
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
        return view('subscription-success',$data);
    }

    public function subscription_failed()
    {
        $data['seo_title'] = "";
        /*Recent Data*/
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
        
        
        return view('subscription-failed',$data);
    }
    
   public function search(Request $request)
    {
        $pincode_value   =   $request->input('pincode_value',null);
        
        $data_query = [];
        $data_value     = \DB::table('pincode')
                            //->where('pincode_no', 'like', '%' . $pincode_value . '%')
                            ->where('pincode_no', $pincode_value)
                            ->get();
                            
        if($data_value)
        {
            $data_query = $data_value->toArray();
        }
        
        if($data_query){
            $data['message'] = "success";
            echo json_encode($data);
        }else{
            $data['message'] = "error";
            echo json_encode($data);
        }
    }
    
    public function searchform(Request $request)
    {
        $pincode_value   =   $request->input('pincode_form',null);
        
        $data_query = [];
        $data_value     = \DB::table('pincode')
                            //->where('pincode_no', 'like', '%' . $pincode_value . '%')
                            ->where('pincode_no', $pincode_value)
                            ->get();
        if($data_value)
        {
            $data_query = $data_value->toArray();
        }

        if($data_query){
            $data['message'] = "success";
            echo json_encode($data);
        }else{
            $data['message'] = "error";
            echo json_encode($data);
        }
    }
    
    
    

}
?>