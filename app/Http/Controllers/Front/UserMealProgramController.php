<?php
namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Arr;
//use Illuminate\Support\Facades\DB;
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
use App\Models\MenuCategoryModel;
use App\Models\SpecificationModel;
use App\Models\MealType;
use App\Models\MenuModel;
use App\Models\SubscriberDefaultMeal;
use App\Models\SubscriberCompensetMeal;
use Intervention\Image\ImageManager;
use App\Models\Notification;
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

    public function __construct(AssignNutritionist $AssignNutritionist,Location $Location,City $City,State $State,User $User,SubscriberMealPlan $SubscriberMealPlan,SubscriberDetails $SubscriberDetails,MenuCategoryModel $MenuCategoryModel,SpecificationModel $SpecificationModel,MealType $MealType,Notification $Notification,MenuModel $MenuModel,SubscriberCompensetMeal $SubscriberCompensetMeal)
    {
        $data                           = [];
        
        $this->base_model               = $AssignNutritionist; 
        $this->base_users               = $User; 
        $this->base_location            = $Location; 
        $this->base_city                = $City; 
        $this->base_state               = $State; 
        $this->base_subscribermealplan  = $SubscriberMealPlan; 
        $this->base_subscriber_details  = $SubscriberDetails; 
        $this->base_notification        = $Notification; 
        $this->base_compneset_meal      = $SubscriberCompensetMeal; 

        $this->title                    = "Subscriber";
        $this->url_slug                 = "subscriber_calender";
        $this->folder_path              = "calender/";

        $this->base_menu                    = $MenuModel; 
        $this->base_meal_type               = $MealType;
        $this->base_menu_category           = $MenuCategoryModel;
        $this->base_menu_specification      = $SpecificationModel;

      
    

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


    public function getCalendar(Request $request) {    

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
        
        for ($i=1; $i<=$days1; $i++) { 
           
             $program_data   = \DB::table('nutri_subscriber_meal_program')
                                ->join('meal_type','nutri_subscriber_meal_program.mealtype','=','meal_type.meal_type_id')
                                ->join('nutri_mst_menu','nutri_subscriber_meal_program.menu_id','=','nutri_mst_menu.id')
                                ->where('nutri_subscriber_meal_program.subcriber_id','=',$subscriber_id)
                                ->where('nutri_subscriber_meal_program.day','=',$i)
                                ->select('nutri_subscriber_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id','nutri_mst_menu.specification_id','nutri_mst_menu.menu_category_id')->get();
            
            $count = $program_data->count();
            if($count > 0){
              $cnt = $count;
            } else {
              $cnt = 0;
            }

            $colors = array('#f39c12','#f56954','#00c0ef','#0073b7');

            foreach ($program_data as $key => $value) {
             
                  $calender_data[$i][$key]['title']            = $value->meal_type_name;
                
                if($i==1){ 
                  $calender_data[$i][$key]['start']             = date('Y-m-d', strtotime($subscriber_details->start_date));
                }elseif($value->skip_meal_flag=="y" && !empty($value->ref_program_id)){

                  $calender_data[$i][$key]['start']             = date('Y-m-d', strtotime($value->meal_on_date));

                }
                else{
                    $d=$i-1;
                    
                  $calender_data[$i][$key]['start']             = date('Y-m-d', strtotime($subscriber_details->start_date . '+'.$d.' day'));
    
                }
               
                $calender_data[$i][$key]['ref_program_id']    = $value->ref_program_id."#".$value->skip_meal_flag."#".$value->meal_on_date."#".lcfirst(date('D', strtotime($value->meal_on_date)));
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

    public function editMealProgram(Request $request) {
      $currentdate = Carbon::now('Asia/Kolkata'); 

      $data = [];

      $get_default_menu   = \DB::table('nutri_subscriber_meal_program')
                            ->join('meal_type','nutri_subscriber_meal_program.mealtype','=','meal_type.meal_type_id')
                            ->join('nutri_mst_menu','nutri_subscriber_meal_program.menu_id','=','nutri_mst_menu.id')
                            ->join('nutri_dtl_subscriber','nutri_dtl_subscriber.id','=','nutri_subscriber_meal_program.subcriber_id')
                            ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
                            ->where('nutri_subscriber_meal_program.subcriber_id','=',$request->id)
                            ->orderby('nutri_subscriber_meal_program.program_id', 'ASC')
                            ->select('nutri_subscriber_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id','nutri_dtl_subscriber.start_date','nutri_dtl_subscriber.id','nutri_dtl_subscriber.subscriber_name','nutri_dtl_subscriber.sub_email','nutri_mst_subscription_plan.sub_name','nutri_dtl_subscriber.expiry_date')->get();

     /*$get_compenset_menu   =  \DB::table('nutri_subscriber_compenset_meal_program')
                              ->join('meal_type','nutri_subscriber_compenset_meal_program.mealtype','=','meal_type.meal_type_id')
                              ->join('nutri_mst_menu','nutri_subscriber_compenset_meal_program.menu_id','=','nutri_mst_menu.id')
                              ->join('nutri_dtl_subscriber','nutri_dtl_subscriber.id','=','nutri_subscriber_compenset_meal_program.subcriber_id')
                              ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
                              ->where('nutri_subscriber_compenset_meal_program.subcriber_id','=',$request->id)
                              ->orderby('nutri_subscriber_compenset_meal_program.program_id', 'ASC')
                              ->select('nutri_subscriber_compenset_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id','nutri_dtl_subscriber.start_date','nutri_dtl_subscriber.id','nutri_dtl_subscriber.subscriber_name','nutri_dtl_subscriber.sub_email','nutri_mst_subscription_plan.sub_name','nutri_dtl_subscriber.expiry_date')->get();
       
       $data = array_merge($get_default_menu->toArray(),$get_compenset_menu->toArray());*/
       /* dd($data);*/
        

      Arr::set($data,null,$get_default_menu);
      return view('user-edit-meal-program')->with(['data' => $data, 'seo_title' => "Edit Meal program", 'currentdate' => $currentdate]); 
    }




    public function menuEdit(Request $request) {       
      $program_id         = $request->program_id;
      $program_data   = \DB::table('nutri_subscriber_meal_program')
                            ->join('meal_type','nutri_subscriber_meal_program.mealtype','=','meal_type.meal_type_id')
                            ->join('nutri_mst_menu','nutri_subscriber_meal_program.menu_id','=','nutri_mst_menu.id')
                            ->where('nutri_subscriber_meal_program.program_id','=',$program_id)
                            ->select('nutri_subscriber_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id','nutri_mst_menu.specification_id','nutri_mst_menu.menu_category_id')->first();
    
      $menu_category      = $this->base_menu_category->get();
      $menu_specification = $this->base_menu_specification->get()->toarray(); 
      $meal_type          = $this->base_meal_type->get();

      $data=[];
      $data['program_data']        = $program_data;
      $data['menu_category']       = $menu_category;
      $data['menu_specification']  = $menu_specification;
      $data['meal_type']           = $meal_type;
   
      return view('user-changemenu-ajax',$data);
    }


    public function get_menu_macros(Request $request)
    {
         $menu_id   = $request->menu_id;
         $menu_data =  $this->base_menu->where('id','=',$menu_id)->select('calories','proteins','carbohydrates','fats')->first();
         $data      = [];
         $data[]      = $menu_data->calories;
         $data[]      = $menu_data->proteins;
         $data[]      = $menu_data->carbohydrates;
         $data[]      = $menu_data->fats;
         $html        ="
                        <tbody>
                            <tr>
                              <td width='60%' >Calories</td>
                             <td class='text-center' style='background-color: #e1f4d4;'><strong>".$menu_data->calories."</strong></td>
                            </tr>
                            <tr>
                              <td>Proteins</td>
                             <td class='text-center'  style='background-color: #e1f4d4;'><strong>".$menu_data->proteins."</strong></td>
                            </tr>
                            <tr>
                              <td>Carbohydrates</td>
                             <td class='text-center'  style='background-color: #e1f4d4;'><strong>".$menu_data->carbohydrates."</strong></td>
                            </tr>
                            <tr>
                              <td>Fats</td>
                             <td class='text-center'  style='background-color: #e1f4d4;'><strong>".$menu_data->fats."</strong></td>
                            </tr>
                            <tr>
                              <td style='background-color: #f6ff9e;'>Total</strong></td>
                             <td class='text-center'  style='background-color: #f6ff9e;'><strong>".array_sum($data)."</strong></td>

                            </tr>
                        </tbody>"; 
        return $html; 

    }

    public function get_menu(Request $request)
    {
       // dd($request);        
        $menu_category      = $request->menu_Category;
        $specification      = $request->specification_array;
        $menu_specification = array();
        
        foreach ($specification as $key => $value)
        {
           if(!empty($value))
           {
             $menu_specification[] = $value;
           }
        }

        $menu_data =  $this->base_menu->where('menu_category_id','=',$menu_category)->get(); 
      
        $html                       = "";
        $specification_array        = [];
        $menu_type                  = [];
        $meal_type_array            = [];
        $specification_array_f      = [];

        $html.="<option value=''>-Select Menu-</option>";
        foreach ($menu_data as $key => $menu_value) {
         $menu_type[$key]= explode(',',$menu_value['menu_type']); 
         
         
 
          $specification_array [$key]  = explode(',',$menu_value['specification_id']); 

          foreach ($specification_array[$key] as $key3 => $spavalue) {
            if(!in_array($spavalue,$specification_array_f)){
                $specification_array_f [] = $spavalue;
            }
          }

          $result =  array_intersect($menu_specification,$specification_array_f);
     
          if(count($result)>0 && $menu_value->menu_category_id==$menu_category){
             
             if($request->old_menu_id == $menu_value['id'])
             {
                $html.="<option value=".$menu_value['id']." selected>".ucfirst($menu_value['menu_title'])."</option>"; 
             }
             else
             {
                $html.="<option value=".$menu_value['id']." >".ucfirst($menu_value['menu_title'])."</option>"; 
             }

          }
        }

        return $html;
    }


    public function changeMenu(Request $request) {
      $currentdate = Carbon::now('Asia/Kolkata'); 
      $id                   = $request->program_id;    
      $arr_data['menu_id']  = $request->menu_id;   

      $checkAllowEdit = SubscriberDefaultMeal::where(['program_id'=>$id])->first('meal_on_date');
     

      if(strtotime($checkAllowEdit['meal_on_date']." 20:00:00") >= strtotime($currentdate)) {        
        $menu_update          = SubscriberDefaultMeal::where(['program_id'=>$id])->update($arr_data);       
        return 'success';
      } else {
        Session::flash('error',"Sorry you can not change your menu for tommorow after 8.00 PM");
        return 'error';
      }
    }
     
    public function skipMeal(Request $request)
    { 
       $program_id            = $request->program_id;
       $program_data          = \DB::table('nutri_subscriber_meal_program')->where('program_id','=',$program_id)->first(); 
      // dd($program_data);
       $subscriber_data          = \DB::table('nutri_dtl_subscriber')->where('id','=',$program_data->subcriber_id)->select('expiry_date','id')->first();
       //dd($subscriber_data);
       $data['program_id']    = $program_id;
       $data['program_data']  = $program_data;
       $data['expiry_date']  = $subscriber_data->expiry_date;
       $data['subscriber_dtl_id']  = $subscriber_data->id;
       return view('user-skip-meal-ajax',$data);

    }

    public function store_skip_menu(Request $request)
    { 
      $program_id        = $request->input('program_id');
      $compensation_date = $request->input('compensation_date');
      $subscriber_dtl_id = $request->input('subscriber_dtl_id');
      $meal_type = $request->input('meal_type');
    
        $is_exist =   \DB::table('nutri_subscriber_meal_program')
                        ->where('subcriber_id','=',$subscriber_dtl_id)
                        ->where('compenset_date','=',$compensation_date)
                        ->where('mealtype','=',$meal_type)
                        ->count();
        if($is_exist)
        {
            Session::flash('error', 'You have already compenset meal on this date');
            return \Redirect::back();
        }


      $arr_data['compenset_date'] = $compensation_date;
      $arr_data['skip_meal_flag']    = 'y';
      $menu_update      = \DB::table('nutri_subscriber_meal_program')
                          ->where(['program_id'=>$program_id])
                          ->update($arr_data);
      //add compenset meal progarm entry                         
      if($menu_update){

            //get details mela_program
            $get_meal_program = \DB::table('nutri_subscriber_meal_program')
                                ->where(['program_id'=>$program_id])
                                ->first();
          
           $is_exist2 =   \DB::table('nutri_subscriber_meal_program')
                            ->where('ref_program_id','=',$get_meal_program->program_id)
                            ->where('compenset_date','=',$get_meal_program->meal_on_date)
                            ->count();
            if($is_exist2)
            {
                $carr_data['meal_on_date']      = $get_meal_program->compenset_date; 
                $carr_data['skip_meal_flag']    = 'y';
                DB::table('nutri_subscriber_meal_program')->where(['ref_program_id'=>$program_id])->update($carr_data); 
            }
            else
            {
           
            $carr_data["ref_program_id"]   =  $get_meal_program->program_id;        
            $carr_data["subcriber_id"]     =  $get_meal_program->subcriber_id; 
            $carr_data["nutritionist_id"]  =  $get_meal_program->nutritionist_id; 
            $carr_data["sub_plan_id"]      =  $get_meal_program->sub_plan_id;   
            $carr_data["duration_id"]      =  $get_meal_program->duration_id;   
            $carr_data["day"]              =  $get_meal_program->day;   
            $carr_data["mealtype"]         =  $get_meal_program->mealtype;   
            $carr_data["menu_id"]          =  $get_meal_program->menu_id;   
            $carr_data["is_active"]        =  $get_meal_program->is_active;   
            $carr_data["meal_on_date"]     =  $get_meal_program->compenset_date;   
            $carr_data["compenset_date"]   =  $get_meal_program->meal_on_date;   
            $carr_data["skip_meal_flag"]   =  $get_meal_program->skip_meal_flag;   
            $carr_data["is_deleted"]       =  $get_meal_program->is_deleted;   
            \DB::table('nutri_subscriber_meal_program')->updateOrInsert($carr_data,['meal_on_date'=>$get_meal_program->compenset_date]); 

            }

          //Send Notification Admin / Operation / Nutrtionist
           $subscriber_dtl_id = $request->input('subscriber_dtl_id');
          //get subscriber info
           $subscriber_data   =  \DB::table('nutri_dtl_subscriber')
                                 ->where('id','=',$subscriber_dtl_id)
                                 ->select('subscriber_name')
                                 ->first();     
          //program info
           $program_info       =  \DB::table('nutri_subscriber_meal_program')
                                 ->where('program_id','=',$program_id)
                                 ->select('nutritionist_id','day','meal_on_date','compenset_date')
                                 ->first();
          //Nutrtionist info                        
           $nutrtionist_info   =  \DB::table('users')
                                 ->where('id','=',$program_info->nutritionist_id)
                                ->select('name','roles','city','area')
                                 ->first();

          //operation manager Info                  
           $operation_info   =  \DB::table('users')
                                 ->where('city','=',$nutrtionist_info->city)
                                 ->where('area','=',$nutrtionist_info->area)
                                  ->where('roles','=',2)
                                 ->select('name','roles','city','area','id')
                                 ->first();
     
          
          //nutrtionist  notification
           $notify_arr['message']    = "Subscriber <b>".$subscriber_data->subscriber_name."</b> has been changed meal program menu for <b>".$this->addOrdinalNumberSuffix($program_info->day)."</b> day and compensation date is <b>".date('d-m-Y',strtotime($program_info->compenset_date))."</b> !" ;
           $notify_arr['users_role'] = 1; 
           $notify_arr['user_id']    = $program_info->nutritionist_id; 
           $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

          //admin notification 
           $notify_arr['message']    = "Subscriber <b>".$subscriber_data->subscriber_name."</b> has been changed meal program menu for <b>".$this->addOrdinalNumberSuffix($program_info->day)."</b> day and compensation date is <b>".date('d-m-Y',strtotime($program_info->compenset_date))."</b> !" ;
           $notify_arr['users_role'] = 'admin' ; 
           $notify_arr['user_id']    = 1; 
           $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

          //operation manger notification
           $notify_arr['message']    =  "Subscriber <b>".$subscriber_data->subscriber_name."</b> has been changed meal program menu for <b>".$this->addOrdinalNumberSuffix($program_info->day)."</b> day and compensation date is <b>".date('d-m-Y',strtotime($program_info->compenset_date))."</b> !" ;
           $notify_arr['users_role'] = 2 ; 
           $notify_arr['user_id']    = $operation_info->id; 
           $assign_nutritionist_notification = $this->base_notification->create($notify_arr);
           Session::flash('success',"Meal skip successfully");
     }
     else
     {
          Session::flash('Error',"Sorry You can not skip a meal !!");
     }


      return \Redirect::back();
    }

    public  function addOrdinalNumberSuffix($num)
    {
        
        if (!in_array(($num % 100),array(11,12,13))){
        switch ($num % 10) {
          // Handle 1st, 2nd, 3rd
          case 1:  return $num.'st';
          case 2:  return $num.'nd';
          case 3:  return $num.'rd';
        }
        }
        return $num.'th';
 
    }
    
    //Health list
    public function health_history(Request $request)
    {
        $getSubscriberData = DB::table('nutri_mst_subscriber')

                ->join('nutri_dtl_subscriber','nutri_mst_subscriber.id', '=', 'nutri_dtl_subscriber.subscriber_id')
                ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
                ->where('nutri_mst_subscriber.id', '=', Session::get('subscriber_id'))
                ->get()->toArray();  
            
          Arr::set($data,NULL, $getSubscriberData);          
            
         
          return view('user-health-details')->with(['data' => $data, 'seo_title' => "My Health List"]); 
    } 
      

    public function edit_health_history(Request $request)
    {

        $data = [];

        $get_health_history   = \DB::table('nutri_subscriber_health_details')
                                  ->join('nutri_dtl_subscriber','nutri_dtl_subscriber.id','=','nutri_subscriber_health_details.subcriber_id')
                                  ->join('nutri_mst_subscription_plan','nutri_mst_subscription_plan.sub_plan_id', '=', 'nutri_dtl_subscriber.sub_plan_id')
                                  ->join('users','users.id', '=', 'nutri_subscriber_health_details.nutritionist_id')
                                  ->where('nutri_subscriber_health_details.subcriber_id','=',$request->id)
                                  ->select('nutri_dtl_subscriber.start_date','nutri_dtl_subscriber.id','nutri_dtl_subscriber.subscriber_name','nutri_dtl_subscriber.sub_email','nutri_mst_subscription_plan.sub_name','nutri_subscriber_health_details.*','nutri_dtl_subscriber.start_date','nutri_dtl_subscriber.expiry_date','users.name')
                                  ->orderBy('nutri_subscriber_health_details.subscriber_health_id','DESC')
                                  ->get();

        Arr::set($data,null,$get_health_history);

        return view('user-health-history')->with(['data' => $data, 'seo_title' => "Edit Meal program"]); 

    }  
    
    public function update_health_details(Request $request){
      
      $subscriber_health_id = $request->subscriber_health_id;
      $get_health_history   = \DB::table('nutri_subscriber_health_details')
                                ->join('nutri_dtl_subscriber','nutri_dtl_subscriber.id','=','nutri_subscriber_health_details.subcriber_id')
                                ->where('nutri_subscriber_health_details.subscriber_health_id','=',$subscriber_health_id)
                                ->where('nutri_subscriber_health_details.is_active','=',1)
                                ->select('nutri_subscriber_health_details.*','nutri_dtl_subscriber.subscriber_name')
                                ->first();
      Arr::set($data,null,$get_health_history);
      return view('user-health-ajax')->with(['health_details' => $data, 'seo_title' => "Update Health"]); 

    }



    public function update_health_store(Request $request){
      
      $subscriber_health_id       = $request->subscriber_health_id;
      $current_wt                 = $request->input('current_wt');  
      $bmr                        = $request->input('bmr'); 
      $bmi                        = $request->input('bmi'); 
      $body_fat                   = $request->input('body_fat');  
      $req_calories               = $request->input('req_calories');  
      $protein                    = $request->input('protein');
      $fat                        = $request->input('fat');
      $fiber                      = $request->input('fiber');
      $carbs                      = $request->input('carbs');
      $arr_data['current_wt']     = $current_wt;
      $arr_data['bmr']            = $bmr;
      $arr_data['bmi']            = $bmi;
      $arr_data['body_fat']       = $body_fat;
      $arr_data['req_calories']   = $req_calories;
      $arr_data['protein']        = $protein;
      $arr_data['fat']            = $fat;
      $arr_data['fiber']          = $fiber;
      $arr_data['carbs']          = $carbs;
      
                $menu_update      = \DB::table('nutri_subscriber_health_details')
                                    ->where(['subscriber_health_id'=>$subscriber_health_id])
                                    ->update($arr_data);

      //Send Notification Admin / Operation / Nutrtionist
       $subscriber_dtl_id         = $request->input('subcriber_id');
       //get subscriber info
       $subscriber_data   =  \DB::table('nutri_dtl_subscriber')
                             ->where('id','=',$subscriber_dtl_id)
                             ->select('subscriber_name')
                             ->first();     
      //Nutrtionist info                        
      $nutrtionist_info   =  \DB::table('users')
                             ->where('id','=',$request->input('nutritionist_id'))
                            ->select('name','roles','city','area')
                             ->first();

      //operation manager Info                  
      $operation_info   =  \DB::table('users')
                             ->where('city','=',$nutrtionist_info->city)
                             ->where('area','=',$nutrtionist_info->area)
                             ->where('roles','=',2)
                             ->select('name','roles','city','area','id')
                             ->first();
 
      
      //nutrtionist  notification
      $notify_arr['message']    = "Subscriber <b>".$subscriber_data->subscriber_name."</b> has been changed update health details !" ;
      $notify_arr['users_role'] = 1; 
      $notify_arr['user_id']    = $request->input('nutritionist_id'); 
      $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

      //admin notification 
      $notify_arr['message']    = "Subscriber <b>".$subscriber_data->subscriber_name."</b> has been changed update health details !" ;
      $notify_arr['users_role'] = 'admin' ; 
      $notify_arr['user_id']    = 1; 
      $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

      //operation manger notification
      $notify_arr['message']    =  "Subscriber <b>".$subscriber_data->subscriber_name."</b> has been changed update health details !" ;
      $notify_arr['users_role'] = 2 ; 
      $notify_arr['user_id']    = $operation_info->id; 
      $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

      Session::flash('success',"Update health details successfully !!");
      return \Redirect::back();

    }



}
?>