<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Role;
use Session;
use Sentinel;
use Validator;
use DB;
class RoleController extends Controller
{
    public function __construct(Role $Role)
    {
        $data               = [];
        $this->base_model   = $Role; 
        $this->title        = "Role";
        $this->url_slug     = "role";
        $this->folder_path  = "admin/role/";
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
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'role_name' => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['role_name'=>$request->input('role_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "Role already exist!");
            return \Redirect::back();
        }

        $arr_data                 = [];
        $arr_data['role_name']   = $request->input('role_name');
        $role = $this->base_model->create($arr_data);
      
        if(!empty($role))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_role');
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
        $data     = $this->base_model->where(['role_id'=>$id])->first();
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
                'role_name' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('role_id','<>',$id)->where(['role_name'=>$request->input('role_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', "Role already exist!");
            return \Redirect::back();
        }
        $arr_data               = [];
        $arr_data['role_name']   = $request->input('role_name');
        $module_update = $this->base_model->where(['role_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_role');
        
    }

    public function delete($id)
    {
        $this->base_model->where(['role_id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
