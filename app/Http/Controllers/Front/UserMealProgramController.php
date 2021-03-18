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



use App\Models\AssignNutritionist;
use App\Models\Location;
use App\Models\SubscriberMealPlan;
use App\Models\SubscriberDetails;
use App\Models\User;
use App\Models\city;
use App\Models\State;
use Intervention\Image\ImageManager;
use DateTime;
use Config;
use Image;
use Session;
use Sentinel;
use Validator;
use Carbon\Carbon;
use DB;

class UserMealProgramController extends Controller
{

    public function __construct(AssignNutritionist $AssignNutritionist,Location $Location,City $City,State $State,User $User,SubscriberMealPlan $SubscriberMealPlan,SubscriberDetails $SubscriberDetails)
    {
        $data                           = [];
        
        $this->base_model               = $AssignNutritionist; 
        $this->base_users               = $User; 
        $this->base_location            = $Location; 
        $this->base_city                = $City; 
        $this->base_state               = $State; 
        $this->base_subscribermealplan  = $SubscriberMealPlan; 
        $this->base_subscriber_details  = $SubscriberDetails; 
       

        $this->title                    = "Subscriber";
        $this->url_slug                 = "subscriber_calender";
        $this->folder_path              = "calender/";

        //Message
        $this->Insert                   = Config::get('constants.messages.Insert');
        $this->Update                   = Config::get('constants.messages.Update');
        $this->Delete                   = Config::get('constants.messages.Delete');
        $this->Error                    = Config::get('constants.messages.Error');
        $this->Is_exists                = Config::get('constants.messages.Is_exists');
    }
   
  
    public function mealProgram() { 
        $getSubscriberData = DB::table('nutri_mst_subscriber')
  
                ->join('nutri_dtl_subscriber','nutri_mst_subscriber.id', '=', 'nutri_dtl_subscriber.subscriber_id')
                ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
                ->where('nutri_mst_subscriber.id', '=', Session::get('subscriber_id'))
                ->get()->toArray();  
            
          Arr::set($data,NULL, $getSubscriberData);          
            
         
        return view('user-meal-program')->with(['data' => $data, 'seo_title' => "My Subscription"]); 
    }


    public function getCalendar(Request $request)
    {
      

        $data=[];      
        $subscriber_id       = $request->input('sid');; 
        
        $subscriber_details  = $this->base_subscriber_details->where('id','=',$subscriber_id)->select('start_date','expiry_date')->first();
//dd($subscriber_details);
        $date  = Carbon::parse($subscriber_details->start_date);
        $now   = Carbon::parse($subscriber_details->expiry_date);
        $days  = $date->diffInDays($now);
        $days1 = $days + 1;

        //dd($days1);
        $cnt   = '';
        $calender_data = []; 
        
        for ($i=1; $i<=$days1; $i++) 
        { 
           
             $program_data   = \DB::table('nutri_subscriber_meal_program')
                                ->join('meal_type','nutri_subscriber_meal_program.mealtype','=','meal_type.meal_type_id')
                                ->join('nutri_mst_menu','nutri_subscriber_meal_program.menu_id','=','nutri_mst_menu.id')
                                ->where('nutri_subscriber_meal_program.subcriber_id','=',$subscriber_id)
                                ->where('nutri_subscriber_meal_program.day','=',$i)
                                ->select('nutri_subscriber_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id','nutri_mst_menu.specification_id','nutri_mst_menu.menu_category_id')->get();
            
            $count = $program_data->count();
            if($count > 0){
              $cnt = $count;
            }
            else{
              $cnt = 0;
            }

            $colors = array('#f39c12','#f56954','#00c0ef','#0073b7');

            foreach ($program_data as $key => $value) {
             
                $calender_data[$i][$key]['title']            = $value->meal_type_name;
                
                if($i==1){
                   
                $calender_data[$i][$key]['start']             = date('Y-m-d', strtotime($subscriber_details->start_date));
                }else{
                    $d=$i-1;
                    
                $calender_data[$i][$key]['start']             = date('Y-m-d', strtotime($subscriber_details->start_date . '+'.$d.' day'));
                }
               
              
                $calender_data[$i][$key]['tooltip']           = ucfirst($value->menu_title);
                $calender_data[$i][$key]['backgroundColor']   = $colors[$key];
                $calender_data[$i][$key]['borderColor']       = $colors[$key];
               
               
           }  
        }

        $data['datacount']           = $cnt;
        $data['days']                = $days1;
        $data['start_date']          = date('Y-m-d',strtotime($subscriber_details->start_date));
        $data['calender_data']       = $calender_data;



        //dd($data);
        return view($this->folder_path.'index')->with(['data' => $data, 'seo_title' => "My Subscription"]); 

    }



//     public function mealProgram() { 
//       $getSubscriberData = DB::table('nutri_mst_subscriber')

//               ->join('nutri_dtl_subscriber','nutri_mst_subscriber.id', '=', 'nutri_dtl_subscriber.subscriber_id')
//               ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
//               ->where('nutri_mst_subscriber.id', '=', Session::get('subscriber_id'))
//               ->get()->toArray();  
          
//         Arr::set($data,NULL, $getSubscriberData);          
          
       
//       return view('user-meal-program')->with(['data' => $data, 'seo_title' => "My Subscription"]); 
//   }


