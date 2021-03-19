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

}
?>