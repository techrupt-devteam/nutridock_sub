<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Kitchen;
use App\Models\Location;
use App\Models\city;
use App\Models\State;
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
    public function __construct(Kitchen $Kitchen,Location $Location,City $City,State $State)
    {
        $data                = [];
        $this->base_model    = $Kitchen; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->title         = "Cloude Kitchen";
        $this->url_slug      = "kitchen";
        $this->folder_path   = "admin/Kitchen/";
        //Message
        $this->Insert        = Config::get('constants.messages.Insert');
        $this->Update        = Config::get('constants.messages.Update');
        $this->Delete        = Config::get('constants.messages.Delete');
        $this->Error         = Config::get('constants.messages.Error');
        $this->Is_exists     = Config::get('constants.messages.Is_exists');
    }
    
    // folder index view call  function
    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('nutri_mst_kitchen')
                     ->join('state','nutri_mst_kitchen.state_id','=','state.id')
                     ->join('city','nutri_mst_kitchen.city_id','=','city.id')
                     ->join('locations','nutri_mst_kitchen.area_id','=','locations.id')
                     ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_kitchen.*')
                     ->where('nutri_mst_kitchen.is_deleted','<>',1)
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
       
        $state             = $this->base_state->get();
        $data['page_name'] = "Add";
        
        $data['state']      = $state;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
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

        $arr_data                    = [];
        $arr_data['kitchen_name']    = $request->input('kitchen_name');
        $arr_data['customer_key']    = $request->input('customer_key');
        $arr_data['state_id']        = $request->input('state_id');
        $arr_data['city_id']         = $request->input('city_id');
        $arr_data['area_id']         = $request->input('area_id');
        $arr_data['pincode']         = $request->input('pincode');
        $arr_data['address']         = $request->input('address');

        $store_kitchen = $this->base_model->create($arr_data);
      
        if(!empty($store_kitchen))
        {
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
        $id = base64_decode($id);
        $arr_data = [];
        $data     = $this->base_model->where(['kitchen_id'=>$id])->first();
        $state             = $this->base_state->get();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
       
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
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

        $arr_data                    = [];
        $arr_data['kitchen_name']    = $request->input('kitchen_name');
        $arr_data['customer_key']    = $request->input('customer_key');
        $arr_data['state_id']        = $request->input('state_id');
        $arr_data['city_id']         = $request->input('city_id');
        $arr_data['area_id']         = $request->input('area_id');
        $arr_data['pincode']         = $request->input('pincode');
        $arr_data['address']         = $request->input('address');

        $update_kitchen  = $this->base_model->where(['kitchen_id'=>$id])->update($arr_data);

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


}
