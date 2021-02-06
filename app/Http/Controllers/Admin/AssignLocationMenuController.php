<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\AssignLocationMenu;
use App\Models\Location;
use App\Models\MenuModel;
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
class AssignLocationMenuController extends Controller
{
    public function __construct(AssignLocationMenu $AssignLocationMenu,Location $Location,City $City,State $State,MenuModel $MenuModel)
    {
        $data                = [];
        $this->base_model    = $AssignLocationMenu; 
        $this->base_menu     = $MenuModel; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->title         = "Assign Location Menu ";
        $this->url_slug      = "assign_location_menu";
        $this->folder_path   = "admin/assign_location_menu/";
        //Message
        $this->Insert        = Config::get('constants.messages.Insert');
        $this->Update        = Config::get('constants.messages.Update');
        $this->Delete        = Config::get('constants.messages.Delete');
        $this->Error         = Config::get('constants.messages.Error');
        $this->Is_exists     = Config::get('constants.messages.Is_exists');
    }

    //Assign Menu Listing Function
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

    //Assign Menu Add Function 
    public function add()
    {
        $state             = $this->base_state->get();
        $menu              = $this->base_menu->get();
        $data['page_name'] = "Add";
        $data['menu']      = $menu;
        $data['state']     = $state;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    //Assign Menu Store Function
    public function store(Request $request)
    {

       $validator = Validator::make($request->all(), [
                'state_id' => 'required',
                'city_id' => 'required',
                'area_id' => 'required',

            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
   
        $menu_id_data = implode(",",$request->input('menu'));

        $arr_data              = [];
        $arr_data['state_id']  = $request->input('state_id');
        $arr_data['city_id']   = $request->input('city_id');
        $arr_data['area_id']   = $request->input('area_id');
        $arr_data['menu_id']   = $menu_id_data;
        
        $assign_menu_location  = $this->base_model->create($arr_data);
        if(!empty($assign_menu_location))
        {
          
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_assign_location_menu');
        }
        else
        {
            Session::flash('error', $this->Error );
            return \Redirect::back();
        }
    }

    //Assign Menu Function
    public function edit($id)
    {
        $id= base64_decode($id);
        $arr_data = [];
        $data     = $this->base_model->where(['assign_menu_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
        $state             = $this->base_state->get();
        $menu              = $this->base_menu->get();
        $data['data']      = $arr_data;
        $data['state']     = $state;
        $data['menu']      = $menu;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    //Assign Menu update function
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'state_id' => 'required',
                'city_id' => 'required',
                'area_id' => 'required',
              
        ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        

        $menu_id_data = implode(",",$request->input('menu'));

        $arr_data                          = [];
        $arr_data['state_id']  = $request->input('state_id');
        $arr_data['city_id']   = $request->input('city_id');
        $arr_data['area_id']   = $request->input('area_id');
        $arr_data['menu_id']   = $menu_id_data;
        $assign_location_menu_update = $this->base_model->where(['assign_menu_id'=>$id])->update($arr_data);
        
        Session::flash('success', $this->Update );
        return \Redirect::to('admin/manage_assign_location_menu');        
    }

    //Assign Menu delete function
    public function delete($id)
    {
        $id = base64_decode($id);
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['assign_menu_id'=>$id])->update($arr_data);
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
        $this->base_model->where(['assign_menu_id'=>$id])->update($arr_data);
        //return \Redirect::back();
    }

    //view assign menu 
    public function detail(Request $request)
    {
        $id = $request->input('assign_menu_id');
        //$data           = $this->base_model->where(['assign_menu_id'=>$id])->first();
      
         $data     = \DB::table('nutri_mst_assign_location_menu')
                     ->join('state','nutri_mst_assign_location_menu.state_id','=','state.id')
                     ->join('city','nutri_mst_assign_location_menu.city_id','=','city.id')
                     ->join('locations','nutri_mst_assign_location_menu.area_id','=','locations.id')
                     ->select('state.name as state_name','city.city_name','locations.area as area_name','nutri_mst_assign_location_menu.*')
                     ->where('nutri_mst_assign_location_menu.assign_menu_id','=',$id)
                     ->first();

        $menu_id    = explode(',',$data->menu_id);
        $html='<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Location wise assign menu</h4>
            <hr/>
            <div class="row">
              <div class="col-md-4"><h5 class="modal-title"><b>State Name: </b>'.ucfirst($data->state_name).'</h5></div>
              <div class="col-md-4"><h5 class="modal-title"><b>City Name: </b>'.ucfirst($data->city_name).'</h5></div>
              <div class="col-md-4"><h5 class="modal-title"><b>Area Name: </b>'.ucfirst($data->area_name).'</h5></div>
            </div>
            
         
           
          </div>
          <div class="modal-body">
            <table class="table table-bordered">
                <thead style="background-color: #ccb591;">
                   <tr>
                      <th>Sr.No</th>
                      <th>Menu</th>
                     <th>Menu Image</th>
                   </tr> 
                </thead>
                <tbody>';
                $i=1;
                foreach ($menu_id as $keys => $mvalue){
                    if($mvalue!=0){
                        $menu_data = $this->base_menu->where(['id'=>$mvalue])->first();
                        $html .="<tr>";
                    
                        $html .="<td>".$i."</td>";
                        $html .="<td>".$menu_data['menu_title']."</td>";
                      

                        $html .="<td><img src=".url('/')."/uploads/menu/".$menu_data['image']." width='50px' height='50px'></td>";
                        $html .="<tr>";
                    }
                    $i++;
                }
        $html .='</tbody>
                        </table>';



         return $html;       

    } 

}
