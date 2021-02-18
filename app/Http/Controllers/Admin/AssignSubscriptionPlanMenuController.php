<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\MenuModel;
use App\Models\AssignSubcriptionplanMenu;
use App\Models\SubscriptionPlan;
use App\Models\SubscriptionPlanDetails;
use App\Models\city;
use App\Models\DefaultMeal;
use App\Models\State;
use App\Models\MealType;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Config;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;
class AssignSubscriptionPlanMenuController extends Controller
{
    public function __construct(AssignSubcriptionplanMenu $AssignSubcriptionplanMenu,SubscriptionPlan $SubscriptionPlan,MenuModel $MenuModel,SubscriptionPlanDetails $SubscriptionPlanDetails,MealType $MealType,DefaultMeal $DefaultMeal)
    {
        $data                               = [];
        $this->base_model                   = $AssignSubcriptionplanMenu; 
        $this->base_menu                    = $MenuModel; 
        $this->base_default_meal            = $DefaultMeal; 
        $this->base_meal_type               = $MealType; 
        $this->base_subscription_plan       = $SubscriptionPlan; 
        $this->base_subscription_plan_dtl   = $SubscriptionPlanDetails; 
        $this->title                        = "Assign Menu To Subscription Plan";
        $this->url_slug                     = "assign_sub_plan_menu";
        $this->folder_path                  = "admin/assign_sub_plan_menu/";
        
        //Message
        $this->Insert                       = Config::get('constants.messages.Insert');
        $this->Update                       = Config::get('constants.messages.Update');
        $this->Delete                       = Config::get('constants.messages.Delete');
        $this->Error                        = Config::get('constants.messages.Error');
        $this->Is_exists                    = Config::get('constants.messages.Is_exists');
    }


