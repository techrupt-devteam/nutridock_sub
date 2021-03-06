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

        //users count
        $nutritionist_count     = $this->base_users->where('roles','=',1)->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
        $opermanager_count       = $this->base_users->where('roles','=',2)->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
        //subscriber count   
        $total_subscriber_count  = $this->base_subscriber_dtl->where('is_approve','=',1)->where('is_deleted','<>',1)->get()->count();
        $new_subscriber_count    = $this->base_subscriber_dtl->where('is_approve','=',1)->where('start_date','=',date('Y-m-d'))->where('is_deleted','<>',1)->get()->count();
        $expire_subscriber_count = $this->base_subscriber_dtl->where('is_approve','=',1)->where('expiry_date','<=',date('Y-m-d'))->where('is_deleted','<>',1)->get()->count();

        //nutridock kitechn all location 
        $kitchen     = \DB::table('nutri_mst_kitchen')
                         ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                         ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                         ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                         ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*')
                         ->where('nutri_mst_kitchen.is_deleted','<>',1)
                         ->orderBy('kitchen_id', 'DESC')
                         ->get();

        $sub_array = [];   
        $exp_array = [];   
        $month     = array(1,2,3,4,5,6,7,8,9,10,11,12);
        foreach ($month as $mvalue) {
           $start_month  = \DB::table('nutri_dtl_subscriber')->whereMonth('start_date','=',$mvalue)->count();
           $sub_array[]  = $start_month;
           $expiry_month 
           = \DB::table('nutri_dtl_subscriber')->whereMonth('expiry_date','=',$mvalue)->count();
           $exp_array[]  =   $expiry_month ;
        }

            
        $data['sub_array']      = $sub_array;
        $data['exp_array']      = $exp_array;
       //dd($data);
        $data['nutritionist_count']      = $nutritionist_count;
        $data['kitchen']                 = $kitchen;
        $data['opermanager_count']       = $opermanager_count;
        $data['total_subscriber_count']  = $total_subscriber_count;
        $data['new_subscriber_count']    = $new_subscriber_count;
        $data['expire_subscriber_count'] = $expire_subscriber_count;

        return view('admin/dashbord')->with(['data' => $data]);
   }







   
}
