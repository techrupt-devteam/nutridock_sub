<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
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

use Session;
use Sentinel;
use DB;
use Validator;
use URL;
use Mail;
use Carbon\Carbon;
use Razorpay\Api\Api;


class SubscriptionUserController extends Controller
{
    function __construct() {
        // $this->PhysicalActivity = new PhysicalActivity();
    }
    
    public function index() {  

        $recent_data = [];       

        /* Start: get data for subscription plan */
        //Arr::set($data, 'getSubscriptionPlan', SubscriptionPlan::getData());
        /* End: get data for subscription plan */     

      
       
        $data = '';
        return view('dashboard')->with(['data' => $data, 'seo_title' => "Dashboard"]); 
    }  


    public function mySubscription() { 
        $getSubscriberData = DB::table('nutri_mst_subscriber')
  
                ->join('nutri_dtl_subscriber','nutri_mst_subscriber.id', '=', 'nutri_dtl_subscriber.subscriber_id')
                ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
                ->where('nutri_mst_subscriber.id', '=', Session::get('subscriber_id'))
                ->get()->toArray();  
            
          Arr::set($data,NULL, $getSubscriberData);          
            
         
        return view('subscription-user-plans')->with(['data' => $data, 'seo_title' => "My Subscription"]); 
    }


  


    // Subscriber Details 
    public function subscriber_details(Request $request)
    {
        $id = $request->input('sid');
        $get_subscriber_details  = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                    ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                    ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                    ->join('nutri_mst_subscription_plan','nutri_dtl_subscriber.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                                    ->join('nutri_dtl_subscription_duration','nutri_dtl_subscriber.duration_id','=','nutri_dtl_subscription_duration.duration_id')
                                    ->join('physical_activity','nutri_dtl_subscriber.physical_activity_id','=','physical_activity.physical_activity_id')
                                    ->where('nutri_dtl_subscriber.is_deleted','<>',1)  
                                    ->where('nutri_dtl_subscriber.id','=',$id)
                                    ->select('physical_activity.physical_activity','nutri_mst_subscription_plan.sub_name','nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_dtl_subscription_duration.duration','nutri_mst_subscriber.mobile','nutri_mst_subscriber.email')
                                    ->first();
                                   // dd($get_subscriber_details);
        //getmeal type 
        $get_meal_type = \DB::table('meal_type')
                          ->whereIn('meal_type_id',explode(",",$get_subscriber_details->meal_type_id))
                          ->select('meal_type_name')
                          ->get();
        $get_food_avoid = \DB::table('food_avoid')
                          ->whereIn('food_avoid_id',explode(",",$get_subscriber_details->avoid_or_dislike_food_id))
                          ->select('food_avoid_name')
                          ->get();
                                    
        $value = $get_subscriber_details;

        $address1 = ($value->address1) ? $value->address1 : "NA";
        $address2 = ($value->address2) ? $value->address2 : "NA";
        $html='<div class="modal-header" style="font-size:14px;">
          <div class="col-md-12">
            <h3 class="text-center d-none d-md-block">Subscription Details</h3></div>
          <button type="button" style="right: 20px;" class="close position-absolute" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body details p-4" style="margin: 21px;">
          <div class="row"></div>
          <div class="row content">
            <div class="col-md-5">
              <h4 style="color: #64BB2C;">'.$value->subscriber_name.'</h4>
              <div>
                <table class="table table-sm" style="font-size: 14px;">
                  <tr>
                    <td><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;<span>'.$value->mobile.'</span></td>
                  </tr>
                  <tr>
                    <td> <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;<span>'.$value->email.'</span></td>
                  </tr>
                  <tr>
                    <td><i class="fa fa-child" aria-hidden="true"></i>&nbsp; <span>'.$value->subscriber_age.' <small>Yrs Old</small> </span></td>
                  </tr>
                  <tr>
                    <td><b>Transaction ID: </b>&nbsp; <span>'.$value->transaction_id.'  </span></td>
                  </tr>
                  <tr>
                    <td><b>Payment Status: </b>&nbsp; <span style="text-transform: capitalize;">'.$value->payment_status.'  </span></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-md-7">
              <table class="table table-bordered" style="font-size: 14px;">
                <tr>
                  <th style="background-color:#e9ecef"><span>Plan </span></th>
                  <td><span>'.$value->sub_name.'</span></td>
                </tr>
                <tr>
                  <th style="background-color:#e9ecef"><span>Duration</span></th>
                  <td>
                    <div><small><b>FROM:</b> </small>'.date('d-M-Y',strtotime($value->start_date)).' <small></div><div ><b>TO:</b></small> '.date('d-M-Y',strtotime($value->expiry_date)).'</div>
                    <div> <small>('.$value->no_of_days.' Days)</small></div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <th style="background-color:#e9ecef"><span>Meal Type</span></th>
                  <td>'; foreach ($get_meal_type as $mvalue) { $html .="<span class='btn-sm btn-warning'>".$mvalue->meal_type_name."</span>&nbsp;&nbsp;"; } $html .='</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="border-top: 2px solid #2d2c2c">
              <span class="heading"><i class="fa fa-heartbeat" aria-hidden="true"></i><strong> HEALTH DETAILS</strong></span>
              <div class="row content">
                <table class="table table-sm" style="font-size:14px;">
                  <tbody>
                    <tr>
                      <td width="30%">Weight:</td>
                      <td>'.$value->subscriber_weight.'</td>
                      <td>Height:</td>
                      <td>'.$value->subscriber_height_in_feet." <i>Feets </i>".$value->subscriber_height_in_inches.' <i>Inches</i></td>
                    </tr>
                    <tr>
                      <td colspan="2">Avoid / Dislike Food:</td>
                      <td colspan="2">
                        <p>'; foreach ($get_food_avoid as $advalue) { $html .="<span class='btn-sm btn-danger'>".$advalue->food_avoid_name."</span>&nbsp;&nbsp;"; } $html .='</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" width="40%">Other Food:</td>
                      <td colspan="2">'.$value->other_food.'</td>
                    </tr>
                    <tr>
                      <td colspan="2">Any lifestyle disease:</td>
                      <td colspan="2">'.$value->lifestyle_disease.'</td>
                    </tr>
                    <tr style="border-bottom:2px solid #000;" class="pb-2">
                      <td colspan="2">Any food preparation instructions:</td>
                      <td colspan="2">'.$value->food_precautions.'</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row ">
            <div class="col-md-12 my-account">
              <div>
                <div class="heading pt20 pb-2"><i class="fa fa-home"></i><strong> ADDRESSES FOR MEAL DELIVERY </strong></div>
                <div class="card-view">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="content p-2" style="border: 1px dashed #2d2c2c; background-color: #e9ecef; font-size: 14px;">
                        <div class="description pb5  pb-3 pl-3 pr-3"  style="border-bottom: 1px solid #2d2c2c;"><h5 class="modal-title"><small><b>Delivery Address 1</b> </small></h5> '.$address1.'<div class="contact"> '.$value->pincode1.' </div></div>
                        <div class="col-md-12">
                          <h5 class="modal-title"><small><b>Deliver Meal on above address</b> </small></h5>
                          <br/>
                          <p>'; 
                            $get_meal_type2 = \DB::table('meal_type')->whereIn('meal_type_id',explode(",",$value->address1_deliver_mealtype))->select('meal_type_name')->get(); 

                            foreach ($get_meal_type2 as $m2value) { 
                              $html .="<span class='btn-sm btn-warning'>".$m2value->meal_type_name."</span>&nbsp;&nbsp;"; 
                            } 
                            $html .='</p>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="content p-2" style="border: 1px dashed #2d2c2c; background-color: #e9ecef; font-size: 14px;"> 
                        <div class="description pb5 pb-3 pl-3 pr-3" style="border-bottom: 1px solid #2d2c2c;"> <h5 class="modal-title"><small><b>Delivery Address 2</b> </small></h5>'.$address2.'
                          <div class="contact"> '.$value->pincode2.' </div>
                        </div>
                          <div class="col-md-12">
                            <h5 class="modal-title"><small><b>Deliver Meal on above address</b> </small></h5>
                            <p>'; 
                              $get_meal_type3 = \DB::table('meal_type')->whereIn('meal_type_id',explode(",",$value->address2_deliver_mealtype))->select('meal_type_name')->get(); 
                              if(count($get_meal_type3) > 0)
                              {
                                 foreach ($get_meal_type3 as $m3value) { 
                                  $html .="<span class='btn-sm btn-warning'>".$m3value->meal_type_name."</span>&nbsp;&nbsp;"; 
                                }
                              } else {
                                $html .='NA';
                              }
                              $html .='</p>
                          </div>
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>         
          </div>
        </div></div>
        <div class="modal-footer"> </div>';
        
        return $html;
    }


    public function getChatList(Request $request)
    {
        $getSubscriberData = DB::table('nutri_mst_subscriber')  
        ->join('nutri_dtl_subscriber','nutri_mst_subscriber.id', '=', 'nutri_dtl_subscriber.subscriber_id')
        ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
        ->join('users','users.subscriber_dtl_id', '=', 'nutri_dtl_subscriber.id')
        ->where('nutri_mst_subscriber.id', '=', Session::get('subscriber_id'))
        ->get()->toArray();  
    
        Arr::set($data,NULL, $getSubscriberData);
        return view('subscription-user-chat')->with(['data' => $data, 'seo_title' => "Chat With Nutrionist"]); 
    }


    public function chatWithNutrionist(Request $request)
    {       
       
        $data = Auth::loginUsingId($request->id)->toArray();
        
        $credentials = [
          'email'    => $request->id."_".$data['email'],
          'password' => Session::get('subscriber_otp'),
       ]; 
      

      //dd($user);
      $Auth = Auth::guard('web')->attempt($credentials);
      $user = \Sentinel::authenticate($credentials);
       if(!$user) {
        \Sentinel::login($user);
       }
     

      dd($user);
      return redirect('/admin/chatify');
    }
}
?>