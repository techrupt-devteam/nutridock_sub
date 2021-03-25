<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\SubscriberDetails;
use App\Models\State;
use App\Models\city;
use App\Models\Location;
use App\Models\User;
use App\Models\Kitchen;
use App\Models\AssignNutritionist;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
class DashboardController extends Controller
{


    public function __construct(AssignNutritionist $AssignNutritionist,Location $Location,City $City,State $State,User $User,SubscriberDetails $SubscriberDetails,Kitchen $Kitchen)
    {
        $data                         = [];
        $this->base_model             = $AssignNutritionist; 
        $this->base_users             = $User; 
        $this->base_location          = $Location; 
        $this->base_city              = $City; 
        $this->base_state             = $State; 
        $this->base_kitchen           = $Kitchen; 
        $this->base_subscriber_dtl    = $SubscriberDetails; 
        $this->title                  = "Assign Nutritionist";
        $this->url_slug               = "assign_nutritionist";
        $this->folder_path            = "admin/assign_nutritionist/";
        //Message
        $this->Insert    = Config::get('constants.messages.Insert');
        $this->Update    = Config::get('constants.messages.Update');
        $this->Delete    = Config::get('constants.messages.Delete');
        $this->Error     = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');
    }

   // Dashboard
   public function dashbord(Request $request)
   {

        
        $data = [];
        $user = \Sentinel::check();
        $login_user_details      = Session::get('user');
        $city = Session::get('login_city_id');
        $where = "";
        if($login_user_details->roles!='1')
        {
            if($city!="all")
            {
                $nutritionist_count      = $this->base_users->where('roles','=',1)->where('city','=',$city);
                $opermanager_count       = $this->base_users->where('roles','=',2)->where('city','=',$city);
                $total_subscriber_count  = $this->base_subscriber_dtl->where('city','=',$city);
                $new_subscriber_count    = $this->base_subscriber_dtl->where('city','=',$city);
                $expire_subscriber_count = $this->base_subscriber_dtl->where('city','=',$city);
                            $kitchen     = \DB::table('nutri_mst_kitchen')
                                             ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                                             ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                                             ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                                             ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*')
                                             ->where('city','=',$city);

               // $subscribre_dtl          = \DB::table('nutri_dtl_subscriber')->where('city','=',$city);
            }
            else
            {
                $nutritionist_count     = $this->base_users->where('roles','=',1);
                $opermanager_count       = $this->base_users->where('roles','=',2);
                $total_subscriber_count  = $this->base_subscriber_dtl;
                $new_subscriber_count    = $this->base_subscriber_dtl;
                $expire_subscriber_count = $this->base_subscriber_dtl;
                            $kitchen     = \DB::table('nutri_mst_kitchen')
                                            ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                                            ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                                            ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                                            ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*');
               // $subscribre_dtl          = \DB::table('nutri_dtl_subscriber');
                             
                                             
            }

                

            //users count
            $nutritionist_count      =  $nutritionist_count->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
            $opermanager_count       =  $opermanager_count->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
            //subscriber count   
            $total_subscriber_count  = $total_subscriber_count->where('is_approve','=',1)->where('is_deleted','<>',1)->get()->count();
            $new_subscriber_count    = $new_subscriber_count->where('is_approve','=',1)->whereMonth('start_date','=',date('m'))->where('start_date','<=',date('Y-m-d'))->where('is_deleted','<>',1)->get()->count();
            $expire_subscriber_count = $expire_subscriber_count->where('is_approve','=',1)->whereMonth('expiry_date','=',date('m'))->where('expiry_date','<=',date('Y-m-d'))->where('is_deleted','<>',1)->get()->count();


            

            //nutridock kitechn all location 
            $kitchen        = $kitchen
                             ->where('nutri_mst_kitchen.is_deleted','<>',1)
                             ->orderBy('kitchen_id', 'DESC')
                             ->get();

            $sub_array = [];   
            $exp_array = [];   
            $month     = array(1,2,3,4,5,6,7,8,9,10,11,12);
            foreach ($month as $mvalue) {
               
               if($city!="all")
               {
                $start_month  = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('start_date','=',$mvalue)->where('expiry_date','>=',date('Y-m-d'))->count();
                    $sub_array[]  =  $start_month;
                    $expiry_month = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('expiry_date','=',$mvalue)->where('expiry_date','<=',date('Y-m-d'))->count();
                    /*$start_month  = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('start_date','=',$mvalue)->count();
                    $sub_array[]  =  $start_month;
                    $expiry_month = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('expiry_date','=',$mvalue)->count();*/
                    $exp_array[]  =  $expiry_month;
               }else
               {
                  /*$start_month  = \DB::table('nutri_dtl_subscriber')->whereMonth('start_date','=',$mvalue)->count();
                  $sub_array[]  =  $start_month;
                  $expiry_month = \DB::table('nutri_dtl_subscriber')->whereMonth('expiry_date','=',$mvalue)->count();*/
                  $start_month  = \DB::table('nutri_dtl_subscriber')->whereMonth('start_date','=',$mvalue)->where('expiry_date','>=',date('Y-m-d'))->count();
                    $sub_array[]  =  $start_month;
                    $expiry_month = \DB::table('nutri_dtl_subscriber')->whereMonth('expiry_date','=',$mvalue)->where('expiry_date','<=',date('Y-m-d'))->count();
                  $exp_array[]  =  $expiry_month;
               }
              
            }
                   $data['opermanager_count']       = $opermanager_count;
        $data['nutritionist_count']      = $nutritionist_count;
        
        }
        /*-----------------Nutritionist Dashboard Code-----------------*/
        if($login_user_details->roles == "1")
        {
            $assign_subscriber = Session::get('assign_subscriber'); 
            if(!empty($assign_subscriber))
            {

            $total_subscriber_count  = $this->base_subscriber_dtl->where('city','=',$city)
                                       ->whereIn('id',$assign_subscriber);
            $new_subscriber_count    = $this->base_subscriber_dtl->where('city','=',$city)
                                       ->whereIn('id',$assign_subscriber);
            $expire_subscriber_count = $this->base_subscriber_dtl->where('city','=',$city)
                                       ->whereIn('id',$assign_subscriber);
            $kitchen                 = \DB::table('nutri_mst_kitchen')
                                       ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                                       ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                                       ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                                       ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*')
                                       ->where('city','=',$city);

            //subscriber count   
            $total_subscriber_count  = $total_subscriber_count->where('is_approve','=',1)->where('is_deleted','<>',1)->get()->count();
            $new_subscriber_count    = $new_subscriber_count->where('is_approve','=',1)->whereMonth('start_date','=',date('m'))->where('start_date','<=',date('Y-m-d'))->where('is_deleted','<>',1)->get()->count();
            $expire_subscriber_count = $expire_subscriber_count->where('is_approve','=',1)->whereMonth('expiry_date','=',date('m'))->where('expiry_date','<=',date('Y-m-d'))->where('is_deleted','<>',1)->get()->count();

            //nutridock kitechn all location 
            $kitchen        = $kitchen
                             ->where('nutri_mst_kitchen.is_deleted','<>',1)
                             ->orderBy('kitchen_id', 'DESC')
                             ->get();

            $sub_array = [];   
            $exp_array = [];   
            $month     = array(1,2,3,4,5,6,7,8,9,10,11,12);
            foreach ($month as $mvalue) {
               
              
                    $start_month  = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('start_date','=',$mvalue)->where('expiry_date','>=',date('Y-m-d'))->whereIn('id',$assign_subscriber)->count();
                    $sub_array[]  =  $start_month;
                    $expiry_month = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('expiry_date','=',$mvalue)->where('expiry_date','<=',date('Y-m-d'))->whereIn('id',$assign_subscriber)->count();
                    $exp_array[]  =  $expiry_month;

            }
              $data['not_assign'] = false;
          }
          else
          {
              $data['not_assign'] = true;
              return view('admin/dashbord')->with(['data' => $data]);
          }

        }
            
        $data['sub_array']      = $sub_array;
        $data['exp_array']      = $exp_array;
        //dd($data);

        $data['kitchen']                 = $kitchen;

        $data['total_subscriber_count']  = $total_subscriber_count;
        $data['new_subscriber_count']    = $new_subscriber_count;
        $data['expire_subscriber_count'] = $expire_subscriber_count;
        return view('admin/dashbord')->with(['data' => $data]);
   }