    // // Subscriber Details 
    // public function subscriber_details(Request $request)
    // {
    //     $id = $request->input('sid');
    //     $get_subscriber_details  = \DB::table('nutri_dtl_subscriber')
    //                                 ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
    //                                 ->join('city','nutri_dtl_subscriber.city','=','city.id')
    //                                 ->join('state','nutri_dtl_subscriber.state','=','state.id')
    //                                 ->join('nutri_mst_subscription_plan','nutri_dtl_subscriber.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
    //                                 ->join('nutri_dtl_subscription_duration','nutri_dtl_subscriber.duration_id','=','nutri_dtl_subscription_duration.duration_id')
    //                                 ->join('physical_activity','nutri_dtl_subscriber.physical_activity_id','=','physical_activity.physical_activity_id')
    //                                 ->where('nutri_dtl_subscriber.is_deleted','<>',1)  
    //                                 ->where('nutri_dtl_subscriber.id','=',$id)
    //                                 ->select('physical_activity.physical_activity','nutri_mst_subscription_plan.sub_name','nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_dtl_subscription_duration.duration','nutri_mst_subscriber.mobile','nutri_mst_subscriber.email')
    //                                 ->first();
    //                                // dd($get_subscriber_details);
    //     //getmeal type 
    //     $get_meal_type = \DB::table('meal_type')
    //                       ->whereIn('meal_type_id',explode(",",$get_subscriber_details->meal_type_id))
    //                       ->select('meal_type_name')
    //                       ->get();
    //     $get_food_avoid = \DB::table('food_avoid')
    //                       ->whereIn('food_avoid_id',explode(",",$get_subscriber_details->avoid_or_dislike_food_id))
    //                       ->select('food_avoid_name')
    //                       ->get();
                                    
    //     $value = $get_subscriber_details;

    //     $address1 = ($value->address1) ? $value->address1 : "NA";
    //     $address2 = ($value->address2) ? $value->address2 : "NA";
    //     $html='<div class="modal-header" style="font-size:14px;">
    //       <div class="col-md-12">
    //         <h3 class="text-center d-none d-md-block">Subscription Details</h3></div>
    //       <button type="button" style="right: 20px;" class="close position-absolute" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
    //     </div>
    //     <div class="modal-body details p-4" style="margin: 21px;">
    //       <div class="row"></div>
    //       <div class="row content">
    //         <div class="col-md-5">
    //           <h4 style="color: #64BB2C;">'.$value->subscriber_name.'</h4>
    //           <div>
    //             <table class="table table-sm" style="font-size: 14px;">
    //               <tr>
    //                 <td><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;<span>'.$value->mobile.'</span></td>
    //               </tr>
    //               <tr>
    //                 <td> <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;<span>'.$value->email.'</span></td>
    //               </tr>
    //               <tr>
    //                 <td><i class="fa fa-child" aria-hidden="true"></i>&nbsp; <span>'.$value->subscriber_age.' <small>Yrs Old</small> </span></td>
    //               </tr>
    //               <tr>
    //                 <td><b>Transaction ID: </b>&nbsp; <span>'.$value->transaction_id.'  </span></td>
    //               </tr>
    //               <tr>
    //                 <td><b>Payment Status: </b>&nbsp; <span style="text-transform: capitalize;">'.$value->payment_status.'  </span></td>
    //               </tr>
    //             </table>
    //           </div>
    //         </div>
    //         <div class="col-md-7">
    //           <table class="table table-bordered" style="font-size: 14px;">
    //             <tr>
    //               <th style="background-color:#e9ecef"><span>Plan </span></th>
    //               <td><span>'.$value->sub_name.'</span></td>
    //             </tr>
    //             <tr>
    //               <th style="background-color:#e9ecef"><span>Duration</span></th>
    //               <td>
    //                 <div><small><b>FROM:</b> </small>'.date('d-M-Y',strtotime($value->start_date)).' <small></div><div ><b>TO:</b></small> '.date('d-M-Y',strtotime($value->expiry_date)).'</div>
    //                 <div> <small>('.$value->no_of_days.' Days)</small></div>
    //                 </span>
    //               </td>
    //             </tr>
    //             <tr>
    //               <th style="background-color:#e9ecef"><span>Meal Type</span></th>
    //               <td>'; foreach ($get_meal_type as $mvalue) { $html .="<span class='btn-sm btn-warning'>".$mvalue->meal_type_name."</span>&nbsp;&nbsp;"; } $html .='</td>
    //             </tr>
    //           </table>
    //         </div>
    //       </div>
    //       <div class="row">
    //         <div class="col-md-12" style="border-top: 2px solid #2d2c2c">
    //           <span class="heading"><i class="fa fa-heartbeat" aria-hidden="true"></i><strong> HEALTH DETAILS</strong></span>
    //           <div class="row content">
    //             <table class="table table-sm" style="font-size:14px;">
    //               <tbody>
    //                 <tr>
    //                   <td width="30%">Weight:</td>
    //                   <td>'.$value->subscriber_weight.'</td>
    //                   <td>Height:</td>
    //                   <td>'.$value->subscriber_height_in_feet." <i>Feets </i>".$value->subscriber_height_in_inches.' <i>Inches</i></td>
    //                 </tr>
    //                 <tr>
    //                   <td colspan="2">Avoid / Dislike Food:</td>
    //                   <td colspan="2">
    //                     <p>'; foreach ($get_food_avoid as $advalue) { $html .="<span class='btn-sm btn-danger'>".$advalue->food_avoid_name."</span>&nbsp;&nbsp;"; } $html .='</p>
    //                   </td>
    //                 </tr>
    //                 <tr>
    //                   <td colspan="2" width="40%">Other Food:</td>
    //                   <td colspan="2">'.$value->other_food.'</td>
    //                 </tr>
    //                 <tr>
    //                   <td colspan="2">Any lifestyle disease:</td>
    //                   <td colspan="2">'.$value->lifestyle_disease.'</td>
    //                 </tr>
    //                 <tr style="border-bottom:2px solid #000;" class="pb-2">
    //                   <td colspan="2">Any food preparation instructions:</td>
    //                   <td colspan="2">'.$value->food_precautions.'</td>
    //                 </tr>
    //               </tbody>
    //             </table>
    //           </div>
    //         </div>
    //       </div>
    //       <div class="row ">
    //         <div class="col-md-12 my-account">
    //           <div>
    //             <div class="heading pt20 pb-2"><i class="fa fa-home"></i><strong> ADDRESSES FOR MEAL DELIVERY </strong></div>
    //             <div class="card-view">
    //               <div class="row">
    //                 <div class="col-md-6">
    //                   <div class="content p-2" style="border: 1px dashed #2d2c2c; background-color: #e9ecef; font-size: 14px;">
    //                     <div class="description pb5  pb-3 pl-3 pr-3"  style="border-bottom: 1px solid #2d2c2c;"><h5 class="modal-title"><small><b>Delivery Address 1</b> </small></h5> '.$address1.'<div class="contact"> '.$value->pincode1.' </div></div>
    //                     <div class="col-md-12">
    //                       <h5 class="modal-title"><small><b>Deliver Meal on above address</b> </small></h5>
    //                       <br/>
    //                       <p>'; 
    //                         $get_meal_type2 = \DB::table('meal_type')->whereIn('meal_type_id',explode(",",$value->address1_deliver_mealtype))->select('meal_type_name')->get(); 

