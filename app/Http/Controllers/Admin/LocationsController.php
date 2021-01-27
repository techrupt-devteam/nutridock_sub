<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Location;
use App\Models\city;
use Session;
use Sentinel;
use Validator;
use DB;
class LocationsController extends Controller
{
    public function __construct(Location $Location,City $City,State $State)
    {
        $data               = [];
        $this->base_model   = $Location; 
        $this->base_city    = $City; 
        $this->base_state   = $State; 
        $this->title        = "Location";
        $this->url_slug     = "location";
        $this->folder_path  = "admin/location/";
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
                'area' => 'required'
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

        $arr_data                 = [];
        $arr_data['area']   = $request->input('area');
        $arr_data['city']   = $request->input('city');
        $arr_data['state']  = $request->input('state');
        $role = $this->base_model->create($arr_data);
      
        if(!empty($role))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_location');
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
                'area' => 'required'
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
        $arr_data               = [];
        $arr_data['area']   = $request->input('area');
        $arr_data['city']   = $request->input('city');
        $arr_data['state']  = $request->input('state');
        $update = $this->base_model->where(['id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_location');
        
    }

    public function delete($id)
    {
        $this->base_model->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
