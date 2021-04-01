<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Location;
use App\Models\City;
use App\Models\DeliveryLocation;
use Session;
use Sentinel;
use Validator;
use DB;
class LocationsController extends Controller
{
    public function __construct(Location $Location,City $City,State $State,DeliveryLocation $DeliveryLocation)
    {
        $data                   = [];
        $this->base_model       = $Location; 
        $this->base_city        = $City; 
        $this->base_state       = $State; 
        $this->base_dlocation   = $DeliveryLocation; 
        $this->title            = "Location";
        $this->url_slug         = "location";
        $this->folder_path      = "admin/location/";
    }

    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('locations')
                   ->join('state','locations.state','=','state.id')
                   ->join('city','locations.city','=','city.id')
                   ->select('locations.*','city.city_name','state.name')
                   ->orderBy('id','DESC')
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
               'state' => 'required',
                'city' => 'required',
                'area' => 'required',
                'pincode' => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['area'=>$request->input('area')])->count();

        if($is_exist)
        {
            Session::flash('error', "Area already exist!");
            return \Redirect::back();
        }

        $arr_data             = [];
        $arr_data['area']     = $request->input('area');
        $arr_data['city']     = $request->input('city');
        $arr_data['state']    = $request->input('state');
        $arr_data['pincode']  = $request->input('pincode');
        $location = $this->base_model->create($arr_data);
      
        if(!empty($role))
        {
           Session::flash('success', 'Success! Record added successfully.');
           return \Redirect::to('admin/manage_location');

            $arr_data2                         = [];
            $arr_data2['delivery_pincode']     = $request->input('pincode');
            $arr_data2['delivery_city_id']     = $request->input('city');
            $location_data = $this->base_dlocation->create($arr_data2);
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
        $data     = $this->base_model->where(['id'=>$id])->first();
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
                'state' => 'required',
                'city' => 'required',
                'area' => 'required',
                'pincode' => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('id','<>',$id)->where(['area'=>$request->input('area')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', "Area already exist!");
            return \Redirect::back();
        }
        $arr_data              = [];
        $arr_data['area']      = $request->input('area');
        $arr_data['city']      = $request->input('city');
        $arr_data['state']     = $request->input('state');
        $arr_data['pincode']   = $request->input('pincode');

        $update = $this->base_model->where(['id'=>$id])->update($arr_data);

        $arr_data2                         = [];
        $arr_data2['delivery_pincode']     = $request->input('pincode');
        $arr_data2['delivery_city_id']     = $request->input('city');
        $location_data = $this->base_dlocation->create($arr_data2);

        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_location');
        
    }

    // public function delete($id)
    // {
    //     $this->base_model->where(['id'=>$id])->delete();
    //     Session::flash('success', 'Success! Record deleted successfully.');
    //     return \Redirect::back();
    // }

     //change menu_status  
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
        $this->base_model->where(['id'=>$plan_id])->update($arr_data);
        //return \Redirect::back();
    }
}
