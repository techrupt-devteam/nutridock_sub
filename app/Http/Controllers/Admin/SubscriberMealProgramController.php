<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\SubscriberMealPlan;
use App\Models\SubscriberDetails;
use App\Models\SubscriberHealthDetails;
use App\Models\DefaultMeal;
use App\Models\SubscriberDefaultMeal;
use App\Models\MenuModel;
use App\Models\MenuCategoryModel;
use App\Models\MealType;
use App\Models\SpecificationModel;
use App\Models\Notification;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
use Carbon\Carbon;
class SubscriberMealProgramController extends Controller
{
    public function __construct(SubscriberMealPlan $SubscriberMealPlan,MenuModel $MenuModel,DefaultMeal $DefaultMeal,SubscriberHealthDetails $SubscriberHealthDetails,SubscriberDetails $SubscriberDetails,SubscriberDefaultMeal $SubscriberDefaultMeal,MenuCategoryModel $MenuCategoryModel,SpecificationModel $SpecificationModel,MealType $MealType,Notification $Notification)
    {
        $data                               = [];
        $this->base_model                   = $SubscriberMealPlan; 
        $this->base_health                  = $SubscriberHealthDetails; 
        $this->base_subscriber_details      = $SubscriberDetails; 
        $this->base_menu                    = $MenuModel; 
        $this->base_meal_type               = $MealType; 
        $this->base_menu_category           = $MenuCategoryModel; 
        $this->base_menu_specification      = $SpecificationModel; 
        $this->base_default_meal            = $DefaultMeal; 
        $this->base_subscriber_default_meal = $SubscriberDefaultMeal;
        $this->base_notification            = $Notification; 
        $this->title                        = "Subscriber Meal Program";
        $this->url_slug                     = "subscriber_meal_program";
        $this->folder_path                  = "admin/subscriber_meal_program/";
        //Messages
        $this->Insert                       = Config::get('constants.messages.Insert');
        $this->Update                       = Config::get('constants.messages.Update');
        $this->Delete                       = Config::get('constants.messages.Delete');
        $this->Error                        = Config::get('constants.messages.Error');
        $this->Is_exists                    = Config::get('constants.messages.Is_exists');
    }

