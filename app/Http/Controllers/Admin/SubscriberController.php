<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\City;
use App\Models\Plan;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
use PDF;
use Illuminate\Contracts\View\View;

class SubscriberController extends Controller
{
    public function __construct(State $State,City $City)
    {
        $data                = [];
        //$this->base_model    = $Subscription; 
        $this->base_State    = $State; 
        $this->base_city     = $City; 
        $this->title         = "Subscriber";
        $this->url_slug      = "subscriber";
        $this->folder_path   = "admin/subscriber/";
                //Message
        $this->Insert       = Config::get('constants.messages.Insert');
        $this->Update       = Config::get('constants.messages.Update');
        $this->Delete       = Config::get('constants.messages.Delete');
        $this->Error        = Config::get('constants.messages.Error');
        $this->Is_exists    = Config::get('constants.messages.Is_exists');
    }

    public function index()
    {
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }

    public function newindex()
    {
        $data['page_name'] = "New ";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title." List ".date('F Y', strtotime(date('Y-m-d')));
        return view($this->folder_path.'new_subscriber_index',$data);
    }

    public function expindex()
    {
        $data['page_name'] = "Expired";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title." List ".date('F Y', strtotime(date('Y-m-d')));
        return view($this->folder_path.'exp_subscriber_index',$data);
    }
    
    
    public function getSubscriberData(Request $request)
    {
       // dd(session()->all());

        $login_city_id = Session::get('login_city_id'); 
        $assign_subscriber = Session::get('assign_subscriber'); 
        //dd($assign_subscriber);
        $user = \Sentinel::check();
        $login_user_details  = Session::get('user');
        $columns = array( 
                            0 =>'id', 
                            1 =>'Name',
                            2=> 'Email',
                            3=> 'Mobile',
                            4=> 'Action',
                        );

             if(isset($assign_subscriber) && !empty($assign_subscriber) && $login_user_details->roles!="admin"){
                    $data = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                    ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                    ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                    ->where('nutri_dtl_subscriber.is_deleted','<>',1); 
            }else if($login_user_details->roles !=1){

                $data = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                    ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                    ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                    ->where('nutri_dtl_subscriber.is_deleted','<>',1); 
            }else{
                $data = "" ;
            }






            if($login_city_id != "all" && $login_user_details->roles=="admin" && $data!=""){
                $data     =  $data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                    ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                    ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                                    ->get();         
               // dd("admin_All");           
            }else if($login_user_details->roles=="admin" && $data!=""){
                $data     =  $data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();     

            }
            if(isset($assign_subscriber) && !empty($assign_subscriber) && $login_user_details->roles!="admin" && $data!=""){

                $data     =  $data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber)
                              ->where('nutri_dtl_subscriber.city','=',$login_city_id)
                              ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();   
      
            }else if($login_user_details->roles!="admin" && $data!="")
            {
                 $data     =  $data
                              ->where('nutri_dtl_subscriber.city','=',$login_city_id)
                              ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();
            }
        //dd($data);
        $totalData = count($data);
          if($totalData > 0){ 
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {   
                if(isset($assign_subscriber) && !empty($assign_subscriber) && $login_user_details->roles!="admin"){

                    $get_tbl_data = \DB::table('nutri_dtl_subscriber')
                                    ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                    ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                    ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                    ->where('nutri_dtl_subscriber.is_deleted','<>',1);  
                }else if($login_user_details->roles !=1){
                    $get_tbl_data = \DB::table('nutri_dtl_subscriber')
                    ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                    ->join('city','nutri_dtl_subscriber.city','=','city.id')
                    ->join('state','nutri_dtl_subscriber.state','=','state.id')
                    ->where('nutri_dtl_subscriber.is_deleted','<>',1); 
                }else
                {
                    $get_tbl_data = "" ;
                }





                if($login_city_id != "all" && $login_user_details->roles=="admin"  && $get_tbl_data !=""){    
                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                       ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                       ->offset($start)
                                       ->limit($limit)
                                       ->orderBy($order,$dir)
                                       ->get(); 
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin" && $get_tbl_data !=""){

                    $get_tbl_data  =  $get_tbl_data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                      ->offset($start)
                                      ->limit($limit)
                                      ->orderBy($order,$dir)
                                      ->get(); 
                }


                if(isset($assign_subscriber) && !empty($assign_subscriber) && $login_user_details->roles!="admin" && $get_tbl_data !=""){

                  $get_tbl_data     =   $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber) 
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                     
                }
                else if($login_user_details->roles!="admin" && $get_tbl_data !="")
                {
                  $get_tbl_data     =  $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                }  

             

        }
        else {
            
               $search = $request->input('search.value'); 

 if(isset($assign_subscriber) && !empty($assign_subscriber) && $login_user_details->roles!="admin"){
               $get_tbl_data  = \DB::table('nutri_dtl_subscriber')
                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                ->where('nutri_dtl_subscriber.is_deleted','<>',1); 
  }else if($login_user_details->roles !=1){
                 $get_tbl_data  = \DB::table('nutri_dtl_subscriber')
                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                ->where('nutri_dtl_subscriber.is_deleted','<>',1);   
            }else{
                    $get_tbl_data ="";
                }


               if($login_city_id != "all" && $login_user_details->roles=="admin" && $get_tbl_data!=""){    
                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                    ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                    ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin" && $get_tbl_data!=""){

                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                }


               if(isset($assign_subscriber) && !empty($assign_subscriber) && $login_user_details->roles!="admin" && $get_tbl_data!=""){

                  $get_tbl_data     =  $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber)
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id) 
                                        ->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();  
                     
                }
                else if($login_user_details->roles!="admin" && $get_tbl_data!="")
                {


                     $get_tbl_data     =  $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id) 
                                        ->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();  
                }
                

            /*$totalFiltered = value::where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                             ->count();*/
        }

        $data = array();
        if(!empty($get_tbl_data))
        {
            $cnt = 1;
            foreach ($get_tbl_data as $key => $value)
            {
                //$show =  route('values.show',$value->id);
                //$edit =  route('values.edit',$value->id);

                //$nestedData['id']       = $value->id;
                $nestedData['id']       = $cnt;
                $nestedData['name']     = $value->subscriber_name;
                $nestedData['email']    = $value->email;
                $nestedData['mobile']   = $value->mobile;
                $nestedData['city']     = $value->city_name;
               
                //$class_r ="";

                $current_date = date('Y-m-d');
                $expire_date  =  date('Y-m-d',strtotime($value->expiry_date));
                if( $current_date > $expire_date ){
                    $disabled = "disabled"; 
                    $class_r  = "expire_row"; 
                    $title    = 'Add meal Program';
                    $nestedData['start_date']   = date('d-m-Y',strtotime($value->start_date));
                    $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date)) ." <b style='color:red'>(Susbcription expire)</b>" ;

                }else
                {
                    $disabled = ""; 
                    $class_r  = 'noexp';
                    $title    = "Add meal Program";
                    $nestedData['start_date']   = date('d-m-Y',strtotime($value->start_date));
                    $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date))." <b style='color:green'>(Currently active)</b>";
                }


                if($value->payment_status == "captured"){
                    $payment_status  = '<b style="color:green">'.ucfirst($value->payment_status).'</b>';
                }else{
                    $payment_status  = '<b style="color:red">'.ucfirst($value->payment_status).'</b>';
                }


                $nestedData['status']  =  $payment_status;
                
                if($value->is_approve=='1'){
                     $status="Verified <i class='fa fa-check-circle'></i>"; $style="success"; 
                }else{
                    $status="Pending <i class='fa fa-times-circle'></i>"; $style="danger";}     

                   
                  $nestedData['action'] = "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails(".$value->id.")' title='subscriber details'><i class='fa fa-info-circle'></i></button>
                     <input type='hidden' id='status".$value->id."' value=".$value->is_approve.">";
                  if($login_user_details->roles!=1){
                       $nestedData['action'] .="<button type='button' value=".$value->id." id='btn-verify".$value->id."' class='btn btn-sm btn-".$style."' onclick='verified_subscriber(".$value->id.")'>".$status."</button>";

                    }

                     if($login_user_details->roles==1){
                       
                       $subscrition_plan_id = $value->sub_plan_id;
                       $duration_plan_id    = $value->duration_id;
                        $default_meal_added_or_not  = \DB::table('nutri_mst_default_meal')
                                                     ->where('sub_plan_id','=',$subscrition_plan_id)
                                                     ->where('duration_id','=',$duration_plan_id)
                                                     ->count();
  
        

                      if($disabled==""){

                       if($default_meal_added_or_not > 0){
                        $nestedData['action'] .='<a href="'.url('/admin').'/add_subscriber_meal_program/'.base64_encode($value->id).'"  class="btn btn-primary btn-sm"  title="'.$title.'">
                                <i class="glyphicon glyphicon-plus"></i>
                                </a>';
                       }else{ 
                            $nestedData['action'] .='<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="default_meal_not_found();">
                            <i class="glyphicon glyphicon-plus" ></i>
                            </a>';
                        }

                       }
                       else{
                        
                        $nestedData['action'] .="<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewMealProgramDetails(".$value->id.")' title='Subscriber meal program details' ><i class='glyphicon glyphicon-copy'></i></button>";
                       } 
                       
                    }
                    /*$nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Details" >
                        <i class="glyphicon glyphicon-open-file"></i>
                        </a>';*/
                    if($login_user_details->roles=="admin"){
                        $nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_bill_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Invoice" >
                        Bill <i class="glyphicon glyphicon-open-file"></i>
                        </a>';
                    }    
                $nestedData['class_r'] = $class_r;
                $data[] = $nestedData;
               // dd($data);
                $cnt++;

            }
        }


          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        }
        else{
           $json_data = array(
                    "draw"            => 0,  
                    "recordsTotal"    => 0,  
                    "recordsFiltered" => 0, 
                    "data"            => 0   
                    );   
        }    
        echo json_encode($json_data); 
        
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
        $physical_activity=$address1=$address2=$pincode1=$pincode2=$food_precautions = $lifestyle_disease = $other_food ="NA";
        if(!empty($value->other_food))
        {
            $other_food = $value->other_food;
        }

        if(!empty($value->lifestyle_disease))
        {
            $lifestyle_disease = $value->lifestyle_disease;
        }

        if(!empty($value->food_precautions))
        {
            $food_precautions = $value->food_precautions;
        }

        if(!empty($value->address1))
        {
            $address1 = $value->address1;
        }

        if(!empty($value->pincode1))
        {
            $pincode1 = $value->pincode1;
        }

        if(!empty($value->address2))
        {
            $address2 = $value->address2;
        }

        if(!empty($value->pincode2))
        {
            $pincode2 = $value->pincode2;
        }
        if(!empty($value->physical_activity))
        {
            $physical_activity = $value->physical_activity;
        }


        /*$html='<div class="modal-header" >
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
                      <div class="col-md-4">
                         <h5 class="modal-title"><b>Payment Status: </b>'.$value->payment_status.'</h5><br/>
                         <h5 class="modal-title"><b>Transaction ID: </b>'.$value->transaction_id.'</h5><br/>
                         <h5 class="modal-title"><b>Payment Amount: </b>'.$value->total_amount.'</h5><br/>
                      </div>
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
                      <div class="col-md-4"><h5 class="modal-title"><b>Physical Activity: </b> </h5><br/><p> '.$physical_activity.'</p></div>
                      <div class="col-md-4"><h5 class="modal-title"><b>Avoid / Dislike Food: </b> </h5></br><p>';
                      if(count($get_food_avoid)>0){
                          foreach ($get_food_avoid as $advalue) {
                            $html .="<span class='btn-sm btn-danger'>".$advalue->food_avoid_name."</span>&nbsp;&nbsp;";  
                          }
                      }
                      else
                      {
                        $html.="NA";
                      }
                       
                       $html  .='</p>
                      </div>
                   </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-6"><h5 class="modal-title"><b>Other Food: </b></h5><br/><p>'.$other_food.'</p></div>
                   </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-12"><h5 class="modal-title"><b>Any lifestyle disease:</b></h5><br/><p>'.$lifestyle_disease.'</p></div>
                   </div>
                </div> <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                      <div class="col-md-12"><h5 class="modal-title"><b>Any food preparation instructions:</b></h5><br/><p>'.$food_precautions.'</p></div>
                   </div>
                </div>
                 <hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row">
                  <div class="col-md-12">
                    <div class="col-md-4"><h5 class="modal-title"><b>Address: </b></h5><br/><p>'.$address1.'</p> </div>
                    <div class="col-md-4"><h5 class="modal-title"><b>Pincode: </b></h5><br/><p>'.$pincode1.'</p> </div>
                    <div class="col-md-4"><h5 class="modal-title"><b>Meal Type: </b></h5><br/><p>';
                    $get_meal_type2 = \DB::table('meal_type')
                                     ->whereIn('meal_type_id',explode(",",$value->address1_deliver_mealtype))
                                     ->select('meal_type_name')
                                     ->get();
                     if(count($get_meal_type2)>0){
                        foreach ($get_meal_type2 as $m2value) {
                          $html .="<span class='btn-sm btn-warning'>".$m2value->meal_type_name."</span>&nbsp;&nbsp;";  
                        }
                     }else{
                        $html .="NA";
                     }                  
                    $html .='</p> </div>
                  </div>  
                </div><hr/ style="border-top: 1px solid #9e9e9e;">
                <div class="row"> 
                    <div class="col-md-12">
                        <div class="col-md-4"><h5 class="modal-title"><b>Address: </b></h5><br/><p>'.$address2.'</p></div>
                        <div class="col-md-4"><h5 class="modal-title"><b>Pincode: </b></h5><br/><p>'.$pincode2.'</p></div>
                        <div class="col-md-4"><h5 class="modal-title"><b>Meal Type: </b></h5><br/><p>';
                        $get_meal_type3 = \DB::table('meal_type')
                                         ->whereIn('meal_type_id',explode(",",$value->address2_deliver_mealtype))
                                         ->select('meal_type_name')
                                         ->get();

                      if(count($get_meal_type3)>0)
                      { 
                        foreach ($get_meal_type3 as $m3value) {
                             $html .="<span class='btn-sm btn-warning'>".$m3value->meal_type_name."</span>&nbsp;&nbsp;";  
                        } 
                      }else{
                        $html .="NA";
                      }

                        $html .='</p></div>
                    </div>
                </div>
              ';
       

        $html.='</div>
                <div class="modal-footer">
           
           
                </div>';
              return $html;*/
               $html='<div class="modal-header" style="font-size:14px;">
        <!---<div class="col-md-12">
            <h3 class="text-center d-none d-md-block">Subscription Details</h3></div>
          <button type="button" style="right: 20px;" class="close position-absolute" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
        </div>--->
        <div class="modal-body details" style="margin: 21px;">
           <div class="row " style="border-top: 2px solid #2d2c2c">
                <br/>
           <div class="heading pt20 pb-2"><i class="fa fa-user"></i><strong> BASIC DETAILS </strong></div>
          <div class="row content">
            <div class="col-md-5">
              <h4 style="color: #64BB2C;">'.$value->subscriber_name.'</h4>
              <div>
                <table class="table table-sm" style="font-size: 14px;">
                  <tr>
                    <td style="border-top: 1px dashed #292828;"><i class="fa fa-phone" aria-hidden="true"></i> &nbsp;<span>'.$value->mobile.'</span></td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px dashed #292828;"> <i class="fa fa-envelope" aria-hidden="true"></i> &nbsp;<span>'.$value->email.'</span></td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px dashed #292828;"><i class="fa fa-child" aria-hidden="true"></i>&nbsp; <span>'.$value->subscriber_age.' <small>Yrs Old</small> </span></td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px dashed #292828;"><b>Transaction ID: </b>&nbsp; <span>'.$value->transaction_id.'  </span></td>
                  </tr>
                  <tr>
                    <td style="border-top: 1px dashed #292828;"><b>Payment Status: </b>&nbsp; <span style="text-transform: capitalize;">'.$value->payment_status.'  </span></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-md-7">
            <br/>
              <table class="table table-bordered" style="font-size: 14px;">
                <tr>
                  <th style="background-color:#e9ecef"><span>Plan </span></th>
                  <td><span>'.$value->sub_name.'</span></td>
                </tr>
                <tr>
                  <th style="background-color:#e9ecef"><span>Duration</span></th>
                  <td style="border-top: 1px dashed #292828;">
                    <div><small><b>FROM:</b> </small>'.date('d-M-Y',strtotime($value->start_date)).' <small></div><div ><b>TO:</b></small> '.date('d-M-Y',strtotime($value->expiry_date)).'</div>
                    <div> <small>('.$value->no_of_days.' Days)</small></div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <th style="background-color:#e9ecef"><span>Meal Type</span></th>
                  <td style="border-top: 1px dashed #292828;">'; foreach ($get_meal_type as $mvalue) { $html .="<span class='btn-sm btn-warning'>".$mvalue->meal_type_name."</span>&nbsp;&nbsp;"; } $html .='</td>
                </tr>
              </table>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12" style="border-top: 2px solid #2d2c2c"><br/>
              <span class="heading"><i class="fa fa-heartbeat" aria-hidden="true"></i><strong> HEALTH DETAILS</strong></span>
              <div class="row content">
                <table class="table table-sm" style="font-size:14px;">
                  <tbody>
                    <tr>
                      <td style="border-top: 1px dashed #292828;" width="30%">Weight:</td>
                      <td style="border-top: 1px dashed #292828;">'.$value->subscriber_weight.'</td>
                      <td style="border-top: 1px dashed #292828;">Height:</td>
                      <td style="border-top: 1px dashed #292828;">'.$value->subscriber_height_in_feet." <i>Feets </i>".$value->subscriber_height_in_inches.' <i>Inches</i></td>
                    </tr>
                    <tr>
                      <td colspan="2" style="border-top: 1px dashed #292828;">Avoid / Dislike Food:</td>
                      <td colspan="2" style="border-top: 1px dashed #292828;">
                        <p>'; foreach ($get_food_avoid as $advalue) { $html .="<span class='btn-sm btn-danger'>".$advalue->food_avoid_name."</span>&nbsp;&nbsp;"; } $html .='</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" width="40%" style="border-top: 1px dashed #292828;">Other Food:</td>
                      <td colspan="2" style="border-top: 1px dashed #292828;">'.$value->other_food.'</td>
                    </tr>
                    <tr>
                      <td colspan="2" style="border-top: 1px dashed #292828;">Any lifestyle disease:</td>
                      <td colspan="2" style="border-top: 1px dashed #292828;">'.$value->lifestyle_disease.'</td>
                    </tr>
                    <tr class="pb-2">
                      <td colspan="2" style="border-top: 1px dashed #292828;">Any food preparation instructions:</td>
                      <td colspan="2" style="border-top: 1px dashed #292828;">'.$value->food_precautions.'</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="row " style="border-top: 2px solid #2d2c2c">
                <br/>
                <div class="heading pt20 pb-2"><i class="fa fa-home"></i><strong> ADDRESSES FOR MEAL DELIVERY </strong></div><br/>
                <div class="card-view">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="content p-2" style="border: 1px dashed #2d2c2c; background-color: #e9ecef; font-size: 14px;">
                        <div class="description   pb-3 pl-3 pr-3"  style="border-bottom: 1px solid #2d2c2c;"><h5 class="modal-title"><small><b>Delivery Address 1</b> </small></h5> '.$address1.'<div class="contact"> '.$value->pincode1.' </div></div>
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
                        <div class="description pb-3 pl-3 pr-3" style="border-bottom: 1px solid #2d2c2c;"> <h5 class="modal-title"><small><b>Delivery Address 2</b> </small></h5>'.$address2.'
                          <div class="contact"> '.$value->pincode2.' </div>
                        </div>
                          <div class="col-md-12">
                            <h5 class="modal-title"><small><b>Deliver Meal on above address</b> </small></h5><br/>
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

   
    public function subscriber_pdf(Request $request,$id)
    {
        $id = $id;
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
                                  //  dd($get_subscriber_details);
        //getmeal type 
        $get_meal_type = \DB::table('meal_type')
                          ->whereIn('meal_type_id',explode(",",$get_subscriber_details->meal_type_id))
                          ->select('meal_type_name')
                          ->get();
        $get_food_avoid = \DB::table('food_avoid')
                          ->whereIn('food_avoid_id',explode(",",$get_subscriber_details->avoid_or_dislike_food_id))
                          ->select('food_avoid_name')
                          ->get();
                                    
        $get_meal_type2 = \DB::table('meal_type')
                            ->whereIn('meal_type_id',explode(",",$get_subscriber_details->address1_deliver_mealtype))
                            ->select('meal_type_name')
                                     ->get();  


        $get_meal_type3 = \DB::table('meal_type')
                                         ->whereIn('meal_type_id',explode(",",$get_subscriber_details->address2_deliver_mealtype))
                                         ->select('meal_type_name')
                                         ->get();
        
         
           $data =[] ;
           $data['get_subscriber_details'] = $get_subscriber_details;
           $data['get_meal_type'] = $get_meal_type;
           $data['get_food_avoid'] = $get_food_avoid;
           $data['get_meal_type2'] = $get_meal_type2;
           $data['get_meal_type3'] = $get_meal_type3;

            if(!is_dir('uploads/pdf/sub_'.$id)) {
               mkdir('uploads/pdf/sub_'.$id);
            }

            

            $pdf = PDF::loadView('admin/subscriber/detailspdf',  ['data' => $data]);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            //// $pdf->save('uploads/pdf/sub_'.$id.'/sub_'.$id.'details.pdf');
            $pdf->stream('sub_'.$id.'details.pdf');
     
           
        
         
    }
    public function subscriber_bill_pdf(Request $request,$id)
    {
        $id = $id;
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
                                  //  dd($get_subscriber_details);
        //getmeal type 
        $get_meal_type = \DB::table('meal_type')
                          ->whereIn('meal_type_id',explode(",",$get_subscriber_details->meal_type_id))
                          ->select('meal_type_name')
                          ->get();
        $get_food_avoid = \DB::table('food_avoid')
                          ->whereIn('food_avoid_id',explode(",",$get_subscriber_details->avoid_or_dislike_food_id))
                          ->select('food_avoid_name')
                          ->get();
                                    
        $get_meal_type2 = \DB::table('meal_type')
                            ->whereIn('meal_type_id',explode(",",$get_subscriber_details->address1_deliver_mealtype))
                            ->select('meal_type_name')
                                     ->get();  


        $get_meal_type3 = \DB::table('meal_type')
                                         ->whereIn('meal_type_id',explode(",",$get_subscriber_details->address2_deliver_mealtype))
                                         ->select('meal_type_name')
                                         ->get();
        
         
           $data =[] ;
           $data['get_subscriber_details'] = $get_subscriber_details;
           $data['get_meal_type']  = $get_meal_type;
           $data['get_food_avoid'] = $get_food_avoid;
           $data['get_meal_type2'] = $get_meal_type2;
           $data['get_meal_type3'] = $get_meal_type3;
           $data['inword']         = $this->number_to_words(round($get_subscriber_details->total_amount));  


            if(!is_dir('uploads/pdf/sub_bill'.$id)) {
               mkdir('uploads/pdf/sub_bill'.$id);
            }
             
          

            $pdf = PDF::loadView('admin/subscriber/billpdf',['data' => $data]);
            $pdf->SetProtection(['copy', 'print'], '', 'pass');
            $pdf->stream('sub_'.$id.'billpdf.pdf');
     
         
    }

    public function number_to_words($num)
    {
            $number   = $num;
            $no       = floor($number);
            $point    = round($number - $no, 2) * 100;
            $hundred  = null;
            $digits_1 = strlen($no);
            
            $i = 0;
            
            $str = array();

            $words = array('0' => '', '1' => 'one', '2' => 'two',
            '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
            '7' => 'seven', '8' => 'eight', '9' => 'nine',
            '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
            '13' => 'thirteen', '14' => 'fourteen',
            '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
            '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
            '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
            '60' => 'sixty', '70' => 'seventy',
            '80' => 'eighty', '90' => 'ninety');
            
            $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
            
            while ($i < $digits_1) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += ($divider == 10) ? 1 : 2;
            if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
            } else $str[] = null;
            }
            $str = array_reverse($str);
            $result = implode('', $str);
            $points = ($point) ?
            "." . $words[$point / 10] . " " . 
            $words[$point = $point % 10] : '';
            // return $result . "Rupees ". $points ." Paise";
            return $result . "Rupees ";
    }

    public function verify_subscriber(Request $request)
    {

        $id                      = $request->id;
        $status                  = $request->status;
        $arr_data                = [];
        $arr_data['is_approve']  = $request->status;
        $module_update           =  \DB::table('nutri_dtl_subscriber')->where(['id'=>$id])->update($arr_data);
        return $request->status;
    }



    //month new wise subscriber
    public function getNewSubscriberData(Request $request)
    {
       // dd(session()->all());

        $login_city_id = Session::get('login_city_id'); 
        $assign_subscriber = Session::get('assign_subscriber'); 
        $user = \Sentinel::check();
        $login_user_details  = Session::get('user');
        $columns = array( 
                            0 =>'id', 
                            1 =>'Name',
                            2=> 'Email',
                            3=> 'Mobile',
                            4=> 'Action',
                        );
        $data = \DB::table('nutri_dtl_subscriber')
                        ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                        ->join('city','nutri_dtl_subscriber.city','=','city.id')
                        ->join('state','nutri_dtl_subscriber.state','=','state.id')
                        ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                        ->whereMonth('nutri_dtl_subscriber.start_date','=',date('m')); 


            if($login_city_id != "all" && $login_user_details->roles=="admin"){
                $data     =  $data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                    ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                    ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                                    ->get();         
               // dd("admin_All");           
            }else if($login_user_details->roles=="admin"){
                $data     =  $data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();     

            }
            if(isset($assign_subscriber) && $login_user_details->roles!="admin"){
                $data     =  $data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber)
                              ->where('nutri_dtl_subscriber.city','=',$login_city_id)
                              ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();   
      
            }
            else if($login_user_details->roles!="admin")
            {
                 $data     =  $data
                              ->where('nutri_dtl_subscriber.city','=',$login_city_id)
                              ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();
            }
            /*else if($login_user_details->roles!="admin")
            {
                $data=[];
            }*/
        //dd($data);
        $totalData = count($data);
          if($totalData > 0){ 
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {   

                $get_tbl_data = \DB::table('nutri_dtl_subscriber')
                                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                                ->whereMonth('nutri_dtl_subscriber.start_date','=',date('m'));

                if($login_city_id != "all" && $login_user_details->roles=="admin"){    
                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                       ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                       ->offset($start)
                                       ->limit($limit)
                                       ->orderBy($order,$dir)
                                       ->get(); 
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin"){

                    $get_tbl_data  =  $get_tbl_data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                      ->offset($start)
                                      ->limit($limit)
                                      ->orderBy($order,$dir)
                                      ->get(); 
                }


                if(isset($assign_subscriber)  && $login_user_details->roles!="admin"){

                  $get_tbl_data     =   $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber) 
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                     
                }else if($login_user_details->roles!="admin")
                {
                  $get_tbl_data     =  $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                }     

        }
        else {
            
               $search = $request->input('search.value'); 
               $get_tbl_data  = \DB::table('nutri_dtl_subscriber')
                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                ->where('nutri_dtl_subscriber.is_deleted','<>',1) 
                ->whereMonth('nutri_dtl_subscriber.start_date','=',date('m'));
               if($login_city_id != "all" && $login_user_details->roles=="admin"){    
                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                    ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                    ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin"){

                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                }


               if(isset($assign_subscriber) && $login_user_details->roles!="admin"){

                  $get_tbl_data     =  $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber)
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id) 
                                        ->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();  
                     
                }  else if($login_user_details->roles!="admin")
                {
                     $get_tbl_data     =  $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id) 
                                        ->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();  
                }   

                

            /*$totalFiltered = value::where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                             ->count();*/
        }

        $data = array();
        if(!empty($get_tbl_data))
        {
            $cnt = 1;
            foreach ($get_tbl_data as $key => $value)
            {
                //$show =  route('values.show',$value->id);
                //$edit =  route('values.edit',$value->id);

                //$nestedData['id']       = $value->id;
                $nestedData['id']       = $cnt;
                $nestedData['name']     = $value->subscriber_name;
                $nestedData['email']    = $value->email;
                $nestedData['mobile']   = $value->mobile;
                $nestedData['city']     = $value->city_name;
               
                //$class_r ="";

                $current_date = date('Y-m-d');
                $expire_date  =  date('Y-m-d',strtotime($value->expiry_date));
                if( $current_date > $expire_date ){
                    $disabled = "disabled"; 
                    $class_r  = "expire_row"; 
                    $title    = 'Add meal Program';
                    $nestedData['start_date']   = date('d-m-Y',strtotime($value->start_date));
                    $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date)) ." <b style='color:red'>(Susbcription expire)</b>" ;

                }else
                {
                    $disabled = ""; 
                    $class_r  = 'noexp';
                    $title    = "Add meal Program";
                    $nestedData['start_date']   = date('d-m-Y',strtotime($value->start_date));
                    $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date))." <b style='color:green'>(Currently active)</b>";
                }


                if($value->payment_status == "captured"){
                    $payment_status  = '<b style="color:green">'.ucfirst($value->payment_status).'</b>';
                }else{
                    $payment_status  = '<b style="color:red">'.ucfirst($value->payment_status).'</b>';
                }


                $nestedData['status']  =  $payment_status;
                
                if($value->is_approve=='1'){
                     $status="Verified <i class='fa fa-check-circle'></i>"; $style="success"; 
                }else{
                    $status="Pending <i class='fa fa-times-circle'></i>"; $style="danger";}     

                   
                  $nestedData['action'] = "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails(".$value->id.")' title='subscriber details'><i class='fa fa-info-circle'></i></button>
                     <input type='hidden' id='status".$value->id."' value=".$value->is_approve.">";
                  if($login_user_details->roles!=1){
                       $nestedData['action'] .="<button type='button' value=".$value->id." id='btn-verify".$value->id."' class='btn btn-sm btn-".$style."' onclick='verified_subscriber(".$value->id.")'>".$status."</button>";

                    }

                     if($login_user_details->roles==1){
                       
                       $subscrition_plan_id = $value->sub_plan_id;
                       $duration_plan_id    = $value->duration_id;
                        $default_meal_added_or_not  = \DB::table('nutri_mst_default_meal')
                                                     ->where('sub_plan_id','=',$subscrition_plan_id)
                                                     ->where('duration_id','=',$duration_plan_id)
                                                     ->count();
  
        

                      if($disabled==""){
                       if($default_meal_added_or_not > 0){
                        $nestedData['action'] .='<a href="'.url('/admin').'/add_subscriber_meal_program/'.base64_encode($value->id).'"  class="btn btn-primary btn-sm"  title="'.$title.'">
                                <i class="glyphicon glyphicon-plus"></i>
                                </a>';
                       }else{ 
                            $nestedData['action'] .='<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="default_meal_not_found();">
                            <i class="glyphicon glyphicon-plus" ></i>
                            </a>';
                        }

                       }else{
                        $nestedData['action'] .="<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewMealProgramDetails(".$value->id.")' title='Subscriber meal program details' ><i class='glyphicon glyphicon-copy'></i></button>";
                       } 
                       
                    }
                    $nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Details" >
                        <i class="glyphicon glyphicon-open-file"></i>
                        </a>';
                    if($login_user_details->roles=="admin"){
                        $nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_bill_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Invoice" >
                        Bill <i class="glyphicon glyphicon-open-file"></i>
                        </a>';
                    }    
                $nestedData['class_r'] = $class_r;
                $data[] = $nestedData;
               // dd($data);
                $cnt++;

            }
        }


          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        }
        else{
           $json_data = array(
                    "draw"            => 0,  
                    "recordsTotal"    => 0,  
                    "recordsFiltered" => 0, 
                    "data"            => 0   
                    );   
        }    
        echo json_encode($json_data); 
        
    } 

    //expire subscriber list
     public function getExpireSubscriberData(Request $request)
    {
       // dd(session()->all());

        $login_city_id = Session::get('login_city_id'); 

        $assign_subscriber = Session::get('assign_subscriber'); 
        $user = \Sentinel::check();
        $login_user_details  = Session::get('user');
        $columns = array( 
                            0 =>'id', 
                            1 =>'Name',
                            2=> 'Email',
                            3=> 'Mobile',
                            4=> 'Action',
                        );
        $data = \DB::table('nutri_dtl_subscriber')
                        ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                        ->join('city','nutri_dtl_subscriber.city','=','city.id')
                        ->join('state','nutri_dtl_subscriber.state','=','state.id')
                        ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                        ->whereMonth('nutri_dtl_subscriber.expiry_date','=',date('m'))
                        ->where('nutri_dtl_subscriber.expiry_date','<=',date('Y-m-d'));

            if($login_city_id != "all" && $login_user_details->roles=="admin"){

                $data     =  $data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                    ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                    ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                                    ->get();         
               // dd("admin_All");           
            }else if($login_user_details->roles=="admin"){
                $data     =  $data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();     

            }
            if(isset($assign_subscriber) && $login_user_details->roles!="admin"){
                $data     =  $data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber)
                              ->where('nutri_dtl_subscriber.city','=',$login_city_id)
                              ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();   
      
            }else if($login_user_details->roles!="admin")
            {
                 $data     =  $data
                              ->where('nutri_dtl_subscriber.city','=',$login_city_id)
                              ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                              ->orderBy('nutri_dtl_subscriber.sub_plan_id', 'DESC')
                              ->get();
            }/*else if($login_user_details->roles!="admin")
            {
                $data=[];
            }*/
        //dd($data);
        $totalData = count($data);
          if($totalData > 0){ 
        $totalFiltered = $totalData; 
        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        if(empty($request->input('search.value')))
        {   

                $get_tbl_data = \DB::table('nutri_dtl_subscriber')
                                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                                ->whereMonth('nutri_dtl_subscriber.expiry_date','=',date('m'))
                                ->where('nutri_dtl_subscriber.expiry_date','<=',date('Y-m-d'));

                if($login_city_id != "all" && $login_user_details->roles=="admin"){  
                
                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                       ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                       ->offset($start)
                                       ->limit($limit)
                                       ->orderBy($order,$dir)
                                       ->get(); 
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin"){

                    $get_tbl_data  =  $get_tbl_data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                      ->offset($start)
                                      ->limit($limit)
                                      ->orderBy($order,$dir)
                                      ->get(); 
                }


                if(isset($assign_subscriber)  && $login_user_details->roles!="admin"){

                  $get_tbl_data     =   $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber) 
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                     
                } 
                else if($login_user_details->roles!="admin")
                {
                  $get_tbl_data     =  $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                }    

             

        }
        else {
            
               $search = $request->input('search.value'); 
               $get_tbl_data  = \DB::table('nutri_dtl_subscriber')
                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                ->where('nutri_dtl_subscriber.is_deleted','<>',1) 
                ->whereMonth('nutri_dtl_subscriber.expiry_date','=',date('m'))
                ->where('nutri_dtl_subscriber.expiry_date','<=',date('Y-m-d'));
               if($login_city_id != "all" && $login_user_details->roles=="admin"){  

                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                    ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                    ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                    ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                    ->offset($start)
                                    ->limit($limit)
                                    ->orderBy($order,$dir)
                                    ->get();
                                    
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin"){
                    

                    $get_tbl_data  = $get_tbl_data->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();
                }


               if(isset($assign_subscriber) && $login_user_details->roles!="admin"){

                  $get_tbl_data     =  $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber)
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id) 
                                        ->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();  
                     
                }else if($login_user_details->roles!="admin")
                {
                     $get_tbl_data     =  $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id) 
                                        ->where('nutri_dtl_subscriber.id','LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.subscriber_name', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.email', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_mst_subscriber.mobile', 'LIKE',"%{$search}%")
                                        ->orWhere('nutri_dtl_subscriber.payment_status', 'LIKE',"%{$search}%")
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();  
                }    

            /*$totalFiltered = value::where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                             ->count();*/
        }

        $data = array();
        if(!empty($get_tbl_data))
        {
            $cnt = 1;
            foreach ($get_tbl_data as $key => $value)
            {
                //$show =  route('values.show',$value->id);
                //$edit =  route('values.edit',$value->id);

                //$nestedData['id']       = $value->id;
                $nestedData['id']       = $cnt;
                $nestedData['name']     = $value->subscriber_name;
                $nestedData['email']    = $value->email;
                $nestedData['mobile']   = $value->mobile;
                $nestedData['city']     = $value->city_name;
               
                //$class_r ="";

                $current_date = date('Y-m-d');
                $expire_date  =  date('Y-m-d',strtotime($value->expiry_date));
                if( $current_date > $expire_date ){
                    $disabled = "disabled"; 
                    $class_r  = "expire_row"; 
                    $title    = 'Add meal Program';
                    $nestedData['start_date']   = date('d-m-Y',strtotime($value->start_date));
                    $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date)) ." <b style='color:red'>(Susbcription expire)</b>" ;

                }else
                {
                    $disabled = ""; 
                    $class_r  = 'expire_row';
                    $title    = "Add meal Program";
                    $nestedData['start_date']   = date('d-m-Y',strtotime($value->start_date));
                    $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date))." <b style='color:green'>(Currently active)</b>";
                }


                if($value->payment_status == "captured"){
                    $payment_status  = '<b style="color:green">'.ucfirst($value->payment_status).'</b>';
                }else{
                    $payment_status  = '<b style="color:red">'.ucfirst($value->payment_status).'</b>';
                }


                $nestedData['status']  =  $payment_status;
                
                if($value->is_approve=='1'){
                     $status="Verified <i class='fa fa-check-circle'></i>"; $style="success"; 
                }else{
                    $status="Pending <i class='fa fa-times-circle'></i>"; $style="danger";}     

                   
                  $nestedData['action'] = "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails(".$value->id.")' title='subscriber details'><i class='fa fa-info-circle'></i></button>
                     <input type='hidden' id='status".$value->id."' value=".$value->is_approve.">";
                  if($login_user_details->roles!=1){
                       $nestedData['action'] .="<button type='button' value=".$value->id." id='btn-verify".$value->id."' class='btn btn-sm btn-".$style."' onclick='verified_subscriber(".$value->id.")'>".$status."</button>";

                    }

                     if($login_user_details->roles==1){
                       
                       $subscrition_plan_id = $value->sub_plan_id;
                       $duration_plan_id    = $value->duration_id;
                        $default_meal_added_or_not  = \DB::table('nutri_mst_default_meal')
                                                     ->where('sub_plan_id','=',$subscrition_plan_id)
                                                     ->where('duration_id','=',$duration_plan_id)
                                                     ->count();
  
        

                      if($disabled==""){
                       if($default_meal_added_or_not > 0){
                        $nestedData['action'] .='<a href="'.url('/admin').'/add_subscriber_meal_program/'.base64_encode($value->id).'"  class="btn btn-primary btn-sm"  title="'.$title.'">
                                <i class="glyphicon glyphicon-plus"></i>
                                </a>';
                       }else{ 
                            $nestedData['action'] .='<a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="default_meal_not_found();">
                            <i class="glyphicon glyphicon-plus" ></i>
                            </a>';
                        }

                       }else{
                        $nestedData['action'] .="<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewMealProgramDetails(".$value->id.")' title='Subscriber meal program details' ><i class='glyphicon glyphicon-copy'></i></button>";
                       } 
                       
                    }
                    $nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Details" >
                        <i class="glyphicon glyphicon-open-file"></i>
                        </a>';
                    if($login_user_details->roles=="admin"){
                        $nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_bill_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Invoice" >
                        Bill <i class="glyphicon glyphicon-open-file"></i>
                        </a>';
                    }    
                $nestedData['class_r'] = $class_r;
                $data[] = $nestedData;
               // dd($data);
                $cnt++;

            }
        }

 
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
        }
        else{
           $json_data = array(
                    "draw"            => 0,  
                    "recordsTotal"    => 0,  
                    "recordsFiltered" => 0, 
                    "data"            => 0   
                    );   
        }    
        echo json_encode($json_data); 
        
    }

}
