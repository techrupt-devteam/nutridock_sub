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
    public function __construct(AssignSubcriptionplanMenu $AssignSubcriptionplanMenu,SubscriptionPlan $SubscriptionPlan,MenuModel $MenuModel,SubscriptionPlanDetails $SubscriptionPlanDetails,MealType $MealType)
    {
        $data                               = [];
        $this->base_model                   = $AssignSubcriptionplanMenu; 
        $this->base_menu                    = $MenuModel; 
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

    //Assign Menu Add Function 
    public function add()
    {
        $subscription_plan         = $this->base_subscription_plan->get();
        $menu                      = $this->base_menu->get();
        $data['page_name']         = "Add";
        $data['menu']              = $menu;
        $data['subscription_plan'] = $subscription_plan;
        $data['title']             = $this->title;
        $data['url_slug']          = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    //Assign Menu Store Function
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
                'sub_plan_id' => 'required',
                'menu_id' => 'required'

            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
   
        $menu_id_data = implode(",",$request->input('menu_id'));

        $arr_data                  = [];
        $arr_data['sub_plan_id']   = $request->input('sub_plan_id');
        $arr_data['menu_id']       = $menu_id_data;
        
        $assign_menu_subscription_plan  = $this->base_model->create($arr_data);
        if(!empty($assign_menu_subscription_plan))
        {
          
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_assign_sub_plan_menu');
        }
        else
        {
            Session::flash('error', $this->Error );
            return \Redirect::back();
        }
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
        $subscription_plan = $this->base_subscription_plan->get();
        $menu              = $this->base_menu->get();
        $data['data']      = $arr_data;
        $data['subscription_plan']     = $subscription_plan;
        $data['menu']      = $menu;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    //Assign Menu update function
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
              'sub_plan_id'  => 'required',
              'menu_id'      => 'required'
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $menu_id_data = implode(",",$request->input('menu_id'));

        $arr_data                  = [];
        $arr_data['sub_plan_id']   = $request->input('sub_plan_id');
        $arr_data['menu_id']       = $menu_id_data;
        
        $assign_location_menu_update = $this->base_model->where(['assign_sub_menu_id'=>$id])->update($arr_data);
        
        Session::flash('success', $this->Update );
        return \Redirect::to('admin/manage_assign_sub_plan_menu');   

    }

    //Assign Menu delete function
    public function delete($id)
    {
        $id = base64_decode($id);
        $this->base_model->where(['assign_sub_menu_id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
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
                                    ->select('nutri_mst_subscription_plan.sub_name')
                                    ->first();

        $duration_days = $request->no_of_days;
        $get_menu      = $this->base_menu->get();
        $get_meal_type = $this->base_meal_type->get();
        $html='<div class="modal-header"> <button type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                          <td><input type="text" name="days'.$i.'" value="'.$i.' Day" class="form-control"></td>
                          <td><select name="breakfast'.$i.'" id="breakfast'.$i.'" class="form-control select2">
                                   <option value="">-select-</option>';
                                     foreach ($get_menu as $menu_value) {
                                        $html .= "<option value=".$menu_value->id.">".$menu_value->menu_title."</option>";
                                     }
                         $html .= '</select>
                          </td>
                          <td><select name="lunch'.$i.'" id="lunch'.$i.'" class="form-control select2">
                                   <option value="">-select-</option>';
                                
                                     foreach ($get_menu as $menu_value) {
                                        $html .= "<option value=".$menu_value->id.">".$menu_value->menu_title."</option>";
                                     }
                         $html .= '</select>
                            </td>
                            <td><select name="snack'.$i.'" id="snack'.$i.'" class="form-control select2">
                                   <option value="">-select-</option>';
                                
                                     foreach ($get_menu as $menu_value) {
                                        $html .= "<option value=".$menu_value->id.">".$menu_value->menu_title."</option>";
                                     }
                         $html .= '</select>

                          </td><td><select name="dinner'.$i.'" id="dinner'.$i.'" class="form-control select2">
                                   <option value="">-select-</option>';
                                
                                     foreach ($get_menu as $menu_value) {
                                        $html .= "<option value=".$menu_value->id.">".$menu_value->menu_title."</option>";
                                     }
                         $html .= '</select></td>  
                         </tr>';
            }
            
            $html .=" <tbody>
                     </table>
                    </div>
                   </div>
                </div><div class='modal-footer'><button type='submit' class='btn btn-primary'>Submit</button>
                </div> ";   
            return $html;    
    }
   
}
