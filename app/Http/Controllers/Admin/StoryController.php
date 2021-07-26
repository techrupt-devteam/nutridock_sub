<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\StoryType;
use Config;
use Session;
use Sentinel;
use Validator;
use DB;
class StoryController extends Controller
{
    public function __construct(StoryType $StoryType)
    {
        $data               = [];
        $this->base_model   = $StoryType; 
        $this->title        = "Story Type";
        $this->url_slug     = "story_type";
        $this->folder_path  = "admin/story/";
        //Message
        $this->Insert = Config::get('constants.messages.Insert');
        $this->Update = Config::get('constants.messages.Update');
        $this->Delete = Config::get('constants.messages.Delete');
        $this->Error = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');
    }

    //Menu Listing Function
    public function index()
    {
        $arr_data = [];
        $data     = $this->base_model->orderby('story_id','DESC')->get();
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

    // Story Type Add Function 
    public function add()
    {
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    // Story Type Store Function
    public function store(Request $request)
    {
        $valstory_idator = Validator::make($request->all(), [
                'story_name' => 'required'
            ]);
        if ($valstory_idator->fails()) 
        {
            return $valstory_idator->errors()->all();
        }
        $is_exist = $this->base_model->where(['story_name'=>$request->input('story_name')])->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        $arr_data                 = [];
        $arr_data['story_name']   = $request->input('story_name');
        $role = $this->base_model->create($arr_data);
        if(!empty($role))
        {
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_story_type');
        }
        else
        {
            Session::flash('error', $this->Error);
            return \Redirect::back();
        }
    }

    // Menu Edit Function
    public function edit($story_id)
    {
        $story_id= base64_decode($story_id);
        $arr_data = [];
        $data     = $this->base_model->where(['story_id'=>$story_id])->first();
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

    // Menu category update function
    public function update(Request $request, $story_id)
    {
        $valstory_idator = Validator::make($request->all(), [
                'story_name' => 'required'
            ]);
        if ($valstory_idator->fails()) 
        {
            return $valstory_idator->errors()->all();
        }
        $is_exist = $this->base_model->where('story_id','<>',$story_id)->where(['story_name'=>$request->input('story_name')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        $arr_data               = [];
        $arr_data['story_name']   = $request->input('story_name');
        $module_update = $this->base_model->where(['story_id'=>$story_id])->update($arr_data);
        Session::flash('success',$this->Update );
        return \Redirect::to('admin/manage_story_type');        
    }

    // Menu category delete function
    public function delete($story_id)
    {
        $story_id= base64_decode($story_id);
        $this->base_model->where(['story_id'=>$story_id])->delete();
        Session::flash('success',$this->Delete);
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
        $this->base_model->where(['story_id'=>$plan_id])->update($arr_data);
        //return \Redirect::back();
    }
}