    //                         foreach ($get_meal_type2 as $m2value) { 
    //                           $html .="<span class='btn-sm btn-warning'>".$m2value->meal_type_name."</span>&nbsp;&nbsp;"; 
    //                         } 
    //                         $html .='</p>
    //                     </div>
    //                   </div>
    //                 </div>
    //                 <div class="col-md-6">
    //                   <div class="content p-2" style="border: 1px dashed #2d2c2c; background-color: #e9ecef; font-size: 14px;"> 
    //                     <div class="description pb5 pb-3 pl-3 pr-3" style="border-bottom: 1px solid #2d2c2c;"> <h5 class="modal-title"><small><b>Delivery Address 2</b> </small></h5>'.$address2.'
    //                       <div class="contact"> '.$value->pincode2.' </div>
    //                     </div>
    //                       <div class="col-md-12">
    //                         <h5 class="modal-title"><small><b>Deliver Meal on above address</b> </small></h5>
    //                         <p>'; 
    //                           $get_meal_type3 = \DB::table('meal_type')->whereIn('meal_type_id',explode(",",$value->address2_deliver_mealtype))->select('meal_type_name')->get(); 
    //                           if(count($get_meal_type3) > 0)
    //                           {
    //                              foreach ($get_meal_type3 as $m3value) { 
    //                               $html .="<span class='btn-sm btn-warning'>".$m3value->meal_type_name."</span>&nbsp;&nbsp;"; 
    //                             }
    //                           } else {
    //                             $html .='NA';
    //                           }
    //                           $html .='</p>
    //                       </div>
                       
    //                   </div>
    //                 </div>
    //               </div>
    //             </div>
    //           </div>
    //         </div>         
    //       </div>
    //     </div></div>
    //     <div class="modal-footer"> </div>';
        
    //     return $html;
    // }


    // public function getChatList(Request $request)
    // {
    //     $getSubscriberData = DB::table('nutri_mst_subscriber')  
    //     ->join('nutri_dtl_subscriber','nutri_mst_subscriber.id', '=', 'nutri_dtl_subscriber.subscriber_id')
    //     ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
    //     ->join('users','users.subscriber_dtl_id', '=', 'nutri_dtl_subscriber.id')
    //     ->where('nutri_mst_subscriber.id', '=', Session::get('subscriber_id'))
    //     ->get()->toArray();  
    
    //     Arr::set($data,NULL, $getSubscriberData);
    //     return view('subscription-user-chat')->with(['data' => $data, 'seo_title' => "Chat With Nutrionist"]); 
    // }


}
?>