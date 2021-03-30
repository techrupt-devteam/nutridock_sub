<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AssignNutritionist;
use App\Models\Location;
use App\Models\User;
use App\Models\City;
use App\Models\State;
use Pusher\Pusher;
use App\Models\Notification;
use App\Models\SubscriberMaster;
use App\Models\SubscriberDetails;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Config;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;
class AssignNutritionistController extends Controller
{
    public function __construct(AssignNutritionist $AssignNutritionist,Location $Location,City $City,State $State,User $User,Notification $Notification)
    {
        $data                       = [];
        $this->base_model           = $AssignNutritionist; 
        $this->base_users           = $User; 
        $this->base_location        = $Location; 
        $this->base_city            = $City; 
        $this->base_state           = $State; 
        $this->base_notification    = $Notification; 
        $this->title                = "Assign Nutritionist";
        $this->url_slug             = "assign_nutritionist";
        $this->folder_path          = "admin/assign_nutritionist/";
        //Push Notification 
        $this->options = array(
        'cluster' => env('PUSHER_APP_CLUSTER'),
        'encrypted' => true
        );

        //Default set pusher api code 
        $this->pusher = new Pusher(
        env('PUSHER_APP_KEY'),
        env('PUSHER_APP_SECRET'),
        env('PUSHER_APP_ID'), 
        $this->options
        );
        //Message
        $this->Insert        = Config::get('constants.messages.Insert');
        $this->Update        = Config::get('constants.messages.Update');
        $this->Delete        = Config::get('constants.messages.Delete');
        $this->Error         = Config::get('constants.messages.Error');
        $this->Is_exists     = Config::get('constants.messages.Is_exists');
    }

    //Assign Nutritionist Listing Function
    public function index()
    {
        $arr_data = [];
        $city = Session::get('login_city_id');
        if($city!="all")
        {
            $data = \DB::table('nutri_mst_subcriber_assign')
                     ->join('state','nutri_mst_subcriber_assign.state_id','=','state.id')
                     ->join('city','nutri_mst_subcriber_assign.city_id','=','city.id')
                     ->join('users','nutri_mst_subcriber_assign.nutritionist_id','=','users.id')
                     //->join('locations','nutri_mst_assign_location_menu.area_id','=','locations.id')
                     ->select('state.name as state_name','city.city_name','nutri_mst_subcriber_assign.*','users.name')
                     ->where('nutri_mst_subcriber_assign.city_id','=',$city);
        }
        else
        {
            $data = \DB::table('nutri_mst_subcriber_assign')
                     ->join('state','nutri_mst_subcriber_assign.state_id','=','state.id')
                     ->join('city','nutri_mst_subcriber_assign.city_id','=','city.id')
                     ->join('users','nutri_mst_subcriber_assign.nutritionist_id','=','users.id')
                     ->select('state.name as state_name','city.city_name','nutri_mst_subcriber_assign.*','users.name');
              

        }             
             $data = $data->where('nutri_mst_subcriber_assign.is_deleted','<>',1)
                     ->orderBy('nutri_mst_subcriber_assign.subcriber_assign_id', 'DESC')
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

    //Assign Nutritionist Add Function 
    public function add()
    {        
        $state               = $this->base_state->get();
        $data['page_name']  = "Add"; 
        $data['state']      = $state;    
        $data['title']      = $this->title;
        $data['url_slug']   = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    //Assign Nutritionist Store Function
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'subscriber_id'   => 'required',
                'nutritionist_id' => 'required',
                'state_id'        => 'required',
                'city_id'         => 'required'
        ]);

        if($validator->fails()) 
        {
            return $validator->errors()->all();
        }
   
        $subscriber_data   = implode(",",$request->input('subscriber_id'));
        //$nutritionist_data = implode(",",$request->input('nutritionist_id'));

