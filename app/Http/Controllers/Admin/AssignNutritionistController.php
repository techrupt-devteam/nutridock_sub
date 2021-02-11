<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AssignNutritionist;
use App\Models\Location;
use App\Models\User;
use App\Models\city;
use App\Models\State;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Config;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;
class AssignNutritionistController extends Controller
{
    public function __construct(AssignNutritionist $AssignNutritionist,Location $Location,City $City,State $State,User $User)
    {
        $data                = [];
        $this->base_model    = $AssignNutritionist; 
        $this->base_users    = $User; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->title         = "Assign Nutritionist";
        $this->url_slug      = "assign_nutritionist";
        $this->folder_path   = "admin/assign_nutritionist/";
        //Message
        $this->Insert        = Config::get('constants.messages.Insert');
        $this->Update        = Config::get('constants.messages.Update');
        $this->Delete        = Config::get('constants.messages.Delete');
        $this->Error         = Config::get('constants.messages.Error');
        $this->Is_exists     = Config::get('constants.messages.Is_exists');
    }

    //Assign Nutritionist Listing Function
    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('nutri_mst_subcriber_assign')
                     ->join('state','nutri_mst_subcriber_assign.state_id','=','state.id')
                     ->join('city','nutri_mst_subcriber_assign.city_id','=','city.id')
                     ->join('users','nutri_mst_subcriber_assign.nutritionist_id','=','users.id')
                  //   ->join('locations','nutri_mst_assign_location_menu.area_id','=','locations.id')
                     ->select('state.name as state_name','city.city_name','nutri_mst_subcriber_assign.*','users.name')
                     ->where('nutri_mst_subcriber_assign.is_deleted','<>',1)
                     ->orderBy('nutri_mst_subcriber_assign.subcriber_assign_id', 'DESC')
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

    //Assign Nutritionist Add Function 
    public function add()
    {
        $users              = $this->base_users->where('roles','=',1)->where('is_active','=',1)->where('is_deleted','<>',1)->get();
        $subscriber         = $this->base_users->get();
        $state               = $this->base_state->get();
        $data['page_name']  = "Add";
        $data['users']      = $users;    
        $data['state']      = $state;    
        $data['subscriber'] = $subscriber;
        $data['title']      = $this->title;
        $data['url_slug']   = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    //Assign Nutritionist Store Function
    public function store(Request $request)
    {

       $validator = Validator::make($request->all(), [
                'subscriber_id'   => 'required',
                'nutritionist_id' => 'required',
                'state_id'        => 'required',
                'city_id'         => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
   

        $subscriber_data   = implode(",",$request->input('subscriber_id'));
        $nutritionist_data = implode(",",$request->input('nutritionist_id'));

        $arr_data                       = [];
        $arr_data['state_id']           = $request->input('state_id');
        $arr_data['city_id']            = $request->input('city_id');
        $arr_data['subscriber_id']      = $subscriber_data;
        $arr_data['nutritionist_id']    = $nutritionist_data;
        $assign_nutritionist            = $this->base_model->create($arr_data);
        if(!empty($assign_nutritionist))
        {
          
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_assign_nutritionist');
        }
        else
        {
            Session::flash('error', $this->Error );
            return \Redirect::back();
        }
    }

    //Assign Nutritionist Function
    public function edit($id)
    {
        $id= base64_decode($id);
        $arr_data = [];
        $data     = $this->base_model->where(['subcriber_assign_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   

        $users                = $this->base_users->where('roles','=',1)->where('is_active','=',1)->where('is_deleted','<>',1)->get();
        $subscriber           = $this->base_users->get();
        $state                = $this->base_state->get();
        $data['data']         = $arr_data;
        $data['subscriber']   = $subscriber;
        $data['users']        = $users;
        $data['state']        = $state;
        $data['page_name']    = "Edit";
        $data['url_slug']     = $this->url_slug;
        $data['title']        = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    //Assign Nutritionist update function
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'subscriber_id'   => 'required',
            'nutritionist_id' => 'required',
            'state_id'        => 'required',
            'city_id'         => 'required'
              
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $subscriber_data   = implode(",",$request->input('subscriber_id'));
        $nutritionist_data = implode(",",$request->input('nutritionist_id'));

        $arr_data                       = [];
        $arr_data['state_id']           = $request->input('state_id');
        $arr_data['city_id']            = $request->input('city_id');
        $arr_data['subscriber_id']      = $subscriber_data;
        $arr_data['nutritionist_id']    = $nutritionist_data;
        $assign_nutritionist_update   = $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);

        Session::flash('success', $this->Update );
        return \Redirect::to('admin/manage_assign_nutritionist');        
    }

    //Assign Nutritionist delete function
    public function delete($id)
    {
        $id = base64_decode($id);
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    } 

    //on off staus
    public function status(Request $request)
    {
        $status  = $request->status;
        $id = $request->plan_ids;
        $arr_data               = [];
        if($status=="true")
        {
           $arr_data['is_active'] = '1';
        }
        if($status=="false")
        {
           $arr_data['is_active'] = '0';
        }   
        $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);
        //return \Redirect::back();
    }

}
