<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Models\State;
use App\Models\Location;
use App\Models\City;
use Session;
use Sentinel;
use Validator;
use DB;
class PushNotificationController extends Controller
{
    public function __construct(Location $Location,City $City,State $State,PushNotification $PushNotification)
    {
        $data               = [];
       
        $this->base_model       = $PushNotification; 
        $this->base_city        = $City; 
        $this->base_state       = $State; 
        $this->title        = "Push Notification";
        $this->url_slug     = "push_notification";
        $this->folder_path  = "admin/push_notification/";
    }

    public function index()
    {
        $arr_data = [];
        //$data     = $this->base_model->where('is_deleted','<>',1)->get();
           $data     = \DB::table('nutri_mst_push_notification')
                       ->join('state','nutri_mst_push_notification.state_id','=','state.id')
                       ->join('city','nutri_mst_push_notification.city_id','=','city.id')
                       ->join('locations','nutri_mst_push_notification.area_id','=','locations.id')
                       ->where('nutri_mst_push_notification.is_deleted','<>',1)
                       ->select('nutri_mst_push_notification.*','city.city_name','state.name as state_name','locations.area as area_name')
                       ->orderBy('nutri_mst_push_notification.push_notification_id','DESC')
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
 
    public function add()
    {

        $state             = $this->base_state->get();
        $city              = $this->base_city->get();
        $data['page_name'] = "Add";
        $data['state']     = $state;
        $data['city']      = $city;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'notification_name' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'area_id' => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['notification_name'=>$request->input('notification_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "Notification already set!");
            return \Redirect::back();
        }

        $arr_data                        = [];
        $arr_data['notification_name']   = $request->input('notification_name');
        $arr_data['state_id']            = $request->input('state_id');
        $arr_data['city_id']             = $request->input('city_id');
        $arr_data['area_id']             = $request->input('area_id');
        //$arr_data['user_id']             = $request->input('user_id');
        $push_notification               = $this->base_model->create($arr_data);
      
        if(!empty($push_notification))
        {
            //send notification for area wise  users
            

            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_push_notification');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['push_notification_id'=>$id])->first();
          $state             = $this->base_state->get();
        $city              = $this->base_city->get();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
       
        $data['data']      = $arr_data;
        $data['state']     = $state;
        $data['city']      = $city;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'notification_name' => 'required',
                'state_id' => 'required',
                'city_id' => 'required',
                'area_id' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('push_notification_id','<>',$id)->where(['notification_name'=>$request->input('notification_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', "Notification already exist!");
            return \Redirect::back();
        }
        $arr_data                        = [];
        $arr_data['notification_name']   = $request->input('notification_name');
        $arr_data['state_id']            = $request->input('state_id');
        $arr_data['city_id']             = $request->input('city_id');
        $arr_data['area_id']             = $request->input('area_id');
        $module_update = $this->base_model->where(['push_notification_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_push_notification');
        
    }

    public function delete($id)
    {
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['push_notification_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    } 


    public function status(Request $request)
    {

        $status  = $request->status;
        $plan_id = $request->plan_ids;
        $arr_data               = [];
        if($status=="true")
        {
         $arr_data['is_active'] = '1';
        }
        if($status=="false")
        {
         $arr_data['is_active'] = '0';
        }   
        $this->base_model->where(['push_notification_id'=>$plan_id])->update($arr_data);
        //return \Redirect::back();
    }
}
