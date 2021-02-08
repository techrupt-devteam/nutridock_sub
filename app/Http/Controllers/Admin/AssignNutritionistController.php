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
        $data     = \DB::table('nutri_mst_assign_location_menu')
                     ->join('state','nutri_mst_assign_location_menu.state_id','=','state.id')
                     ->join('city','nutri_mst_assign_location_menu.city_id','=','city.id')
                     ->join('locations','nutri_mst_assign_location_menu.area_id','=','locations.id')
                     ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_assign_location_menu.*')
                     ->where('nutri_mst_assign_location_menu.is_deleted','<>',1)
                     ->orderBy('nutri_mst_assign_location_menu.assign_menu_id', 'DESC')
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
        $users              = $this->base_users->get();
        $subscriber         = $this->base_users->get();
        $data['page_name']  = "Add";
        $data['users']      = $users;    
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
                'nutritionist_id' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
   


        $arr_data                       = [];
        $arr_data['subscriber_id']      = $request->input('subscriber_id');
        $arr_data['nutritionist_id']    = $request->input('nutritionist_id');
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
        $users                = $this->base_users->get();
        $subscriber           = $this->base_users->get();
        $data['data']         = $arr_data;
        $data['subscriber']   = $subscriber;
        $data['users']        = $users;
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
            'nutritionist_id' => 'required'
              
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $arr_data                       = [];
        $arr_data['subscriber_id']      = $request->input('subscriber_id');
        $arr_data['nutritionist_id']    = $request->input('nutritionist_id');
        $assign_nutritionist_update = $this->base_model->where(['subcriber_assign_id'=>$id])->update($arr_data);
        
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
