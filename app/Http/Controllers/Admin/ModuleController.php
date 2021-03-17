<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\ModuleType;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
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

        //Message
        $this->Insert = Config::get('constants.messages.Insert');
        $this->Update = Config::get('constants.messages.Update');
        $this->Delete = Config::get('constants.messages.Delete');
        $this->Error = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');
    }

    public function index()
    {
        $arr_data = [];
        //$data     = $this->base_model::find(1)->with(['moduletype'])->get();
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
        $type = $this->base_model->where(['parent_id'=>0])->get();
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
               //  'type_id'  => 'required',
               // 'module_url'  => 'required'

            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['module_name'=>$request->input('module_name')])->count();

        if($is_exist)
        {
            Session::flash('error',$this->Is_exists);
            return \Redirect::back();
        }

        $arr_data                       = [];
        $arr_data['module_name']        = $request->input('module_name');
        $arr_data['parent_id']          = (!empty($request->input('parent_id'))) ? $request->input('parent_id') : 0 ;
        $arr_data['module_url']         = $request->input('module_url');
        $arr_data['module_url_slug']    = $request->input('module_url_slug');
        $user = $this->base_model->create($arr_data);
      
        if(!empty($user))
        {
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_module');
        }
        else
        {
            Session::flash('error',  $this->Error);
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
        $parent = $this->base_model->where(['parent_id'=>0])->get();
        $data['parent']    = $parent;
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
                /*'parent_id'  => 'required',
                'module_url'  => 'required'*/
            ]);
        if($validator->fails()) 
        {
           return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('module_id','<>',$id)->where(['module_name'=>$request->input('module_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        $arr_data                       = [];
        $arr_data['module_name']        = $request->input('module_name');
        $arr_data['module_url']         = $request->input('module_url');
        $arr_data['parent_id']          = (!empty($request->input('parent_id'))) ? $request->input('parent_id') : 0 ;
        $arr_data['module_url_slug']    = $request->input('module_url_slug');
        $module_update = $this->base_model->where(['module_id'=>$id])->update($arr_data);
        Session::flash('success',  $this->Update);
        return \Redirect::to('admin/manage_module');
        
    }

    public function delete($id)
    {
        $this->base_model->where(['module_id'=>$id])->delete();
        Session::flash('success', $this->Delete);
        return \Redirect::back();
    }
}
