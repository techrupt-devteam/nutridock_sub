<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\City;
use App\Models\State;
use App\Models\Notification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Session;
use Sentinel;
use Validator;

use Mail;
class FeedbackController extends Controller
{
    public function __construct(Feedback $Feedback,City $City,Notification $Notification)
    {
        $data               = [];
        $this->base_model   = $Feedback;
        $this->base_city    = $City;
        $this->base_notification    = $City;
        $this->url_slug    = "feedback";
        $this->title        = "FeedBack";
        $this->folder_path  = "admin/feedback/";
    }

    public function index()
    {
        $arrdata = \DB::table('nutri_mst_feedback')
                  ->join('locations','nutri_mst_feedback.area','=','locations.id')
                  ->join('city','nutri_mst_feedback.city','=','city.id')
                  ->select('city.city_name','locations.area as area_name','nutri_mst_feedback.*')
                  ->get();

        $data['data']      = $arrdata;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
   
    public function add()
    {
        $city = $this->base_city->get();
        $data['seo_title'] = "FeedBack";
        $data['url_slug']  = $this->url_slug;
        $data['city']      = $city;
        return view('feedback',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'email'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }


        $arr_data               = [];
        $arr_data['name']       = $request->input('name');
        $arr_data['email']      = $request->input('email');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        $arr_data['feedback']   = $request->input('feedback');
        $arr_data['city']       = $request->input('city');
        $arr_data['area']       = $request->input('area');

        $feedback = $this->base_model->create($arr_data);
        if (!empty($feedback))
        {
             $notify_arr['message']    = 'New Feedback from <b>'.$request->input('name')."</b>";
            $notify_arr['users_role'] = 'admin' ; 
            $notify_arr['user_id']    = 1; 
            $assign_nutritionist_notification = $this->base_notification->create($notify_arr);
            Session::flash('success', 'Success! FeedBack Send successfully.');
            return \Redirect::to('feedback');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function details(Request $request)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['feedback_id'=>$request->id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
    
        return view($this->folder_path.'view',$data);
    } 
   
    public function replay(Request $request)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['feedback_id'=>$request->id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }
        $data['data']      = $arr_data;
        return view($this->folder_path.'sendmail',$data);
    }

    public function send_replay(Request $request)
    {
            $data=[];
            $data['name']            = $request->cust_name;
            $data['feedback_mail']   = $request->feedback_mail;
            $data['feedback_replay'] = $request->feedback_replay;
            //dd($data['name']);
            $to =  $request->feedback_mail;
            $subject = 'Nutridock Fit - Feedback Reply';
            $customer_mail = Mail::send($this->folder_path.'replaymail',$data, function($message) use($to, $subject) {
                 $message->to($to);
                 $message->subject($subject);
                 $message->from('admin@nutridock.com','Nutridock Fit');
             });

            Session::flash('success', 'FeedBack reply Send successfully.');

              return \Redirect::back();
    }
    
}
