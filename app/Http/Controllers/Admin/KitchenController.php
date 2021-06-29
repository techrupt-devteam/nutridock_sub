<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use App\Models\KitchenTarget;
use App\Models\KitchenUser;
use App\Models\Location;
use App\Models\City;
use App\Models\State;
use App\Models\User;
use App\Models\MenuModel;
use App\Models\SubscriptionPlan;
use App\Models\Role;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
class KitchenController extends Controller
{
    public function __construct(Kitchen $Kitchen,Location $Location,City $City,State $State,SubscriptionPlan $SubscriptionPlan,KitchenUser $KitchenUser,User $User,MenuModel $MenuModel,Role $Role,KitchenTarget $KitchenTarget)
    {
        $data                         = [];
        $this->base_model             = $Kitchen; 
        $this->base_kitchen_user      = $KitchenUser; 
        $this->base_target            = $KitchenTarget; 
        $this->base_location          = $Location; 
        $this->base_city              = $City; 
        $this->base_state             = $State; 
        $this->base_user              = $User; 
        $this->base_menu_model        = $MenuModel; 
        $this->base_role              = $Role; 
        $this->base_subscription_plan = $SubscriptionPlan; 
        $this->title                  = "Cloud Kitchen";
        $this->url_slug               = "kitchen";
        $this->folder_path            = "admin/kitchen/";
        //Message
        $this->Insert          = Config::get('constants.messages.Insert');
        $this->Update          = Config::get('constants.messages.Update');
        $this->Delete          = Config::get('constants.messages.Delete');
        $this->Error           = Config::get('constants.messages.Error');
        $this->Is_exists       = Config::get('constants.messages.Is_exists');
    }
    
    // folder index view call  function
    public function index()
    {
        $arr_data = [];
        $city = Session::get('login_city_id');
        if($city!="all")
        {

            $data   = \DB::table('nutri_mst_kitchen')
                         ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                         ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                         ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                         ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*')
                         ->where('nutri_mst_kitchen.city_id','=',$city);
        }
        else
        {

            $data     = \DB::table('nutri_mst_kitchen')
                     ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                     ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                     ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                     ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*');
        }             


              $data = $data->where('nutri_mst_kitchen.is_deleted','<>',1)
                     ->orderBy('kitchen_id', 'DESC')
                     ->get();
       
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
 

    // folder add view call function for insert data
    public function add()
    {
       
        $state              = $this->base_state->get();
        $menu_model         = $this->base_menu_model->select('menu_title','id')->where('is_active','=',1)->get();
        $users              =  \DB::table('users')
                                ->join('role','users.roles','=','role.role_id')
                                ->join('state','users.state','=','state.id')
                                ->join('city','users.city','=','city.id')
                                ->join('locations','users.area','=','locations.id')
                                ->select('role.role_name','users.*','state.name as state_name','city.city_name','locations.area as area_name')
                                ->where('users.is_deleted','<>',1)
                                ->where('users.is_active','=',1)
                                ->orderBy('users.id', 'DESC')
                                ->get(); 
        //dd($users);
        $subscription_plan  = $this->base_subscription_plan->where('is_active','=',1)->where('is_deleted','<>',1)->get();
        $data['page_name']  = "Add";
        $data['subscriptionplan'] = $subscription_plan;
        $data['menu']       = $menu_model;
        $data['users']      = $users;
        $data['state']      = $state;
        $data['title']      = $this->title;
        $data['url_slug']   = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }


    //store  save function     
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                "kitchen_name" => 'required',
                "customer_key" => 'required',
                "state_id"     => 'required',
                "city_id"      => 'required',
                "area_id"      => 'required',
                "pincode"      => 'required',
                "address"      => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['kitchen_name'=>$request->input('kitchen_name')])->where('is_deleted','<>',1)->count();

        if($is_exist)
        {
            Session::flash('error',  $this->Is_exists);
            return \Redirect::back();
        }

        
        $menu_data         = implode(",",$request->input('menu'));
        $subscriptionplan_data = implode(",",$request->input('subscription_plan'));
        $users_data        = implode(",",$request->input('users'));

        $arr_data                    = [];
        $arr_data['kitchen_name']    = $request->input('kitchen_name');
        $arr_data['customer_key']    = $request->input('customer_key');
        $arr_data['state_id']        = $request->input('state_id');
        $arr_data['city_id']         = $request->input('city_id');
        $arr_data['area_id']         = $request->input('area_id');
        $arr_data['pincode']         = $request->input('pincode');
        $arr_data['address']         = $request->input('address');
        $arr_data['menu_id']         = $menu_data;
        $arr_data['sub_plan_id']     = $subscriptionplan_data;
        //$arr_data['user_id']         = $users_data;

        $store_kitchen = $this->base_model->create($arr_data);
      
