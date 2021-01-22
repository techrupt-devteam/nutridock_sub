<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Nutritionsit;
use App\Models\Location;
use App\Models\city;
use App\Models\Role;
use App\Models\State;
use Session;
use Sentinel;
use Validator;
use DB;
class NutritionsitController extends Controller
{
    public function __construct(Nutritionsit $Nutritionsit,Location $Location,City $City,Role $Role,State $State)
    {
        $data                = [];
        $this->base_model    = $Nutritionsit; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->base_role     = $Role;  
        $this->title         = "Nutritionsit";
        $this->url_slug      = "nutritionsit";
        $this->folder_path   = "admin/nutritionsit/";
    }

    public function index()
    {
        $arr_data = [];
        $data     = $this->base_model->get();
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
        $role              = $this->base_role->get();
        $state             = $this->base_state->get();
        $data['page_name'] = "Add";
        $data['role']      = $role;
        $data['state']      = $state;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'nutritionsit_name' => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['nutritionsit_name'=>$request->input('nutritionsit_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "Nutritionsit already exist!");
            return \Redirect::back();
        }

        $arr_data                 = [];
        $arr_data['nutritionsit_name']   = $request->input('nutritionsit_name');
        $role = $this->base_model->create($arr_data);
      
        if(!empty($role))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_nutritionsit');
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
        $data     = $this->base_model->where(['nutritionsit_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
       
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'nutritionsit_name' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('nutritionsit_id','<>',$id)->where(['nutritionsit_name'=>$request->input('nutritionsit_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', "Nutritionsit already exist!");
            return \Redirect::back();
        }
        $arr_data               = [];
        $arr_data['nutritionsit_name']   = $request->input('nutritionsit_name');
        $module_update = $this->base_model->where(['nutritionsit_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_nutritionsit');
        
    }

    public function delete($id)
    {
        $this->base_model->where(['nutritionsit_id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
