<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Module;
use App\Models\ModuleType;
use App\Models\Role;
use Session;
use Sentinel;
use Validator;
use DB;
class PermissionController extends Controller
{
    public function __construct(Permission $Permission,Module $Module,ModuleType $moduletype,Role $Role)
    {
        $data               = [];
        $this->base_model   = $Permission; 
        $this->module       = $Module; 
        $this->moduletype   = $moduletype; 
        $this->role         = $Role; 
        $this->title        = "Permission";
        $this->url_slug     = "permission";
        $this->folder_path  = "admin/permission/";
    }

    public function index()
    {
      $arr_data = [];
      $data     = \DB::table('permission')
                   ->join('role','permission.role_id','=','role.role_id')
                   ->join('module_type','permission.type_id','=','module_type.type_id')
                   ->select('role.role_name','module_type.type_name','permission.*')
                   ->orderBy('permission.per_id','DESC')
                   ->get()->toArray();
      /*if(!empty($data))
      {
          $arr_data = $data->toArray();
      }*/
      
      //dd($data[0]->role_name);
      $data['data']      = $data;
      $data['page_name'] = "Manage";
      $data['url_slug']  = $this->url_slug;
      $data['title']     = $this->title;
      return view($this->folder_path.'index',$data);
    }
 
    public function add()
    {
      $type = $this->moduletype->get();
      $role = $this->role->get();
      $data['page_name'] = "Add";
      $data['type']      = $type;
      $data['role']      = $role;
      $data['title']     = $this->title;
      $data['url_slug']  = $this->url_slug;
      return view($this->folder_path.'add',$data);
    }
    
    public function get_menu(Request $request)
    {
       $type_id = $request->type_id;
       $per_id  =  $request->per_id;
       if(!empty($per_id)){
       $get_permission_data = $this->base_model->where(['per_id'=>$per_id])->select('permission_access')->first();
       $permission_arr = explode(",",$get_permission_data['permission_access']);
       }
       $model_list = $this->module->where(['type_id'=>$type_id])->get();
       $html="";
       $html.='<div class="col-md-6" style="margin-left: 12px;">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>Sr.No</th>
                      <th>Module Name</th>
                      <th class="text-center">Permission</th>
                    </tr>
                </thead><tbody>';
        $i=1;
        foreach ($model_list as $value) {

          if(!empty($per_id))   
          {
            $html.='<tr>
                    <td>'.$i.') </td>
                    <td>'.$value['module_name'].'</td>
                    <td class="text-center"> <input type="checkbox" class="form-check-input" name="permission_access[]" id="" value="'.$value['module_id'].'" '.(in_array($value['module_id'], $permission_arr) ? 'checked' : '').'></td>
                  </tr>';
          }
          else
          {
           $html.='<tr>
                    <td>'.$i.') </td>
                    <td>'.$value['module_name'].'</td>
                    <td class="text-center"> <input type="checkbox" class="form-check-input" name="permission_access[]" id="" value="'.$value['module_id'].'" ></td>
                  </tr>';
          }

        $i++;
       }
       $html.="</tbody></table></div>";
       return $html;
    }




    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'role_id' => 'required',
                'type_id'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        
        $is_exist = $this->base_model->where(['role_id'=>$request->input('role_id'),'type_id'=>$request->input('type_id')])->count();
       
        if($is_exist)
        {
            Session::flash('error', "Permission already exist!");
            return \Redirect::back();
        }
        
        $permissions_data = implode(",",$request->input('permission_access'));
       
        $arr_data                       = [];
        $arr_data['role_id']            = $request->input('role_id');
        $arr_data['type_id']            = $request->input('type_id');
        $arr_data['permission_access']  = $permissions_data;
        $permissions = $this->base_model->create($arr_data);
        if(!empty($permissions))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_permission');
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
        $data     = $this->base_model->where(['per_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $type = $this->moduletype->get();
        $role = $this->role->get();        
        $data['type']      = $type;
        $data['role']      = $role;
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }
    
    public function get_menu_list(Request $request)
    {

       $type_id = $request->type_id;
       $per_id  =  $request->per_id;

       $model_list = $this->module->where(['type_id'=>$type_id])->get();
       $get_permission_data = $this->base_model->where(['per_id'=>$per_id])->select('permission_access')->first();
       $permission_arr = explode(",",$get_permission_data['permission_access']);
       /*print_r($permission_arr);
       exit;*/
       $html="";
       $html.='<div class="col-md-6" style="margin-left: 12px;">
                <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                      <th>Sr.No</th>
                      <th>Module Name</th>
                      <th class="text-center">Permission</th>
                    </tr>
                </thead><tbody>';
        $i=1;
        //print_r($permission_arr);
        foreach ($model_list as $key => $value) 
        {   
          
            $html.='<tr>
                <td>'.$i.') </td>
                <td>'.$value['module_name'].'</td>
                <td class="text-center">';
                $html.='<input type="checkbox" class="form-check-input" name="permission_access[]"  value="'.$value['module_id'].'" '.(in_array($value['module_id'], $permission_arr) ? 'checked' : '').'  >';
                $html.='</td>
               </tr>';       
            $i++;
       }
       
       $html.="</tbody></table></div>";
       return $html;
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'role_id' => 'required',
                'type_id'  => 'required',
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('per_id','<>',$id)->where(['role_id'=>$request->input('role_id'),'type_id'=>$request->input('type_id')])
                    ->count();
        
        if($is_exist)
        {
            Session::flash('error', "Role already exist!");
            return \Redirect::back();
        }

        $arr_data               = [];
        $permissions_data = implode(",",$request->input('permission_access'));
        $arr_data                       = [];
        $arr_data['role_id']            = $request->input('role_id');
        $arr_data['type_id']            = $request->input('type_id');
        $arr_data['permission_access']  = $permissions_data;
        $module_update = $this->base_model->where(['per_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_permission');
    }

    public function delete($id)
    {
        $this->base_model->where(['per_id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