        $arr_data                       = [];
        $arr_data['state_id']           = $request->input('state_id');
        $arr_data['city_id']            = $request->input('city_id');
        $arr_data['subscriber_id']      = $subscriber_data;
        $arr_data['nutritionist_id']    = $request->input('nutritionist_id');
        $assign_nutritionist            = $this->base_model->create($arr_data);
        if(!empty($assign_nutritionist))
        {   
           
    
            // $data['message'] = "New Subscriber asssign";
            // $this->pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);
            /*$notify_arr['message']    = 'New subscriber has been assigned to you!';
            $notify_arr['users_role'] = 1 ; 
            $notify_arr['user_id']    = $request->input('nutritionist_id'); 
            $assign_nutritionist_notification = $this->base_notification->create($notify_arr);*/

            $msg = 0;
            foreach($request->input('subscriber_id') as $value)
            {
                $subscriber_dtl_id = $value; 
                $get_subscriber_data = \DB::table('nutri_dtl_subscriber')
                                       ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                       ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                       ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                       ->select('nutri_dtl_subscriber.subscriber_name','nutri_dtl_subscriber.state','nutri_dtl_subscriber.city','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile','nutri_dtl_subscriber.subscriber_id','nutri_dtl_subscriber.id as subscriber_dtl_id')
                                       ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                                       ->where('nutri_dtl_subscriber.id','=',$value)
                                       ->get()->toArray();

                $subscriber_data = $get_subscriber_data[0];

                $is_exist = $this->base_users->where('subscriber_dtl_id','=',$subscriber_data->subscriber_dtl_id)->where('is_deleted','<>',1)->count();
                if($is_exist)
                {      
                   $arr_data_users['nutritionist_id']      = $request->input('nutritionist_id');
                   $store_subscrbiber_users                = $this->base_users->where(['subscriber_dtl_id'=>$subscriber_data->subscriber_dtl_id])->update($arr_data_users);
                }else{                      
                //add user table to subscriber
                $arr_data_users['name']                 = $subscriber_data->subscriber_name;
                $arr_data_users['email']                = $subscriber_data->subscriber_dtl_id."_".$subscriber_data->email;
                $arr_data_users['mobile']               = $subscriber_data->mobile;
                $arr_data_users['city']                 = $subscriber_data->city;
                $arr_data_users['state']                = $subscriber_data->state;
                $arr_data_users['subscriber_id']        = $subscriber_data->subscriber_id;
                $arr_data_users['subscriber_dtl_id']    = $subscriber_data->subscriber_dtl_id;
                $arr_data_users['nutritionist_id']      = $request->input('nutritionist_id');
                $arr_data_users['roles']                = "subscriber";
                $arr_data_users['password']             = "";            
                $store_subscrbiber_users                = $this->base_users->create($arr_data_users);

                if($store_subscrbiber_users){

                    $arr_dat = []; 
                    $arr_dat['user_id'] = $store_subscrbiber_users->id; 
                    $arr_dat['completed_at'] = 1; 
                    $arr_dat['completed'] = 1;   
                    $activations = \DB::table('activations')->insert($arr_dat);
                }
                else{
                    
                    $msg++;
                } 
                
                    //send notification 
                    $notitification_id = $request->input('nutritionist_id');
                    $nutritionist_dt   = \DB::table('users')->where('id','=',$request->input('nutritionist_id'))
                    ->first();
                    $subscriber_id     = $subscriber_data->subscriber_id;
                    $operation_details = \DB::table('users')->where('area','=',$nutritionist_dt->area)->where('roles','=',2)->first();

                    // notification send    
                    $notify_arr1['message']            = ucfirst($subscriber_data->subscriber_name).' subscriber has been assigned to you!';
                    $notify_arr1['users_role']         = 1 ; 
                    $notify_arr1['user_id']            = $nutritionist_dt->id; 
                    $assign_nutritionist_notification = $this->base_notification->create($notify_arr1);

                    // subscriber send    
                    $notify_arr2['message']            = 'Nurtidock assigned nutrtionist '.$nutritionist_dt->name.'  to subscriber '.$subscriber_data->subscriber_name;
                    $notify_arr2['users_role']         = "subscriber" ; 
                    $notify_arr2['user_id']            = $subscriber_id; 
                    $assign_subscriber_notification   = $this->base_notification->create($notify_arr2);

                    // operation send      
                    $notify_arr3['message']            = 'Nurtidock assigned nutrtionist '.$nutritionist_dt->name.'  to subscriber '.$subscriber_data->subscriber_name;
                    $notify_arr3['users_role']         = 2 ; 
                    $notify_arr3['user_id']            = $operation_details->id; 
                    $assign_operation_notification    = $this->base_notification->create($notify_arr3);




               }
            } 
            if($msg==0) 
            {
             Session::flash('success', $this->Insert);
             return \Redirect::to('admin/manage_assign_nutritionist');
            }
        }
        else
        {
            Session::flash('error', $this->Error );
            return \Redirect::back();
        }
    }

    //Assign Nutritionist Function
    public function edit($id)
    {
        $id= base64_decode($id);
        $arr_data = [];
        $data     = $this->base_model->where(['subcriber_assign_id'=>$id])->first();

        //other assign subscriber data for same city
        $other_asssign_sub_data     = $this->base_model->where('nutritionist_id','<>',$data->nutritionist_id)->select('subscriber_id')->get();
        $assign_subscriber_array = [];
        foreach ($other_asssign_sub_data as $key => $asvalue) {
            
             $subscriber_id  = explode(",", $asvalue['subscriber_id']);
             foreach ($subscriber_id as $subvalue) {
               $assign_subscriber_array[] = $subvalue;
             }

        }


       // dd($assign_subscriber_array);    

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   

        $city                 = $data['city_id'];

        $users                = $this->base_users->where('roles','=',1)->where('is_active','=',1)->where('city','=',$city)->where('is_deleted','<>',1)->get();
        $subscriber           =  \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->where('is_approve','=',1)->get();
        $state                = $this->base_state->get();
        $data['data']         = $arr_data;
        $data['subscriber']   = $subscriber;
        $data['users']        = $users;
        $data['state']        = $state;
        $data['assign_subcriber']    = $assign_subscriber_array;
        $data['page_name']    = "Edit";
        $data['url_slug']     = $this->url_slug;
        $data['title']        = $this->title;
        //dd($subscriber);
        return view($this->folder_path.'edit',$data);
    }

    //Assign Nutritionist update function
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subscriber_id'   => 'required'
            /*'nutritionist_id' => 'required',
            'state_id'        => 'required',
            'city_id'         => 'required'*/
              
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $subscriber_data   = implode(",",$request->input('subscriber_id'));
       // $nutritionist_data = implode(",",$request->input('nutritionist_id'));

        $arr_data                       = [];
        //$arr_data['state_id']           = $request->input('state_id');
       // $arr_data['city_id']            = $request->input('city_id');
        $arr_data['subscriber_id']      = $subscriber_data;
        //$arr_data['nutritionist_id']    = $request->input('nutritionist_id');
        $assign_nutritionist_update   = $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);


        foreach($request->input('subscriber_id') as $value)
            {
                $subscriber_dtl_id = $value; 
                $get_subscriber_data = \DB::table('nutri_dtl_subscriber')
                                       ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                       ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                       ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                       ->select('nutri_dtl_subscriber.subscriber_name','nutri_dtl_subscriber.state','nutri_dtl_subscriber.city','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile','nutri_dtl_subscriber.subscriber_id','nutri_dtl_subscriber.id as subscriber_dtl_id')
                                       ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                                       ->where('nutri_dtl_subscriber.id','=',$value)
                                       ->get()->toArray();

                $subscriber_data = $get_subscriber_data[0];     

                $is_exist = $this->base_users->where('subscriber_dtl_id','=',$subscriber_data->subscriber_dtl_id)->where('is_deleted','<>',1)->count();
                
                if($is_exist)
                {      
                   $arr_data_users['nutritionist_id']      = $request->input('nutritionist_id');
                   $store_subscrbiber_users                = $this->base_users->where(['subscriber_dtl_id'=>$subscriber_data->subscriber_dtl_id])->update($arr_data_users);
                }
                else
                {
                  //add user table to subscriber
                    $arr_data_users['name']                 = $subscriber_data->subscriber_name;
                    $arr_data_users['email']                = $subscriber_data->subscriber_dtl_id."_".$subscriber_data->email;
                    $arr_data_users['mobile']               = $subscriber_data->mobile;
                    $arr_data_users['city']                 = $subscriber_data->city;
                    $arr_data_users['state']                = $subscriber_data->state;
                    $arr_data_users['subscriber_id']        = $subscriber_data->subscriber_id;
                    $arr_data_users['subscriber_dtl_id']    = $subscriber_data->subscriber_dtl_id;
                    $arr_data_users['nutritionist_id']      = $request->input('nutritionist_id');
                    $arr_data_users['roles']                = "subscriber";
                    $arr_data_users['password']             = "";            
                    $store_subscrbiber_users                = $this->base_users->create($arr_data_users);

                    if($store_subscrbiber_users){

                        $arr_dat = []; 
                        $arr_dat['user_id'] = $store_subscrbiber_users->id; 
                        $arr_dat['completed_at'] = 1; 
                        $arr_dat['completed'] = 1;   
                        $activations = \DB::table('activations')->insert($arr_dat);
                    }


                    //send notification 
                    $notitification_id = $request->input('nutritionist_id');
                    $nutritionist_dt   = \DB::table('users')->where('id','=',$request->input('nutritionist_id'))
                    ->first();
                    $subscriber_id     = $subscriber_data->subscriber_id;
                    $operation_details = \DB::table('users')->where('area','=',$nutritionist_dt->area)->where('roles','=',2)->first();

                    // notification send    
                    $notify_arr1['message']            = ucfirst($subscriber_data->subscriber_name).' subscriber has been assigned to you!';
                    $notify_arr1['users_role']         = 1 ; 
                    $notify_arr1['user_id']            = $nutritionist_dt->id; 
                    $assign_nutritionist_notification = $this->base_notification->create($notify_arr1);

                    // subscriber send    
                    $notify_arr2['message']            = 'Nurtidock assigned nutrtionist '.$nutritionist_dt->name.'  to subscriber '.$subscriber_data->subscriber_name;
                    $notify_arr2['users_role']         = "subscriber" ; 
                    $notify_arr2['user_id']            = $subscriber_id; 
                    $assign_subscriber_notification   = $this->base_notification->create($notify_arr2);

                    // operation send      
                    $notify_arr3['message']            = 'Nurtidock assigned nutrtionist '.$nutritionist_dt->name.'  to subscriber '.$subscriber_data->subscriber_name;
                    $notify_arr3['users_role']         = 2 ; 
                    $notify_arr3['user_id']            = $operation_details->id; 
                    $assign_operation_notification    = $this->base_notification->create($notify_arr3);
                    
                     
                } 
        }

        /*$data['message'] = "New Subscriber asssign";
        $this->pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);*/

      


        Session::flash('success', $this->Update );
        return \Redirect::to('admin/manage_assign_nutritionist');        
    }

    //Assign Nutritionist delete function
    public function delete($id)
    {
        $id = base64_decode($id);
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);
        //Assign user deactivate
     





        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
        /*$id= base64_decode($id);
          $this->base_model->where(['subcriber_assign_id'=>$id])->delete();
          Session::flash('success',$this->Delete);
          return \Redirect::back();*/
    } 

    //on off staus
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
        $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);
        //return \Redirect::back();
    }
   
   //get userlist wise city wise 

    public function get_user_list(Request $request)
    {
        $city       = $request->city;

        //assign nutrionist skip  
        $assign_users = $this->base_model->where('city_id','=',$city)->where('is_deleted','<>',1)->select('subscriber_id','nutritionist_id')->get()->toArray(); 
        
        $assign_subscriber_array = [];
        $assign_nutritionist_array = [];

        foreach ($assign_users as $key => $asvalue) {
           // $assign_subscriber_array[]   = $asvalue['subscriber_id'];
              $subscriber_id  = explode(",", $asvalue['subscriber_id']);
              foreach ($subscriber_id as $subvalue) {
                 $assign_subscriber_array[]   = $subvalue;
              }
               
          $assign_nutritionist_array[]   = $asvalue['nutritionist_id'];
        } 
      // dd($assign_subscriber_array);
        // end
        $users  = $this->base_users->where('roles','=',1)->where('is_active','=',1)->where('city','=',$city)->where('is_deleted','<>',1)->get();

        $subscriber =  \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->where('is_approve','=',1)->get();
        
        $data       = [];
        $nutritionist_html     = "<option>-Select Nutritionist-</option>";
        foreach($users as $key => $value) 
        {
           if(!in_array($value->id,$assign_nutritionist_array)){ 
           $nutritionist_html.="<option value=".$value->id.">".$value->name."</option>"; }    
        }

        $Subscriber_html = ""; 
        foreach($subscriber as $svalue)
        {
            if(!in_array($svalue->id,$assign_subscriber_array)){
            $Subscriber_html .=  "<tr>";
            $Subscriber_html .= "<td><input type='checkbox' name='subscriber_id[]' value='".$svalue->id."' required data-parsley-errors-container='#name_error' data-parsley-error-message='Please select at least one subscriber'></td>";
            $Subscriber_html .= "<td>".$svalue->subscriber_name."</td></tr>";} 
        }

        /*  $data['nutritionist'] = $nutritionist_html;
        $data['subscriber']   = $Subscriber_html;*/
        return  $nutritionist_html.','.$Subscriber_html;
    }

   //get users  detais 
   public function assign_users_details(Request $request)
   {
        $subcriber_assign_id = $request->subcriber_assign_id;  
        $data     = \DB::table('nutri_mst_subcriber_assign')
                     ->join('state','nutri_mst_subcriber_assign.state_id','=','state.id')
                     ->join('city','nutri_mst_subcriber_assign.city_id','=','city.id')
                     ->join('users','nutri_mst_subcriber_assign.nutritionist_id','=','users.id')
                     ->select('state.name as state_name','city.city_name','nutri_mst_subcriber_assign.*','users.name')
                     ->where('nutri_mst_subcriber_assign.is_deleted','<>',1)
                     ->where('nutri_mst_subcriber_assign.subcriber_assign_id','=',$subcriber_assign_id)
                     ->orderBy('nutri_mst_subcriber_assign.subcriber_assign_id', 'DESC')
                     ->first();
                    
        $subscriber_id    = explode(',',$data->subscriber_id);
        $html='<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><b>Nutritionist Name: </b>'.ucfirst($data->name).' </h4>
            <hr/>
            <div class="row">
              <div class="col-md-4"><h5 class="modal-title"><b>State Name: </b>'.ucfirst($data->state_name).'</h5></div>
              <div class="col-md-4"><h5 class="modal-title"><b>City Name: </b>'.ucfirst($data->city_name).'</h5></div>
             
            </div>
            
         
           
          </div>
          <div class="modal-body">
            <table class="table">
                <thead style="background-color: #ccb591;">
                   <tr>
                      <th>Sr.No</th>
                      <th>Subscriber Name</th>
                   </tr> 
                </thead>
                <tbody>';
                $i=1;
                foreach ($subscriber_id as $keys => $mvalue){
                    if($mvalue!=0){
                        $subscriber_data = \DB::table('nutri_dtl_subscriber')->where(['id'=>$mvalue])->select('subscriber_name')->first();
                        $html .="<tr>";
                    
                        $html .="<td>".$i."</td>";
                        $html .="<td>".$subscriber_data->subscriber_name."</td>";
                        $html .="<tr>";
                    }
                    $i++;
                }
        $html .='</tbody>
                        </table>';

        return $html;                    
   }


}