   public function get_expiry_subcriber(Request $request)
    {
       // dd(session()->all());

        $login_city_id = Session::get('login_city_id'); 
        $assign_subscriber = Session::get('assign_subscriber'); 
        $user = \Sentinel::check();
        $login_user_details  = Session::get('user');
        $columns = array( 
                            0=>'Name',
                            1=> 'Email',
                            2=> 'Mobile',
                            3=> 'Expiry Date',
                            4=> 'Action',
                        );
        $data = \DB::table('nutri_dtl_subscriber')
                        ->join('nutri_mst_subscriber','nutri_dtl_subscriber.subscriber_id','=','nutri_mst_subscriber.id')
                        ->join('city','nutri_dtl_subscriber.city','=','city.id')
                        ->join('state','nutri_dtl_subscriber.state','=','state.id')
                        ->where('nutri_dtl_subscriber.is_deleted','<>',1) 
                        ->where('nutri_dtl_subscriber.expiry_date','>=',date('Y-m-d') ) 
                        ->where('nutri_dtl_subscriber.expiry_date', '<=',date('Y-m-d', strtotime(date('Y-m-d').' +2 day'))); 
   


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
                                ->where('nutri_dtl_subscriber.is_deleted','<>',1)
                                ->where('nutri_dtl_subscriber.expiry_date','>=',date('Y-m-d') ) 
                                ->where('nutri_dtl_subscriber.expiry_date', '<=',date('Y-m-d', strtotime(date('Y-m-d').' +2 day'))); 
   



                if($login_city_id != "all" && $login_user_details->roles=="admin"){    
                    $get_tbl_data   = $get_tbl_data->where('nutri_dtl_subscriber.city','=',$login_city_id)
                                       ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                       ->offset($start)
                                       ->limit($limit)
                                       ->orderBy($order,$dir)
                                       ->get(); 
                    //   dd("admin_All");                  
                } else if($login_user_details->roles=="admin"){

                    $get_tbl_data   =  $get_tbl_data->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                      ->offset($start)
                                      ->limit($limit)
                                      ->orderBy($order,$dir)
                                      ->get(); 
                }


                if(isset($assign_subscriber)  && $login_user_details->roles!="admin"){

                   $get_tbl_data    =   $get_tbl_data->whereIn('nutri_dtl_subscriber.id',$assign_subscriber) 
                                        ->where('nutri_dtl_subscriber.city','=',$login_city_id)  
                                        ->select('nutri_dtl_subscriber.*','city.city_name','state.name as state_name','nutri_mst_subscriber.email','nutri_mst_subscriber.mobile')
                                        ->offset($start)
                                        ->limit($limit)
                                        ->orderBy($order,$dir)
                                        ->get();    
                     
                }   
                elseif($login_user_details->roles!="admin")
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
                ->where('nutri_dtl_subscriber.expiry_date','>=',date('Y-m-d') ) 
                ->where('nutri_dtl_subscriber.expiry_date', '<=',date('Y-m-d', strtotime(date('Y-m-d').' +2 day'))); 
   

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
                $nestedData['name']         = $value->subscriber_name;
                /*$nestedData['email']        = $value->email;*/
                $nestedData['mobile']       = $value->mobile;
                $current_date               = date('Y-m-d');
                $expire_date                =  date('Y-m-d',strtotime($value->expiry_date));
                $nestedData['expire_date']  = date('d-m-Y',strtotime($value->expiry_date));
                $nestedData['action']        = "<button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewsubDetails(".$value->id.")' title='subscriber details'><i class='fa fa-info-circle'></i> subscriber details</button>";
                $data[] = $nestedData;
                $cnt++;

            }
        }


        //  dd($data);
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
