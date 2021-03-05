<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\city;
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
    
    
    public function getSubscriberData(Request $request)
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
                        ->where('nutri_dtl_subscriber.is_deleted','<>',1); 

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
                $data=[];
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

                $get_tbl_data = \DB::table('nutri_dtl_subscriber')
                                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                                ->where('nutri_dtl_subscriber.is_deleted','<>',1); 


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

             

        }
        else {
            
               $search = $request->input('search.value'); 
               $get_tbl_data  = \DB::table('nutri_dtl_subscriber')
                ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                ->join('city','nutri_dtl_subscriber.city','=','city.id')
                ->join('state','nutri_dtl_subscriber.state','=','state.id')
                ->where('nutri_dtl_subscriber.is_deleted','<>',1);   

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


                if($value->payment_status == "Paid"){
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
                       
                      if($disabled==""){
                       $nestedData['action'] .='<a href="'.url('/admin').'/add_subscriber_meal_program/'.base64_encode($value->id).'"  class="btn btn-primary btn-sm"  title="'.$title.'">
                          <i class="glyphicon glyphicon-plus"></i>
                        </a>';
                       }else{
                        $nestedData['action'] .="<button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewMealProgramDetails(".$value->id.")' title='Subscriber meal program details' ><i class='glyphicon glyphicon-copy'></i></button>";
                       } 
                       
                    }
                    $nestedData['action'] .=' <a href="'.url('/admin').'/subscriber_pdf/'.$value->id.'" target="_blank" class="btn btn-danger btn-sm"  title="Subscriber Details" >
                        <i class="glyphicon glyphicon-open-file"></i>
                        </a>';
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

    public function verify_subscriber(Request $request)
    {

        $id                      = $request->id;
        $status                  = $request->status;
        $arr_data                = [];
        $arr_data['is_approve']  = $request->status;
        $module_update           =  \DB::table('nutri_dtl_subscriber')->where(['id'=>$id])->update($arr_data);
        return $request->status;
    }
}
