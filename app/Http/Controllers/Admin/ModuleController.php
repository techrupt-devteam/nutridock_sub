<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Model\Module;
use App\Model\ModuleType;
use Session;
use Sentinel;
use Validator;
use DB;
class ModuleController extends Controller
{
    public function __construct(Module $Module,ModuleType $moduletype)
    {
        $data               = [];
        $this->base_model   = $Module; 
        $this->moduletype   = $moduletype; 
        $this->title        = "Module";
        $this->url_slug     = "module";
        $this->folder_path  = "admin/module/";
    }

    public function index()
    {
        $arr_data = [];
        $data     = $this->base_model::find(1)->with(['moduletype'])->get();
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
        $type = $this->moduletype->get();
        $data['page_name'] = "Add";
        $data['type']      = $type;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'module_name' => 'required',
                'type_id'  => 'required',
                'module_url'  => 'required'

            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['module_name'=>$request->input('module_name'),'type_id'=>$request->input('type_id')])->count();

        if($is_exist)
        {
            Session::flash('error', "module already exist!");
            return \Redirect::back();
        }

        $arr_data                  = [];
        $arr_data['module_name']   = $request->input('module_name');
        $arr_data['type_id']       = $request->input('type_id');
        $arr_data['module_url']    = $request->input('module_url');
        $user = $this->base_model->create($arr_data);
      
        if(!empty($user))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_module');
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
        $data     = $this->base_model->where(['module_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $type = $this->moduletype->get();        
        $data['type']      = $type;
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'module_name' => 'required',
                'type_id'  => 'required',
                'module_url'  => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('module_id','<>',$id)->where(['module_name'=>$request->input('module_name'),'type_id'=>$request->input('type_id')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', "Record already exist!");
            return \Redirect::back();
        }
        $arr_data               = [];
        $arr_data['module_name']   = $request->input('module_name');
        $arr_data['module_url']    = $request->input('module_url');
        $arr_data['type_id']       = $request->input('type_id');
        $module_update = $this->base_model->where(['module_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_module');
        
    }

    public function delete($id)
    {
        $this->base_model->where(['module_id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