        if(!empty($store_kitchen))
        {
//dd($store_kitchen->kitchen_id);
            $user = $request->input('users');
            foreach($user as $uid){
                
                $arr_data1['kitchen_id'] =  $store_kitchen->kitchen_id;
                $arr_data1['user_id']    =  $uid;
                     $users              =  \DB::table('users')
                                            ->where('id','=',$uid)
                                            ->select('roles')
                                            ->first();
               $arr_data1['role_id']     =  $users->roles;  
                
                $this->base_kitchen_user->create($arr_data1);
            }
            
            Session::flash('success',  $this->Insert);
            return \Redirect::to('admin/manage_kitchen');
        }
        else
        {
            Session::flash('error',  $this->Error);
            return \Redirect::back();
        }
    }
   
    // folder edit view call function for edit 
    public function edit($id)
    {
        $id             = base64_decode($id);
        $arr_data       = [];
        $data           = $this->base_model->where(['kitchen_id'=>$id])->first();
        $user_data      = $this->base_kitchen_user->where(['kitchen_id'=>$id])->select('user_id')->get();
        $user_id_arr    = []; 
        foreach ($user_data as $key => $uid) {
           $user_id_arr[] = $uid->user_id;
        }
     
        $state          = $this->base_state->get();
        $menu_model     = $this->base_menu_model->select('menu_title','id')->where('is_active','=',1)->get();
        $users          =  \DB::table('users')
                                ->join('role','users.roles','=','role.role_id')
                                ->join('state','users.state','=','state.id')
                                ->join('city','users.city','=','city.id')
                                ->join('locations','users.area','=','locations.id')
                                ->select('role.role_name','users.*','state.name as state_name','city.city_name','locations.area as area_name')
                                ->where('users.is_deleted','<>',1)
                                ->where('users.is_active','=',1)
                                ->orderBy('users.id', 'DESC')
                                ->get(); 
        //dd($users);
        $subscription_plan  = $this->base_subscription_plan->where('is_active','=',1)->where('is_deleted','<>',1)->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
       
        $data['data']      = $arr_data;
        $data['user_data'] = $user_id_arr;
        $data['page_name'] = "Edit";
        $data['subscriptionplan'] = $subscription_plan;
        $data['menu']       = $menu_model;
        $data['users']      = $users;
        $data['state']     = $state;
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    // update function 
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                "kitchen_name" => 'required',
                "customer_key" => 'required',
                "state_id"     => 'required',
                "city_id"      => 'required',
                "area_id"      => 'required',
                "pincode"      => 'required',
                "address"      => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('kitchen_id','<>',$id)->where(['kitchen_name'=>$request->input('kitchen_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }

        $menu_data                   = implode(",",$request->input('menu'));
        $subscriptionplan_data       = implode(",",$request->input('subscription_plan'));
       // $users_data                  = implode(",",$request->input('users'));

        $arr_data                    = [];
        $arr_data['kitchen_name']    = $request->input('kitchen_name');
        $arr_data['customer_key']    = $request->input('customer_key');
        $arr_data['state_id']        = $request->input('state_id');
        $arr_data['city_id']         = $request->input('city_id');
        $arr_data['area_id']         = $request->input('area_id');
        $arr_data['pincode']         = $request->input('pincode');
        $arr_data['address']         = $request->input('address');
         $arr_data['menu_id']        = $menu_data;
        $arr_data['sub_plan_id']     = $subscriptionplan_data;
        //$arr_data['user_id']         = $users_data;

        $update_kitchen  = $this->base_model->where(['kitchen_id'=>$id])->update($arr_data);
        if($update_kitchen){

            $this->base_kitchen_user->where(['kitchen_id'=>$id])->delete();

            $user = $request->input('users');
            foreach($user as $uid){
            
                $arr_data1['kitchen_id'] =  $id;
                $arr_data1['user_id']    =  $uid;
                     $users              =  \DB::table('users')
                                            ->where('id','=',$uid)
                                            ->select('roles')
                                            ->first();
               $arr_data1['role_id']     =  $users->roles;  
               $this->base_kitchen_user->create($arr_data1);
            
            }
        }

        Session::flash('success', $this->Update);
        return \Redirect::to('admin/manage_kitchen');
        
    }

  

    public function delete($id)
    {
        $id=base64_decode($id);
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['kitchen_id'=>$id])->update($arr_data);
        Session::flash('success',  $this->Delete);
        return \Redirect::back();
    } 

    public function status(Request $request)
    {
        $status  = $request->status;
        $id = $request->plan_ids;
        $arr_data               = [];
        if($status=="true")
        {
           $arr_data['is_active'] = '1';
        }
        if($status=="false")
        {
           $arr_data['is_active'] = '0';
        }   
        $this->base_model->where(['id'=>$id])->update($arr_data);
        //return \Redirect::back();
    }
    
    public function detail(Request $request)
    {
        $kitchen_id = $request->input('kitchen_id');   

        $kitchen            = $this->base_model->where(['kitchen_id'=>$kitchen_id])->first();

      
       // $user_data         = explode(",",  $kitchen->user_id); 
        $menu_data         = explode(",",  $kitchen->menu_id); 
        $subscription_data = explode(",",  $kitchen->sub_plan_id); 


        $state              = $this->base_state->get();
        $menu_model         = $this->base_menu_model->select('menu_title','id')->whereIn('id', $menu_data)->get();

         $user_data      = $this->base_kitchen_user->where(['kitchen_id'=>$kitchen_id])->select('user_id')->get();
        $user_id_arr    = []; 
        foreach ($user_data as $key => $uid) {
           $user_id_arr[] = $uid->user_id;
        }
     
        $users              =   \DB::table('users')
                                ->join('role','users.roles','=','role.role_id')
                                ->join('state','users.state','=','state.id')
                                ->join('city','users.city','=','city.id')
                                ->join('locations','users.area','=','locations.id')
                                ->select('role.role_name','users.*','state.name as state_name','city.city_name','locations.area as area_name')
                                ->where('users.is_deleted','<>',1)
                                ->where('users.is_active','=',1)
                                ->whereIn('users.id', $user_id_arr)
                                ->orderBy('users.id', 'DESC')
                                ->get(); 
        //dd($users);
        $subscription_plan  = $this->base_subscription_plan->where('is_active','=',1)->whereIn('sub_plan_id', $subscription_data)->where('is_deleted','<>',1)->get();




        $html='<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">'.$kitchen->kitchen_name.'</h4>
                </div>
                <div class="modal-body">
                  <div class="row">
                    <div class="col-md-12"><h6><b>Customer Key:</b>'.$kitchen->customer_key.'</h6></div>
                  </div>
                  <hr/>
                  <div class="row">
                    <div class="col-md-12"> 
                       <div class="panel panel-info">
                          <div class="panel-heading"><b>Assign User</b></div>
                          <div class="panel-body"><ul>';
                            foreach ($users as $key => $uvalue) {
                                 $html .= '<li>'.$uvalue->name.'   Role:-<b>'.$uvalue->role_name.'</b></li>';
                            }
                    $html .= '</ul></div>
                        </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-md-12"> 
                        <div class="panel panel-warning">
                            <div class="panel-heading"><b>Subscription plan</b></div>
                            <div class="panel-body"><ul>';
                            foreach ($subscription_plan as $key => $svalue) {
                                 $html .= '<li>'.$svalue->sub_name.'</li>';
                            }
                    $html .= '</ul></div>
                        </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-md-12"> 
                        <div class="panel panel-danger">
                          <div class="panel-heading"><b>Assign Menu</b></div>
                          <div class="panel-body"><ul>';
                          
                          foreach ($menu_model as $key => $mvalue) {
                            $html .= '<li>'.$mvalue->menu_title.'</li>';
                          }

                          $html .= '</ul></div>
                        </div>
                    </div>
                 </div>
                </div>
                <div class="modal-footer">
               </div>';
        return $html;
    } 

    public function kitchen_target(Request $request)
    {
        $id           = $request->id;
        $data         = $this->base_model->where(['kitchen_id'=>$id])->first();
        $data['data'] = $data;
        return view($this->folder_path.'add_target',$data);
    }

    public function view_target(Request $request)
    {
        $id           = base64_decode($request->id);
        $data         = \DB::table('nutri_trn_kitchen_target')
                         ->join('nutri_mst_kitchen','nutri_trn_kitchen_target.kitchen_id','=','nutri_mst_kitchen.kitchen_id')
                         ->select('nutri_mst_kitchen.kitchen_name','nutri_trn_kitchen_target.*')
                         ->where('nutri_trn_kitchen_target.kitchen_id','=',$id)
                         ->where('nutri_trn_kitchen_target.is_deleted','<>',1)
                         ->get()->toArray();
        //dd($data);                  
        $data['data']      = $data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = 'target';
        $data['title']     = "Target";
        return view($this->folder_path.'target_index',$data);
    }

    public function store_target(Request $request)
    {
        $validator = Validator::make($request->all(), [
                "kitchen_id"    => 'required',
                "month"         => 'required',
                "target_amt"    => 'required'
             
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_target->where(['month'=>$request->input('month'),'kitchen_id'=>$request->input('kitchen_id'),'is_deleted'=>0])->count();

        if($is_exist)
        {
            Session::flash('error', "Kitchen target already set.");
            return \Redirect::back();
        }

        $arr_data                      = [];
        $arr_data['kitchen_id']        = $request->input('kitchen_id');
        $arr_data['month']             = date('M-Y',strtotime($request->input('month')));
        $arr_data['year']              = date('Y',strtotime($request->input('month')));
        $arr_data['target_amt']        = $request->input('target_amt');
        $store_kitchen_target          = $this->base_target->create($arr_data);
        
        if(!empty($store_kitchen_target))
        {
            Session::flash('success',  "Kitchen target added succesfully");
            return \Redirect::to('admin/manage_kitchen');
        }
        else
        {
            Session::flash('error',  $this->Error);
            return \Redirect::back();
        }
    }


    public function delete_target($id)
    {
        $id=base64_decode($id);
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_target->where(['target_kitchen_id'=>$id])->update($arr_data);
        Session::flash('success',"Target delete succesfully.");
        return \Redirect::to('admin/manage_kitchen');
    } 

   
}
