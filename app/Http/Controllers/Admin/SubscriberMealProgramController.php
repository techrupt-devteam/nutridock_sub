<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\SubscriberMealPlan;
use App\Models\SubscriberDetails;
use App\Models\SubscriberHealthDetails;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
use Carbon;
class SubscriberMealProgramController extends Controller
{
    public function __construct(SubscriberMealPlan $SubscriberMealPlan,SubscriberHealthDetails $SubscriberHealthDetails,SubscriberDetails $SubscriberDetails)
    {
        $data                            = [];
        $this->base_model                = $SubscriberMealPlan; 
        $this->base_health               = $SubscriberHealthDetails; 
        $this->base_subscriber_details   = $SubscriberDetails; 
        $this->title                     = "Subscriber Meal Program";
        $this->url_slug                  = "subscriber_meal_program";
        $this->folder_path               = "admin/subscriber_meal_program/";
        //Messages
        $this->Insert       = Config::get('constants.messages.Insert');
        $this->Update       = Config::get('constants.messages.Update');
        $this->Delete       = Config::get('constants.messages.Delete');
        $this->Error        = Config::get('constants.messages.Error');
        $this->Is_exists    = Config::get('constants.messages.Is_exists');
    }

    public function add(Request $request,$id)
    {
        $id = base64_decode($id);
        //$get_subscriber_details = $this->base_subscriber_details;
        $get_subscriber_details = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_mst_subscription_plan','nutri_dtl_subscriber.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                                    ->where('nutri_dtl_subscriber.id','=',$id)
                                    ->select('nutri_dtl_subscriber.*','nutri_mst_subscription_plan.sub_name')
                                    ->first();
        $get_meal_type = \DB::table('meal_type')
                          ->whereIn('meal_type_id',explode(",",$get_subscriber_details->meal_type_id))
                          ->select('meal_type_name')
                          ->get();
      

        $start_date            = \Carbon\Carbon::createFromFormat('Y-m-d', $get_subscriber_details->start_date);
        $end_date              = \Carbon\Carbon::createFromFormat('Y-m-d', $get_subscriber_details->expiry_date);
        $different_days        = $start_date->diffInDays($end_date);
        $program_days          = $different_days+1; 
       
        //get subscplan assign menu
        $get_assign_menu_data = \DB::table('nutri_mst_assign_subscription_plan_menu')
                                ->where('sub_plan_id','=',$get_subscriber_details->sub_plan_id)
                                ->first();
        //1 $breakfast = []; 
        //2 $lunch     = []; 
        //4 $dinner    = []; 
        //3 $snack     = []; 
        //dd($get_assign_menu_data->menu_id);
        
        //load assign menu data
        $get_menu_data = \DB::table('nutri_mst_menu')
                          ->whereIn('id',explode(",",$get_assign_menu_data->menu_id))
                          ->select('id','menu_title','menu_type')
                          ->get();
        
        foreach ($get_menu_data as $key => $gmdvalue) 
        { 
            echo $gmdvalue->menu_title;
            
           

        }                 
exit;

        $data['page_name']     = "Add";
        $data['subscriber']    = $get_subscriber_details;
        $data['meal_type']     = $get_meal_type;
        $data['program_days']  = $program_days;
        $data['title']         = $this->title;
        $data['url_slug']      = $this->url_slug;
        return view($this->folder_path.'add',$data);
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
        $html='<div class="modal-header" >
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                 <div class="col-md-12"><h4 class="modal-title"><b>Subscriber Name:</b> '.$value->subscriber_name.'</h4></div>
               </div>
              <div class="modal-body" style="
    border: 5px double;
    margin: 21px;
">
               <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4"><h5 class="modal-title"><b>Subscription Plan: </b>'.$value->sub_name.'</h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Start Date: </b>'.date('d-m-Y',strtotime($value->start_date)).'</h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>End Date: </b>'.date('d-m-Y',strtotime($value->expiry_date)).'</h5></div>
                  </div>
                </div><hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4"><h5 class="modal-title"><b>Subscription Duration: </b>'.$value->duration.' Days </h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Meal Type: </b></h5><br/>
                      <p>';
                      foreach ($get_meal_type as $mvalue) {
                        $html .="<span class='btn-sm btn-warning'>".$mvalue->meal_type_name."</span>&nbsp;&nbsp;";  
                      }
                       $html  .='</p></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Payment Status: </b>'.$value->payment_status.'</h5></div>
                  </div>
                </div><hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4"><h5 class="modal-title"><b>Mobile: </b>'.$value->mobile.'</h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Email: </b>'.$value->email.'</h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Age: </b>'.$value->subscriber_age.'</h5></div>
                  </div>
                </div>
                <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4"><h5 class="modal-title"><b>Gender: </b>'.$value->subscriber_gender.'</h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Weight: </b>'.$value->subscriber_weight.'</h5></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Height: </b>'.$value->subscriber_height_in_feet.".".$value->subscriber_height_in_inches.'</h5></div>
                  </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-4"><h5 class="modal-title"><b>Physical Activity: </b> </h5><br/><p> '.$value->physical_activity.'</p></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Avoid / Dislike Food: </b> </h5></br><p>';
                      foreach ($get_food_avoid as $advalue) {
                        $html .="<span class='btn-sm btn-danger'>".$advalue->food_avoid_name."</span>&nbsp;&nbsp;";  
                      }
                       $html  .='</p>

                      </div>
                   </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-6"><h5 class="modal-title"><b>Other Food: </b></h5><br/><p>'.$value->other_food.'</p></div>
                   </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-12"><h5 class="modal-title"><b>Any lifestyle disease:</b></h5><br/><p>'.$value->lifestyle_disease.'</p></div>
                   </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-12"><h5 class="modal-title"><b>Any food preparation instructions:</b></h5><br/><p>'.$value->food_precautions.'</p></div>
                   </div>
                </div>
                 <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4"><h5 class="modal-title"><b>Address: </b></h5><br/><p>'.$value->address1.'</p> </div>
                    <div class="col-md-4"><h5 class="modal-title"><b>Pincode: </b></h5><br/><p>'.$value->pincode1.'</p> </div>
                    <div class="col-md-4"><h5 class="modal-title"><b>Meal Type: </b></h5><br/><p>';
                    $get_meal_type2 = \DB::table('meal_type')
                                     ->whereIn('meal_type_id',explode(",",$value->address1_deliver_mealtype))
                                     ->select('meal_type_name')
                                     ->get();
                     foreach ($get_meal_type2 as $m2value) {
                        $html .="<span class='btn-sm btn-warning'>".$m2value->meal_type_name."</span>&nbsp;&nbsp;";  
                      }                 
                    $html .='</p> </div>
                  </div>  
                </div><hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="col-md-4"><h5 class="modal-title"><b>Address: </b></h5><br/><p>'.$value->address2.'</p></div>
                        <div class="col-md-4"><h5 class="modal-title"><b>Pincode: </b></h5><br/><p>'.$value->pincode2.'</p></div>
                        <div class="col-md-4"><h5 class="modal-title"><b>Meal Type: </b></h5><br/><p>';
                        $get_meal_type3 = \DB::table('meal_type')
                                         ->whereIn('meal_type_id',explode(",",$value->address2_deliver_mealtype))
                                         ->select('meal_type_name')
                                         ->get();

                        foreach ($get_meal_type3 as $m3value) {
                             $html .="<span class='btn-sm btn-warning'>".$m3value->meal_type_name."</span>&nbsp;&nbsp;";  
                        } 
                        $html .='</p></div>
                    </div>
                </div>
              ';
       

        $html.='</div>
                <div class="modal-footer">
              
                </div>';
              return $html;
    } 

}