    public function add(Request $request,$id)
    {
         
         
         $id                     = base64_decode($id);
         $login_user_details     = Session::get('user');
         $nutritionist_id        = $login_user_details->id;
         //get details 
         $get_subscriber_details = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_dtl_subscription_duration','nutri_dtl_subscriber.duration_id','=','nutri_dtl_subscription_duration.duration_id')
                                    ->join('nutri_mst_subscription_plan','nutri_dtl_subscriber.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                                    ->where('nutri_dtl_subscriber.id','=',$id)
                                    ->select('nutri_dtl_subscriber.*','nutri_mst_subscription_plan.sub_name','nutri_dtl_subscription_duration.duration as no_of_days')
                                    ->first();

          //subscription Plan &  duration id
            $sub_plan_id = $get_subscriber_details->sub_plan_id;
            $duration_id = $get_subscriber_details->duration_id;
           
            $date  = Carbon::parse($get_subscriber_details->start_date);
            $now   = Carbon::parse($get_subscriber_details->expiry_date);
            $days  = $date->diffInDays($now);
            $days1 = $days + 1;
            
           //CREATE START_DATE ARRAY
            $date_array =[];
            for($i=1; $i<=$days1; $i++) 
            { 
               if($i==1){
                   
                $date_array[$i] = date('Y-m-d', strtotime($get_subscriber_details->start_date));
                }else{
                    $d=$i-1;
                    
                $date_array[$i] = date('Y-m-d', strtotime($get_subscriber_details->start_date . '+'.$d.' day'));
                } 
            } 

           //default_menu add on subscriber
            $get_default_menu = $this->base_default_meal
                              ->where('duration_id','=',$duration_id)
                              ->where('sub_plan_id','=',$sub_plan_id)
                              ->get();

            //subscriber default meal plan array  
            $get_subscriber_meal_program = explode(',',$get_subscriber_details->meal_type_id);                  

            //dd($get_subscriber_meal_program);

             if(!is_null($get_default_menu))
             {
                    $arr_data = []; 
                    //assign defualt meal data in subscriber   
                     $Is_exists  =  $this->base_subscriber_default_meal
                                    ->where('subcriber_id','=',$id)
                                    ->where('nutritionist_id','=',$nutritionist_id)
                                    ->where('duration_id','=',$duration_id)
                                    ->where('sub_plan_id','=',$sub_plan_id)
                                    ->count();
                    if($Is_exists == 0)
                    {   
                        foreach ($get_default_menu as $default_value) 
                        {
                            //check selected meal plan and set this mealplan on default meal plan
                            if(in_array($default_value->mealtype,$get_subscriber_meal_program))
                            { 
                              $arr_data['day']              = $default_value->day;
                              $arr_data['sub_plan_id']      = $sub_plan_id;
                              $arr_data['duration_id']      = $duration_id;
                              $arr_data['mealtype']         = $default_value->mealtype;
                              $arr_data['menu_id']          = $default_value->menu_id;
                              $arr_data['subcriber_id']     = $id;
                              $arr_data['nutritionist_id']  = $nutritionist_id;
                              $arr_data['meal_on_date']     = $date_array[$default_value->day]; 
                              $add_subscriber_default_menu  =  $this->base_subscriber_default_meal->create($arr_data);

                              
                           }
                         
                        }


                    }  

                   //Render default subscriber menu data
                   /*$get_default_menu = $this->base_subscriber_default_meal
                                      ->where('duration_id','=',$duration_id)
                                      ->where('sub_plan_id','=',$sub_plan_id)
                                      ->where('subcriber_id','=',$id)
                                      ->get();*/ 
                   $get_default_menu   = \DB::table('nutri_subscriber_meal_program')
                                          ->join('meal_type','nutri_subscriber_meal_program.mealtype','=','meal_type.meal_type_id')
                                          ->join('nutri_mst_menu','nutri_subscriber_meal_program.menu_id','=','nutri_mst_menu.id')
                                           ->leftJoin('nutri_mst_menu as a','nutri_subscriber_meal_program.addition_menu_id','=','a.id')
                                          ->where('nutri_subscriber_meal_program.sub_plan_id','=',$sub_plan_id)
                                          ->where('nutri_subscriber_meal_program.duration_id','=',$duration_id)
                                          ->where('nutri_subscriber_meal_program.subcriber_id','=',$id)
                                          ->select('nutri_subscriber_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id','a.menu_title as additional_menu_title')
                                          ->orderBy('nutri_subscriber_meal_program.program_id','ASC')->get();
                  //dd($get_default_menu);        

                  $health_details = $this->base_health->where('subcriber_id','=',$id)->where('nutritionist_id','=',$nutritionist_id)->orderBy('subscriber_health_id', 'DESC')->first();   
                  
                  $data=[];
                  
                  if(!empty($health_details))
                  {
                    $data['health_details']         = $health_details;
                    
                  }

                  $data['page_name']                = "Add";
                  $data['title']                    = $this->title;
                  $data['url_slug']                 = $this->url_slug;
                  $data['default_menu_not_Assign']  = "yes";
                  $data['subscriber']               = $get_subscriber_details;
                  $data['subscriber_id']            = $id;
                  $data['nutritionist_id']          = $nutritionist_id;
                  $data['get_default_menu']         = $get_default_menu;
                  

                  return view($this->folder_path.'add',$data);
               }
                else
               {
                  $data=[];
                  $data['page_name']                = "Add";
                  $data['title']                    = $this->title;
                  $data['url_slug']                 = $this->url_slug;
                  $data['default_menu_not_Assign']  = "No";
                  $data['subscriber_id']            = $id;
                  $data['nutritionist_id']          = $nutritionist_id;
                  $data['subscriber']               = $get_subscriber_details;
                  return view($this->folder_path.'add',$data);
               } 
    
    }

    public function store(Request $request)
    {
      
       $validator = Validator::make($request->all(), [
                  "bmi"        =>'required',
                  "bmr"        =>'required',
                  "current_wt" =>'required',
                  "body_fat"        =>'required',
                  "req_calories"   =>'required',
                  "protein"    =>'required',
                  "fiber"      =>'required',
                  "fat"      =>'required',
                  "carbs"      =>'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $arr_data                      = [];
        $arr_data['bmi']               = $request->input('bmi');
        $arr_data['bmr']               = $request->input('bmr');
        $arr_data['current_wt']        = $request->input('current_wt');
        $arr_data['body_fat']          = $request->input('fat');
        $arr_data['req_calories']      = $request->input('req_calories');
        $arr_data['protein']           = $request->input('protein');
        $arr_data['fiber']             = $request->input('fiber');
        $arr_data['fat']               = $request->input('fat');
        $arr_data['carbs']             = $request->input('carbs');
        $arr_data['nutritionist_id']   = $request->input('nutritionist_id');
        $arr_data['subcriber_id']      = $request->input('subscriber_id');
        $health_details = $this->base_health->create($arr_data);
        if(!empty($health_details))
        {
          
            //notifications
            $login_user_details       = Session::get('user');
            $nutritionist_id          = $login_user_details->id;

            //get subscriber details table get information 
            $subscriber_det           = \DB::table('nutri_dtl_subscriber')->where('id','=',$request->input('subscriber_id'))->first();
            
            //operation details 
            $operation_details        = \DB::table('users')->where('area','=',$login_user_details->area)->where('roles','=',2)->first();

 

            //subscriber  notification
            $notify_arr['message']    = 'Nutrtionist '.$login_user_details->name.' change health details for subscriber '.$subscriber_det->subscriber_name.'!';
            $notify_arr['users_role'] = "subscriber" ; 
            $notify_arr['user_id']    = $subscriber_det->subscriber_id; 
            $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

            //admin notification 
            $notify_arr['message']    = 'Nutrtionist '.$login_user_details->name.' change health details for subscriber '.$subscriber_det->subscriber_name.'!';
            $notify_arr['users_role'] = 'admin' ; 
            $notify_arr['user_id']    = 1; 
            $assign_nutritionist_notification = $this->base_notification->create($notify_arr);
 
            //operation manger notification
            $notify_arr['message']    = 'Nutrtionist '.$login_user_details->name.' change health details for subscriber '.$subscriber_det->subscriber_name.'!';
            $notify_arr['users_role'] = 2 ; 
            $notify_arr['user_id']    = $operation_details->id; 
            $assign_nutritionist_notification = $this->base_notification->create($notify_arr);


            //health udate query             
            $arr_data1               = [];
            $arr_data1['is_active']  = '0';
            $health_details          = $this->base_health->where('subcriber_id','=',$request->input('subscriber_id'))->where('nutritionist_id','=',$request->input('nutritionist_id'))->where('subscriber_health_id','<>',$health_details->id)->update($arr_data1);

            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/add_subscriber_meal_program/'.base64_encode($request->input('subscriber_id')));
        }
        else
        {
            Session::flash('error', $this->Error);
            return \Redirect::back();
        }

    }

    public function menu_edit(Request $request)
    {
       
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
      return view($this->folder_path.'changemenu_ajax',$data);
    }

    public function get_menu(Request $request)
    {
       
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
         
         //create meal_type array 
         foreach ( $menu_type[$key] as $key2 => $mtyvalue) {
            if(!in_array($mtyvalue,$meal_type_array)){
              $meal_type_array [] = $mtyvalue;
            }   
         } 
 
          $specification_array [$key]  = explode(',',$menu_value['specification_id']); 
          foreach ($specification_array[$key] as $key3 => $spavalue) {
            if(!in_array($spavalue,$specification_array_f)){
                $specification_array_f [] = $spavalue;
            }
          }

          $result =  array_intersect($menu_specification,$specification_array_f);
     
          if(count($result)>0 && in_array($request->meal_type,$meal_type_array) && $menu_value->menu_category_id==$menu_category){
             
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

    public function get_menu_macros(Request $request)
    {
         $menu_id   = $request->menu_id;
         $menu_data =  $this->base_menu->where('id','=',$menu_id)->select('calories','proteins','carbohydrates','fats')->first();
         $data      = [];
         $data[]      = $menu_data->calories;
         $data[]      = $menu_data->proteins;
         $data[]      = $menu_data->carbohydrates;
         $data[]      = $menu_data->fats;
         $html        ="<thead>
                            <tr style='background-color:#cacaca!important;'>
                              <td class='text-center'><strong>Calories</strong></td>
                              <td class='text-center'><strong>Proteins</strong></td>
                              <td class='text-center'><strong>Carbohydrates</strong></td>
                              <td class='text-center'><strong>Fats</strong></td>
                              <td class='text-center'><strong>Total</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                             <td class='text-center'>".$menu_data->calories."</td>
                             <td class='text-center'>".$menu_data->proteins."</td>
                             <td class='text-center'>".$menu_data->carbohydrates."</td>
                             <td class='text-center'>".$menu_data->fats."</td>
                             <td class='text-center'>".array_sum($data)."</td>
                            </tr>
                        </tbody>"; 
        return $html; 

    }

    public function store_change_menu(Request $request)
    {
         
        $id                   = $request->input('program_id');
        $arr_data['mealtype'] = $request->input('meal_type');
        $arr_data['menu_id']  = $request->input('menu_id');
        $menu_update          = $this->base_model->where(['program_id'=>$id])->update($arr_data);
        
        $subscriber_id         = $this->base_model->where(['program_id'=>$id])->select('subcriber_id')->first();

        //notifications
        $login_user_details     = Session::get('user');
        $nutritionist_id        = $login_user_details->id;
        //get subscriber  details
        $subscriber_det         = \DB::table('nutri_dtl_subscriber')->where('id','=',$subscriber_id->subcriber_id)->first();
        
        //operation details 
        $operation_details        = \DB::table('users')->where('area','=',$login_user_details->area)->where('roles','=',2)->first();

        //subscriber  notification
        $notify_arr['message']    = 'Nutrtionist '.$login_user_details->name.' change meal program menu for subscriber '.$subscriber_det->subscriber_name.'!';
        $notify_arr['users_role'] = "subscriber" ; 
        $notify_arr['user_id']    = $subscriber_det->subscriber_id; 
        $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

        //admin notification 
        $notify_arr['message']    = 'Nutrtionist '.$login_user_details->name.' change meal program menu for subscriber '.$subscriber_det->subscriber_name.'!';
        $notify_arr['users_role'] = 'admin' ; 
        $notify_arr['user_id']    = 1; 
        $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

        //operation manger notification
          $notify_arr['message']    = 'Nutrtionist '.$login_user_details->name.' change meal program menu for subscriber '.$subscriber_det->subscriber_name.'!';
          $notify_arr['users_role'] = 2 ; 
          $notify_arr['user_id']    = $operation_details->id; 
          $assign_nutritionist_notification = $this->base_notification->create($notify_arr);

        Session::flash('success', $this->Insert);
        return \Redirect::to('admin/add_subscriber_meal_program/'.base64_encode($request->input('subscriber_id')));



    }

    public function view_details(Request $request)
    {
         
         
         $id                     = $request->input('sid');
         $login_user_details     = Session::get('user');
         $nutritionist_id        = $login_user_details->id;
         //get details 
         $get_subscriber_details = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_dtl_subscription_duration','nutri_dtl_subscriber.duration_id','=','nutri_dtl_subscription_duration.duration_id')
                                    ->join('nutri_mst_subscription_plan','nutri_dtl_subscriber.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                                    ->where('nutri_dtl_subscriber.id','=',$id)
                                    ->select('nutri_dtl_subscriber.*','nutri_mst_subscription_plan.sub_name','nutri_dtl_subscription_duration.duration as no_of_days')
                                    ->first();
            //dd($get_subscriber_details);
          //subscription Plan &  duration id
            $sub_plan_id = $get_subscriber_details->sub_plan_id;
            $duration_id = $get_subscriber_details->duration_id;
          // default_menu add on subscriber
            $get_default_menu = $this->base_default_meal
                              ->where('duration_id','=',$duration_id)
                              ->where('sub_plan_id','=',$sub_plan_id)
                              ->get();


             if(!is_null($get_default_menu))
             {
                    $arr_data = []; 
                    //assign defualt meal data in subscriber   
                     $Is_exists  =  $this->base_subscriber_default_meal
                                    ->where('subcriber_id','=',$id)
                                    ->where('nutritionist_id','=',$nutritionist_id)
                                    ->where('duration_id','=',$duration_id)
                                    ->where('sub_plan_id','=',$sub_plan_id)
                                    ->count();
                    if($Is_exists == 0)
                    { 
                        foreach ($get_default_menu as $default_value) 
                        {
                            
                            $arr_data['day']              = $default_value->day;
                            $arr_data['sub_plan_id']      = $sub_plan_id;
                            $arr_data['duration_id']      = $duration_id;
                            $arr_data['mealtype']         = $default_value->mealtype;
                            $arr_data['menu_id']          = $default_value->menu_id;
                            $arr_data['subcriber_id']     = $id;
                            $arr_data['nutritionist_id']  = $nutritionist_id;
                            $add_subscriber_default_menu  =  $this->base_subscriber_default_meal->create($arr_data);
                        }
                    }  

                   //Render default subscriber menu data
                   /*$get_default_menu = $this->base_subscriber_default_meal
                                      ->where('duration_id','=',$duration_id)
                                      ->where('sub_plan_id','=',$sub_plan_id)
                                      ->where('subcriber_id','=',$id)
                                      ->get();*/ 
                   $get_default_menu   = \DB::table('nutri_subscriber_meal_program')
                                          ->join('meal_type','nutri_subscriber_meal_program.mealtype','=','meal_type.meal_type_id')
                                          ->join('nutri_mst_menu','nutri_subscriber_meal_program.menu_id','=','nutri_mst_menu.id')
                                          ->where('nutri_subscriber_meal_program.sub_plan_id','=',$sub_plan_id)
                                          ->where('nutri_subscriber_meal_program.duration_id','=',$duration_id)
                                          ->where('nutri_subscriber_meal_program.subcriber_id','=',$id)
                                          ->select('nutri_subscriber_meal_program.*','nutri_mst_menu.menu_title','nutri_mst_menu.calories','nutri_mst_menu.proteins','nutri_mst_menu.carbohydrates','nutri_mst_menu.fats','meal_type.meal_type_name','meal_type.meal_type_id')->get();
                  //dd($get_default_menu);        

                  $health_details = $this->base_health->where('subcriber_id','=',$id)->where('nutritionist_id','=',$nutritionist_id)->orderBy('subscriber_health_id', 'DESC')->first();   
                  
                  $data=[];
                  
                  if(!empty($health_details))
                  {
                    $data['health_details']         = $health_details;
                    
                  }

                  $data['page_name']                = "Add";
                  $data['title']                    = $this->title;
                  $data['url_slug']                 = $this->url_slug;
                  $data['default_menu_not_Assign']  = "yes";
                  $data['subscriber']               = $get_subscriber_details;
                  $data['subscriber_id']            = $id;
                  $data['nutritionist_id']          = $nutritionist_id;
                  $data['get_default_menu']         = $get_default_menu;
                  

                  return view($this->folder_path.'view',$data);
               }
                else
               {
                  $data=[];
                  $data['page_name']                = "Add";
                  $data['title']                    = $this->title;
                  $data['url_slug']                 = $this->url_slug;
                  $data['default_menu_not_Assign']  = "No";
                  $data['subscriber_id']            = $id;
                  $data['nutritionist_id']          = $nutritionist_id;
                  $data['subscriber']               = $get_subscriber_details;
                  return view($this->folder_path.'view',$data);
               } 
    
    }



}
