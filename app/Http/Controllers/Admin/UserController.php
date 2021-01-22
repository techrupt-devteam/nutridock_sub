<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\ModuleType;

use Session;
use Sentinel;
use Validator;
use DB;
class UserController extends Controller
{
    public function __construct(User $User,Role $Role,ModuleType $ModuleType)
    {
        $data               = [];
        $this->base_model   = $User; 
        $this->role         = $Role; 
        $this->type         = $ModuleType; 
        $this->title        = "Users";
        $this->url_slug     = "user";
        $this->folder_path  = "admin/users/";
    }

    public function index()
    {
        $arr_data = [];
        //$data     = $this->base_model->where('role','<>','admin')->get();

            $data = \DB::table('users')
                     ->join('role','users.roles','=','role.role_id')
                     ->join('module_type','users.type_id','=','module_type.type_id')
                     ->select('role.role_name','module_type.type_name','users.*')
                     ->where('users.roles','<>','admin')
                     ->orderBy('users.id','DESC')
                     ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }
        $login_user_details  = Session::get('user');
         //dd($login_user_details);
        if($login_user_details->role!='admin')
        {
            Session::flash('error', 'Unauthorized Access.');
            return \Redirect::to('admin/dashbord');
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
 
    public function add()
    {
        $city_data = \DB::table('city')
                     ->orderBy('id','DESC')
                     ->groupBy('city')
                     ->get()->toArray();
        $role = $this->role->get();              
        $type = $this->type->get();              
        $data['page_name'] = "Add";
        $data['type']      = $type;
        $data['role']      = $role;
        $data['city']      = $city_data;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function getArea(Request $request)
    {
        $city_name = $request->city;
        $location_data = \DB::table('locations')
                          ->where(['is_active'=>1,'city'=>$city_name])
                          ->orderBy('id','DESC')
                          ->get()->toArray();
        $html = "";
        $html = "<option value=''>-Select-</option>";
        foreach ($location_data as $key => $value) 
        {
          $html.="<option value=".$value->area.">".$value->area."</option>";                
        }                 
        return $html;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required',
                'password'   => 'required',
                'city'       => 'required',
                'area'       => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "Email already exist!");
            return \Redirect::back();
        }

        $arr_data                 = [];
        $arr_data['first_name']   = $request->input('first_name');
        $arr_data['last_name']    = $request->input('last_name');
        $arr_data['email']        = $request->input('email');
        $arr_data['password']     = bcrypt($request->input('password'));
        $arr_data['city']         = $request->input('city');
        $arr_data['area']         = $request->input('area');
        $arr_data['role']         = $request->input('role');
        $arr_data['type_id']      = $request->input('type_id');

        $user = $this->base_model->create($arr_data);
      
        if(!empty($user))
        {
            //it is use for user activator
            $arr_dat = []; 
            $arr_dat['user_id'] = $user->id; 
            $arr_dat['completed_at'] = 1; 
            $arr_dat['completed'] = 1;   
            $activations = \DB::table('activations')->insert($arr_dat);

            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_users');
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

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }
        $city_data = \DB::table('city')->orderBy('id','DESC')->groupBy('city')->get()->toArray();
        $location_data = \DB::table('locations')
                          ->where(['is_active'=>1])
                          ->orderBy('id','DESC')
                          ->get()->toArray();
        $role = $this->role->get();              
        $type = $this->type->get();              
        $data['type']      = $type;                 
        $data['roles']      = $role;                 
        $data['city']      = $city_data;
        $data['location']  = $location_data;
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name'  => 'required',
                'email'      => 'required',
                'city'       => 'required',
                'area'       => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('id','<>',$id)->where(['email'=>$request->input('email')])->count();

        if($is_exist)
        {
            Session::flash('error', "Record already exist!");
            return \Redirect::back();
        }

        $arr_data               = [];
        $arr_data                 = [];
        $arr_data['first_name']   = $request->input('first_name');
        $arr_data['last_name']    = $request->input('last_name');
        $arr_data['email']        = $request->input('email');
        $arr_data['city']         = $request->input('city');
        $arr_data['area']         = $request->input('area');
        $arr_data['roles']         = $request->input('role');
        $arr_data['type_id']      = $request->input('type_id');
        $category = $this->base_model->where(['id'=>$id])->update($arr_data);

        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_users');
    }

    public function delete($id)
    {
        $this->base_model->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
