<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Gst;
use App\Models\State;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
class GstController extends Controller
{
    public function __construct(Gst $Gst ,State $State)
    {
        $data               = [];
        $this->base_state   = $State; 
        $this->base_model   = $Gst; 
        $this->title        = "GST Setting";
        $this->url_slug     = "gst";
        $this->folder_path  = "admin/gst/";
        
        //Message
        $this->Insert       = Config::get('constants.messages.Insert');
        $this->Update       = Config::get('constants.messages.Update');
        $this->Delete       = Config::get('constants.messages.Delete');
        $this->Error        = Config::get('constants.messages.Error');
        $this->Is_exists    = Config::get('constants.messages.Is_exists');
        
    }

    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('nutri_mst_gst_setting')
                     ->join('state','nutri_mst_gst_setting.state_id','=','state.id')
                     ->select('state.name as state_name','nutri_mst_gst_setting.*')
                     ->orderBy('nutri_mst_gst_setting.gst_id', 'DESC')
                     ->get();
        //dd($data)             
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
        $state             = $this->base_state->get();
        $data['state']     = $state;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'state_id' => 'required',
                'cgst'     => 'required',
                'sgst'     => 'required',
                'igst'     => 'required'
            ]);

        if($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['state_id'=>$request->input('state_id')])->count();

        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }

        $arr_data               = [];
        $arr_data['state_id']   = $request->input('state_id');
        $arr_data['cgst']       = $request->input('cgst');
        $arr_data['sgst']       = $request->input('sgst');
        $arr_data['igst']       = $request->input('igst');
        $gst_add                = $this->base_model->create($arr_data);
      
        if(!empty($gst_add))
        {
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_gst');
        }
        else
        {
            Session::flash('error', $this->Error);
            return \Redirect::back();
        }
    }

    public function edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['gst_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }  

        $state             = $this->base_state->get();
        $data['state']     = $state;
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'state_id' => 'required',
                'cgst'     => 'required',
                'sgst'     => 'required',
                'igst'     => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where('gst_id','<>',$id)->where(['state_id'=>$request->input('state_id')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        $arr_data               = [];
        $arr_data['state_id']   = $request->input('state_id');
        $arr_data['cgst']       = $request->input('cgst');
        $arr_data['sgst']       = $request->input('sgst');
        $arr_data['igst']       = $request->input('igst');

        $gst_update = $this->base_model->where(['gst_id'=>$id])->update($arr_data);
        Session::flash('success',  $this->Update);
        return \Redirect::to('admin/manage_gst');
        
    }

    public function delete($id)
    {
        $this->base_model->where(['gst_id'=>$id])->delete();
        Session::flash('success', $this->Delete);
        return \Redirect::back();
        
    }
}
