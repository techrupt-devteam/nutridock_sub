<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\plan;
use Session;
use Sentinel;
use Validator;
use DB;
class planController extends Controller
{
    public function __construct(plan $Plan)
    {
        $data               = [];
        $this->base_model   = $Plan; 
        $this->title        = "Plan";
        $this->url_slug     = "plan";
        $this->folder_path  = "admin/plan/";
    }

    public function index()
    {
        $arr_data = [];
        $data     = $this->base_model->where('is_deleted','<>',1)->get();
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
                'plan_name' => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['plan_name'=>$request->input('plan_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "plan already exist!");
            return \Redirect::back();
        }

        $arr_data                 = [];
        $arr_data['plan_name']   = $request->input('plan_name');
        $plan = $this->base_model->create($arr_data);
      
        if(!empty($plan))
        {
            Session::flash('success', 'Success! Record added successfully.');
            return \Redirect::to('admin/manage_plan');
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
        $data     = $this->base_model->where(['plan_id'=>$id])->first();
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
                'plan_name' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('plan_id','<>',$id)->where(['plan_name'=>$request->input('plan_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', "plan already exist!");
            return \Redirect::back();
        }
        $arr_data               = [];
        $arr_data['plan_name']   = $request->input('plan_name');
        $module_update = $this->base_model->where(['plan_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_plan');
        
    }

    public function delete($id)
    {
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['plan_id'=>$id])->update($arr_data);
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
        $this->base_model->where(['plan_id'=>$plan_id])->update($arr_data);
        //return \Redirect::back();
    }
}
