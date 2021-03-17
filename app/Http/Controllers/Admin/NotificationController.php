<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Pusher\Pusher;
use Session;
use DB;
use App\Models\Notification;
class NotificationController extends Controller
{

    public function __construct(Notification $Notification)
    {
        $data                       = [];
        $this->base_model           = $Notification; 
        //Default set pusher api code option 
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
        
        $this->title         = "Notification";
        $this->url_slug      = "notification";
        $this->folder_path   = "admin/notification/";
    }


    public function index()
    {

        $login_user_details     = Session::get('user');
        $user_role              = $login_user_details->roles;
        
        $notification_data      =   \DB::table('nutri_notification')->where('user_id','=',$login_user_details->id)
                                  ->where('users_role','=',$user_role)
                                  ->limit(50)
                                  ->orderBy('notification_id', 'DESC')
                                  ->get();
        $arr_data                  = [];
        $arr_data['is_active']     = '0';               
         \DB::table('nutri_notification')->where(['user_id'=>$login_user_details->id])->update($arr_data);

        $data['notification']      = $notification_data;
        $data['page_name']         = "Manage";
        $data['url_slug']          = $this->url_slug;
        $data['title']             = $this->title;
        if(count($notification_data) == 0)
        {
           Session::flash('warning', "You have not any notification !!");
        }

        return view($this->folder_path.'index',$data);
    }


    public function notify()
    {
        $login_city_id          = Session::get('login_city_id'); 
        $assign_subscriber      = Session::get('assign_subscriber'); 
        $user                   = \Sentinel::check();
        $login_user_details     = Session::get('user');
        $User_role              = $login_user_details->roles;
        /*if($User_role=="admin" && $login_city_id="all"){



        }else if($User_role=="admin" && $login_city_id!="all"){
        {


        }*/
        $data['message'] = $login_city_id;
        $this->pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);
    }
    public function dbnotification()
    {

        $city          = Session::get('login_city_id'); 
        $assign_subscriber      = Session::get('assign_subscriber'); 
        $user                   = \Sentinel::check();
        $login_user_details     = Session::get('user');
        $user_role              = $login_user_details->roles;
        
        /*if($user_role=='admin' && $login_city_id !="all")
        {

            $expiry_month = \DB::table('nutri_dtl_subscriber')->where('city','=',$city)->whereMonth('expiry_date','=',$mvalue)->where('expiry_date','<=',date('Y-m-d'))->get();

            $arr_data               = [];
            $arr_data['state_id']   = $request->input('state_id');
            $arr_data['cgst']       = $request->input('cgst');
            $arr_data['sgst']       = $request->input('sgst');
            $arr_data['igst']       = $request->input('igst');
            $gst_add                = $this->base_model->create($arr_data);

        }
        else
        {
            $expiry_month = \DB::table('nutri_dtl_subscriber')->whereMonth('expiry_date','=',$mvalue)->where('expiry_date','<=',date('Y-m-d'))->get();
        }*/ 
          

        $data                   =  \DB::table('nutri_notification')
                                   ->where('user_id','=',$login_user_details->id)
                                   ->where('is_active','=',1)
                                   ->orderBy('notification_id', 'DESC')
                                   ->get();
        
        $count                  = \DB::table('nutri_notification')
                                  ->where('user_id','=',$login_user_details->id)
                                  ->where('is_active','=',1)
                                  ->get()->count();

        $html  = "";

        foreach ($data as $key => $value) {

           $html .= "<li > <a href='".url('/admin').'/notification/'.$value->notification_id."'><i class='fa fa-bell'
           ></i>".ucfirst($value->message)."</a></li>";         
        }        
        return $html."#".$count;

        
        /*$data['message'] = $login_city_id;
        $this->pusher->trigger('notify-channel', 'App\\Events\\Notify', $data);*/
    }


    public function notification(Request $request)
    {
        $notification_id                =  $request->id;
        $arr_data                       = [];
        $arr_data['is_active']          = '0';
        $assign_nutritionist_update     = $this->base_model->where(['notification_id'=>$notification_id])->update($arr_data);
        $notification_data              = $this->base_model->where(['notification_id'=>$notification_id])->get();
        $data['notification']           = $notification_data;
        $data['page_name']              = "Manage";
        $data['url_slug']               = $this->url_slug;
        $data['title']                  = $this->title;
        return view($this->folder_path.'index',$data);
    }

}