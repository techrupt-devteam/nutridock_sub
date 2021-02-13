<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\State;
use App\Models\city;
use App\Models\Location;
use App\Models\User;
use App\Models\AssignNutritionist;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;

class DashboardController extends Controller
{
   

    public function __construct(AssignNutritionist $AssignNutritionist,Location $Location,City $City,State $State,User $User)
    {
        $data                = [];
        $this->base_model    = $AssignNutritionist; 
        $this->base_users    = $User; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->title         = "Assign Nutritionist";
        $this->url_slug      = "assign_nutritionist";
        $this->folder_path   = "admin/assign_nutritionist/";
        //Message
        $this->Insert        = Config::get('constants.messages.Insert');
        $this->Update        = Config::get('constants.messages.Update');
        $this->Delete        = Config::get('constants.messages.Delete');
        $this->Error         = Config::get('constants.messages.Error');
        $this->Is_exists     = Config::get('constants.messages.Is_exists');
    }

   // Dashboard
   public function dashbord(Request $request)
   {
        $data = [];
        $user = \Sentinel::check();
        $login_user_details      = Session::get('user');

        //users count
        $nutritionist_count      = $this->base_users->where('roles','=',1)->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
        $opermanager_count       = $this->base_users->where('roles','=',2)->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();

        //subscriber count   
        $total_subscriber_count  = $this->base_users->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
        $new_subscriber_count    = $this->base_users->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();
        $expire_subscriber_count = $this->base_users->where('is_active','=',1)->where('is_deleted','<>',1)->get()->count();

        $data['nutritionist_count']      = $nutritionist_count;
        $data['opermanager_count']       = $opermanager_count;
        $data['total_subscriber_count']  = $total_subscriber_count;
        $data['new_subscriber_count']    = $new_subscriber_count;
        $data['expire_subscriber_count'] = $expire_subscriber_count;

        dd($data);

        return view('admin/dashbord',$data);
   }








   
}