    //Assign Menu Listing Function
    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('nutri_mst_assign_subscription_plan_menu')
                        ->join('nutri_mst_subscription_plan','nutri_mst_assign_subscription_plan_menu.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                        ->select('nutri_mst_subscription_plan.sub_name','nutri_mst_assign_subscription_plan_menu.*')
                        ->get();
      //  dd($data);
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }     
       
        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }

    public function add()
    { 
        $get_assign_sub_plan_id   = $this->base_model->select('sub_plan_id')->get();
        
        $sub_plan_id_arr = [];
        
        foreach($get_assign_sub_plan_id  as $sub_plan_value ){
          $sub_plan_id_arr[] = $sub_plan_value->sub_plan_id;
        }

        $subscription_plan         = $this->base_subscription_plan->whereNotIn('sub_plan_id',$sub_plan_id_arr)->where('is_active','=','1')->where('is_deleted','<>','1')->get();
        //$menu                      = $this->base_menu->get();
        $data['page_name']         = "Add";
        //$data['menu']              = $menu;
        $data['subscription_plan'] = $subscription_plan;
        $data['title']             = $this->title;
        $data['url_slug']          = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    //Assign Menu Function
    public function edit($id)
    {
        $id= base64_decode($id);
        $arr_data = [];
        $data     = $this->base_model->where(['assign_sub_menu_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
        $subscription_plan              = $this->base_subscription_plan->where('is_active','=','1')->where('is_deleted','<>','1')->get();
        $subscription_plan_dtl          = $this->base_subscription_plan_dtl->where('sub_plan_id','=',$data->sub_plan_id)->orderBy('duration','ASC')->get();
        $default_meal                   = $this->base_default_meal->where('sub_plan_id','=',$data->sub_plan_id)->groupBy('duration_id')->get();
        $data['data']                   = $arr_data;
        $data['subscription_plan']      = $subscription_plan;
        $data['subscription_plan_dtl']  = $subscription_plan_dtl;
        $data['default_meal']           = $default_meal;
        $data['page_name']              = "Edit";
        $data['url_slug']               = $this->url_slug;
        $data['title']                  = $this->title;

        return view($this->folder_path.'edit',$data);
    }


    //Assign Menu delete function
    public function delete($id)
    {
        $id = base64_decode($id);
        
        $sub_plan_id = $this->base_model->where(['assign_sub_menu_id'=>$id])->select('sub_plan_id')->first();
        $is_exists   = $this->base_default_meal->where('sub_plan_id','=',$sub_plan_id->sub_plan_id)->get()->count();
        if($is_exists>0)
        {
            Session::flash('error', 'Record can not deleted default menu is assign on subscription plan');
            return \Redirect::back();
        }else{
             $delete = $this->base_model->where(['assign_sub_menu_id'=>$id])->delete();

            Session::flash('success', 'Success! Record deleted successfully.');
            return \Redirect::back();
        }   
    } 

    //get subscription plan Days 
    public function get_days(Request $request)
    {
       $id   = $request->plan_id; 
       $get_days = $this->base_subscription_plan_dtl->where(['sub_plan_id'=>$id])->orderBy('duration','ASC')->get();

       $html ="<div class='form-group'><label>Add Default Menu<span style='color:red;' >*</span></label><table class='table table-bordered'>
                 <thead>
                   <tr>
                    <th>Days</th>
                    <th class='text-center'>Action</th>
                   </tr>
                 </thead>
               <tbody>";
       foreach ($get_days as $key => $value) {
         $html .="<tr>
                       <td>".$value->duration." Days 
                          <input type='hidden' name='duration_days' value=".$value->duration
                          ."> 
                       </td>
                       <td class='text-center'><a href='javascript:void(0)' class='btn btn-sm btn-primary' onclick='viewDetails(".$value->duration_id.",".$value->duration.");'><i class='fa fa-plus'></i> Add Default Menu</a></td>
                   </tr>";
       }        
       $html .="</tbody></table></div>";
       return $html;

    }

    //load day wise menu  add entry 
    public function default_menu_add(Request $request)
    {
        $duration_id   = $request->id;

        $get_subplan_namedata     = \DB::table('nutri_dtl_subscription_duration')
                                    ->join('nutri_mst_subscription_plan','nutri_dtl_subscription_duration.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                                    ->where('nutri_dtl_subscription_duration.duration_id','=',$duration_id)
                                    ->select('nutri_mst_subscription_plan.sub_name','nutri_mst_subscription_plan.sub_plan_id')
                                    ->first();

        $duration_days = $request->no_of_days;
        $get_menu      = $this->base_menu->get();
        $get_meal_type = $this->base_meal_type->get();
        $html='<form  action="'.url('/admin').'/store_meal_plan" id="pm" method="post" role="form" 
                        data-parsley-validate="parsley" enctype="multipart/form-data"> 
                        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Create meal program planwise for plan name <strong>'.ucfirst($get_subplan_namedata->sub_name).'</strong> duration <strong>'.$duration_days.'</strong> Days </h4> 
               </div>
               <div class="modal-body">
                 <div class="row">
                   <div class="col-md-12">
                   <div class="col-md-12">
                   ';
        $html.="<table class='table table-striped'>
                <thead>
                  <tr>
                    <th>Days</th>";
                     foreach ($get_meal_type as $mtvalue) {
                        $html .="<th>".ucfirst($mtvalue->meal_type_name)."</th>"; 
                     } 
            $html .="</tr>  
                       <thead>
                       <tbody>";
            for($i=1;$i<=$duration_days;$i++)
            {
                $html .='<tr>
                          <td>
                          <input type="text" name="days'.$i.'" value="'.$i.' Day" class="form-control" data-parsley-errors-container="#days'.$i.'_error" data-parsley-error-message="Please enter days." required="true">
                           <div id="days'.$i.'_error"></div>
                          </td>';
                     foreach ($get_meal_type as $mtvalue) {
                       
                        $html .= '<td>
                            <select name="'.lcfirst($mtvalue->meal_type_name).''.$i.'" id="'.lcfirst($mtvalue->meal_type_name).''.$i.'" class="form-control select2" data-parsley-errors-container="#'.lcfirst($mtvalue->meal_type_name).''.$i.'_error" data-parsley-error-message="Please select ." required="true">
                                   <option value="">-select-</option>';
                                     foreach ($get_menu as $menu_value) {
                                        $html .= "<option value=".$menu_value->id.">".$menu_value->menu_title."</option>";
                                     }
                        $html .= '</select><div id="'.lcfirst($mtvalue->meal_type_name).''.$i.'_error">
                                </div><input type="hidden" name="'.lcfirst($mtvalue->meal_type_name).'_meal_type'.$i.'" value="'.$mtvalue->meal_type_id.'">
                        </td>';
                     
                     }
                         $html .= '</tr>
                         <input type="hidden" name="no_of_days"  value="'.$duration_days.'">
                         <input type="hidden" name="duration_id" value="'.$duration_id.'"> 
                         <input type="hidden" name="sub_plan_id" value="'.$get_subplan_namedata->sub_plan_id.'">';
               }
            
            $html .=" <tbody>
                     </table>
                    </div>
                   </div>
                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-primary pull-left' id='modal_div_submit_button'  onclick='chk_click();''>Add</button>
                    <button type='button' class='btn btn-secondary pull-left' data-dismiss='modal'>Close</button>
                </div> 
                </form>";   
            return $html;    
    } 


    //load day wise menu  add entry 
    public function default_menu_edit(Request $request)
    {
        $duration_id   = $request->id;
        $get_subplan_namedata   = \DB::table('nutri_dtl_subscription_duration')
                                    ->join('nutri_mst_subscription_plan','nutri_dtl_subscription_duration.sub_plan_id','=','nutri_mst_subscription_plan.sub_plan_id')
                                    ->where('nutri_dtl_subscription_duration.duration_id','=',$duration_id)
                                    ->select('nutri_mst_subscription_plan.sub_name','nutri_mst_subscription_plan.sub_plan_id')
                                    ->first();

        $duration_days = $request->no_of_days;
        $get_menu      = $this->base_menu->get();
        $get_meal_type = $this->base_meal_type->get();
        $html='<form  action="'.url('/admin').'/update_meal_plan" id="pm" method="post" role="form" 
                        data-parsley-validate="parsley" enctype="multipart/form-data"> 
                        <div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                 <h4 class="modal-title">Edit meal program planwise for plan name <strong>'.ucfirst($get_subplan_namedata->sub_name).'</strong> duration <strong>'.$duration_days.'</strong> Days </h4> 
               </div>
               <div class="modal-body">
                 <div class="row">
                   <div class="col-md-12">
                   <div class="col-md-12">
                   ';
        $html.="<table class='table table-striped'>
                <thead>
                  <tr>
                    <th>Days</th>";
                     foreach ($get_meal_type as $mtvalue) {
                        $html .="<th>".ucfirst($mtvalue->meal_type_name)."</th>"; 
                     } 
            $html .="</tr>  
                       <thead>
                       <tbody>";
            for($i=1;$i<=$duration_days;$i++)
            {
                $html .='<tr>
                          <td>
                          <input type="text" name="days'.$i.'" value="'.$i.' Day" class="form-control" data-parsley-errors-container="#days'.$i.'_error" data-parsley-error-message="Please enter days." required="true" >
                           <div id="days'.$i.'_error"></div>
                          </td>';



                         foreach ($get_meal_type as $mtvalue) {
                           
                            $html .= '<td>
                                <select name="'.lcfirst($mtvalue->meal_type_name).''.$i.'" id="'.lcfirst($mtvalue->meal_type_name).''.$i.'" class="form-control select2" data-parsley-errors-container="#'.lcfirst($mtvalue->meal_type_name).''.$i.'_error" data-parsley-error-message="Please select ." required="true">
                                       <option value="">-select-</option>';
                                         foreach ($get_menu as $menu_value) {

                                            $insertd_menu_check = $this->base_default_meal
                                                                 ->where('duration_id','=',$duration_id)
                                                                 ->where('day','=',$i)
                                                                 ->where('mealtype','=',$mtvalue->meal_type_id)
                                                                 ->select('menu_id')
                                                                 ->first();

                                            if($insertd_menu_check->menu_id==$menu_value->id)
                                            {
                                               $selected ="selected";   
                                            }
                                            else
                                            {
                                               $selected ="";
                                            }                     

                                            $html .= "<option value=".$menu_value->id." ".$selected.">".$menu_value->menu_title."</option>";
                                         }
                            $html .= '</select><div id="'.lcfirst($mtvalue->meal_type_name).''.$i.'_error">
                                    </div><input type="hidden" name="'.lcfirst($mtvalue->meal_type_name).'_meal_type'.$i.'" value="'.$mtvalue->meal_type_id.'">
                            </td>';
                         
                         }
                         $html .= '</tr>
                         <input type="hidden" name="no_of_days"  value="'.$duration_days.'">
                         <input type="hidden" name="duration_id" value="'.$duration_id.'"> 
                         <input type="hidden" name="sub_plan_id" value="'.$get_subplan_namedata->sub_plan_id.'">';
               }
            
            $html .=" <tbody>
                     </table>
                    </div>
                   </div>
                </div>
                <div class='modal-footer'>
                    <button type='submit' class='btn btn-primary pull-left' id='modal_div_submit_button'  onclick='chk_click();''>Update</button>
                        <button type='button' class='btn btn-secondary pull-left' data-dismiss='modal'>Close</button>
                </div> 
                </form>";   
            return $html;    
    }

    //store deafult menu 
    public function store_meal_plan(Request $request)
    {   
        $duration_days  = $request->no_of_days; 
        $duration_id    = $request->duration_id;
        $sub_plan_id    = $request->sub_plan_id;
        $get_meal_type  = $this->base_meal_type->get();
        
        $message = 0;
        $arr_data1                       = [];
        $arr_data                        = [];
        $arr_data1['sub_plan_id']        = $sub_plan_id;
        $assign_menu_subscription_plan   = $this->base_model->create($arr_data1);

        for($i=1;$i<=$duration_days;$i++)
        {   
            
            foreach ($get_meal_type as $mtvalue) {
                $arr_data['day']           = $request->input('days'.$i);
                $arr_data['sub_plan_id']   = $sub_plan_id;
                $arr_data['duration_id']   = $duration_id;
                $arr_data['mealtype']      = $request->input(lcfirst($mtvalue->meal_type_name).'_meal_type'.$i);
                $arr_data['menu_id']       = $request->input(lcfirst($mtvalue->meal_type_name).''.$i);
                $assign_menu_subscription_plan  =  $this->base_default_meal->create($arr_data);
                if($assign_menu_subscription_plan){
                    $message++;
                }
                else
                {
                    $message = 0;
                }
            }   
        
        }
        
        if($message > 0)
        {
          Session::flash('success', $this->Insert);
           
        }
        else
        {
          Session::flash('error', $this->Error );
        }
        return \Redirect::to('admin/manage_assign_sub_plan_menu');
    } 

    public function update_meal_plan(Request $request)
    {   
        $duration_days  = $request->no_of_days; 
        $duration_id    = $request->duration_id;
        $sub_plan_id    = $request->sub_plan_id;
        $get_meal_type  = $this->base_meal_type->get();
        
        $message = 0;
        $arr_data                        = [];

         
         $delete =  $this->base_default_meal
                   ->where('sub_plan_id','=',$sub_plan_id)
                   ->where('duration_id','=',$duration_id)
                   ->delete();

        for($i=1;$i<=$duration_days;$i++)
        {   
            
            foreach ($get_meal_type as $mtvalue) {
                $arr_data['day']           = $request->input('days'.$i);
                $arr_data['sub_plan_id']   = $sub_plan_id;
                $arr_data['duration_id']   = $duration_id;
                $arr_data['mealtype']      = $request->input(lcfirst($mtvalue->meal_type_name).'_meal_type'.$i);
                $arr_data['menu_id']       = $request->input(lcfirst($mtvalue->meal_type_name).''.$i);
                $assign_menu_subscription_plan  =  $this->base_default_meal->create($arr_data);
                if($assign_menu_subscription_plan){
                    $message++;
                }
                else
                {
                    $message = 0;
                }
            }   
        
        }
        
        if($message > 0)
        {
          Session::flash('success', $this->Insert);
           
        }
        else
        {
          Session::flash('error', $this->Error );
        }
        return \Redirect::to('admin/manage_assign_sub_plan_menu');
    } 




}
