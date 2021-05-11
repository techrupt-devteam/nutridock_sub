<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\Location;
use App\Models\City;
use App\Models\Plan;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
class SubscriptionController extends Controller
{
    public function __construct(SubscriptionPlan $Subscription,Location $Location,City $City,Plan $Plan)
    {
        $data                = [];
        $this->base_model    = $Subscription; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_plan     = $Plan; 
        $this->title         = "Subscription Plan";
        $this->url_slug      = "subscription_plan";
        $this->folder_path   = "admin/subscription_plan/";
                //Message
        $this->Insert = Config::get('constants.messages.Insert');
        $this->Update = Config::get('constants.messages.Update');
        $this->Delete = Config::get('constants.messages.Delete');
        $this->Error = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');
    }

    public function index()
    {
        $arr_data          = [];
        $city = Session::get('login_city_id');
        if($city!="all")
        {

            $data   = \DB::table('nutri_mst_subscription_plan')
                     //->join('nutri_mst_plan','nutri_mst_subscription_plan.plan_id','=','nutri_mst_plan.plan_id')
                    ->join('city','nutri_mst_subscription_plan.city','=','city.id')
                    ->join('locations','nutri_mst_subscription_plan.area','=','locations.id')
                    ->where('nutri_mst_subscription_plan.city','=',$city);
        }
        else
        {
             $data  = \DB::table('nutri_mst_subscription_plan')
                        //->join('nutri_mst_plan','nutri_mst_subscription_plan.plan_id','=','nutri_mst_plan.plan_id')
                        ->join('city','nutri_mst_subscription_plan.city','=','city.id')
                        ->join('locations','nutri_mst_subscription_plan.area','=','locations.id');
        }

           $data = $data ->where('nutri_mst_subscription_plan.is_deleted','<>','1')
                    ->select('nutri_mst_subscription_plan.*','city.city_name','locations.area as area_name')
                    ->orderBy('nutri_mst_subscription_plan.sub_plan_id', 'DESC')->get();
        //
        $area              = $this->base_location->select('id')->get()->toArray();
        $area_data         = [];
        foreach ($area as $key => $value) {
           $area_data [] = $value;   
        }

        if(!empty($data))
        {
            $arr_data      = $data->toArray();
        }
      
        $data['data']      = $arr_data;
        $data['area']      = $area_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
       // dd($data);
        return view($this->folder_path.'index',$data);
    }
 
    public function add()
    {
        $city              = $this->base_city->get();
        $plan              = $this->base_plan->where('is_active','=','1')->get();
        $data['page_name'] = "Add";
        $data['city']      =  $city;
        $data['plan']      =  $plan;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'sub_name' => 'required',
                //'plan_id' => 'required',
                'city' => 'required',
               // 'area' => 'required',
          
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
       /* $is_exist = $this->base_model->where(['sub_name'=>$request->input('sub_name')])->count();

        if($is_exist)
        {
            Session::flash('error', "Subscription Plan already exist!");
            return \Redirect::back();
        }*/

        $icon_img              = Input::file('icon_image');
        //random number genrate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';   
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        

        $arr_data                = [];
        $arr_data['sub_name']    = $request->input('sub_name');
        //$arr_data['plan_id']     = $request->input('plan_id');
        $arr_data['city']        = $request->input('city');
        $arr_data['area']        = implode(',',$request->input('area'));
        $arr_data['plan_description'] = $request->input('plan_description');
        $arr_data['icon_image'] = $randomString."".$icon_img->getClientOriginalName();
        $plan = $this->base_model->create($arr_data);
      
        if(!empty($plan))
        {

            //upload icon 
                $destinationPath = 'uploads/subscription_icon/';
                $destinationPathThumb = $destinationPath . 'thumb/';
                $filename_icon = $icon_img->getClientOriginalName();
                $original_icon = $icon_img->move($destinationPath, $randomString."".$filename_icon);

                //thumbnail create icon
                $icon_thumb = Image::make($original_icon->getRealPath())
                ->resize(100, 100)
                ->save($destinationPathThumb . $randomString."".$filename_icon);
            //
            $failed = 0;  
            $duration_flag = $request->input('duration_flag');
            for($d=1; $d <= $duration_flag; $d++) 
            { 
                if(!empty($request->input('duration'.$d))){
                  $arr_data1                     = [];
                  $arr_data1['duration']         = ucfirst($request->input('duration'.$d));
                  $arr_data1['sub_plan_id']      = $plan->sub_plan_id;
                  $arr_data1['discount_price']   = $request->input('discount_price'.$d);
                  
                  if($request->input('price_type'.$d)=='meal'){
                    $arr_data1['price_per_meal'] = $request->input('price'.$d);
                  }
                  else
                  {
                    $arr_data1['price_per_pack'] = $request->input('price'.$d);
                  }  

                  $subscription_duration  = \DB::table('nutri_dtl_subscription_duration')->insert($arr_data1); 
                  if($subscription_duration)
                  {
                    $failed = 0;
                  }else
                  {
                    $failed++;
                  }
                }
            }
          }
        
        
        if($failed==0){
            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_subscription_plan');
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
        $data     = $this->base_model->where(['sub_plan_id'=>$id])->first();
        $city     = $this->base_city->get();
        $plan     = $this->base_plan->where('is_active','=','1')->get();
        $subscription_duration    = \DB::table('nutri_dtl_subscription_duration')->where(['sub_plan_id'=>$id])->orderBy('duration_id', 'ASC')->get();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
        $data['data']      = $arr_data;
        $data['city']      =  $city;
        $data['plan']      =  $plan;
        $data['duration']  =  $subscription_duration;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        // dd($request->plan_description);
        $validator = Validator::make($request->all(), [
                'sub_name'         => 'required',
                //'plan_id' => 'required',
                'city'             => 'required',
               // 'area'             => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        

        $icon_img              = Input::file('icon_image');
        //random number generate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';   
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        $arr_data               = [];
        $arr_data['sub_name']         = $request->input('sub_name');
        //$arr_data['plan_id']        = $request->input('plan_id');
        $arr_data['city']             = $request->input('city');
        $arr_data['area']             = implode(',',$request->input('area'));
        $arr_data['plan_description'] = $request->input('plan_description');
        
        if(isset($_FILES['icon_image']["name"]) && !empty($_FILES['icon_image']["name"]))
        { 
            $arr_data['icon_image'] = $randomString."".$icon_img->getClientOriginalName();
        }
        else
        {
            $arr_data['icon_image'] = $request->input('old_icon_image');
        }

        $module_update = $this->base_model->where(['sub_plan_id'=>$id])->update($arr_data);

        $destinationPath = 'uploads/subscription_icon/';
        $destinationPathThumb = $destinationPath . 'thumb/';

        if(isset($_FILES['icon_image']["name"]) && !empty($_FILES['icon_image']["name"]))
        {
          
            $filename_icon = $icon_img->getClientOriginalName();
            $original_icon = $icon_img->move($destinationPath, $randomString."".$filename_icon);
                
            //thumbnail create icon
            $icon_thumb = Image::make($original_icon->getRealPath())
            ->resize(255, 250)
            ->save($destinationPathThumb . $randomString."".$filename_icon);
            
            unlink($destinationPath."".$request->input('old_icon_image'));
            unlink($destinationPathThumb."".$request->input('old_icon_image'));

        }

       // $old_duration_delete  = \DB::table('nutri_dtl_subscription_duration')->where(['sub_plan_id'=>$id])->delete(); duration_id

         $failed = 0;  
            $duration_flag = $request->input('duration_flag');
            for($d=1; $d <= $duration_flag; $d++) 
            { 
                if(!empty($request->input('duration'.$d))){
                  $arr_data1                     = [];
                  $arr_data1['duration']         = ucfirst($request->input('duration'.$d));
                  $arr_data1['sub_plan_id']      = $id;
                  $arr_data1['discount_price']   = $request->input('discount_price'.$d);
                  
                  if($request->input('price_type'.$d)=='meal'){
                    $arr_data1['price_per_meal'] = $request->input('price'.$d);
                  }
                  else
                  {
                    $arr_data1['price_per_pack'] = $request->input('price'.$d);
                  }  
                  
                  if($request->input('duration_id'.$d))
                  {
                     $subscription_duration = \DB::table('nutri_dtl_subscription_duration')->where('duration_id','=',$request->input('duration_id'.$d))->update($arr_data1);

                    $failed = 0;
                  }
                  else
                  {
                    $subscription_duration1  = \DB::table('nutri_dtl_subscription_duration')->insert($arr_data1); 
                    if($subscription_duration1)
                    {
                        $failed = 0;
                    }else
                    {
                      $failed++;
                    }
                  }

                 
                }
            }


        if($failed==0){
            Session::flash('success', $this->Update);
            return \Redirect::to('admin/manage_subscription_plan');
        }
        else
        {
            Session::flash('error', $this->Error);
            return \Redirect::back();
        }
    }

    public function detail(Request $request)
    {
        $plan_id = $request->input('plan_id');

        $plan_details     = \DB::table('nutri_mst_subscription_plan')
                           
                            ->join('city','nutri_mst_subscription_plan.city','=','city.id')
                            //->join('locations','nutri_mst_subscription_plan.area','=','locations.id')
                            ->where('nutri_mst_subscription_plan.sub_plan_id','=',$plan_id)
                            ->select('nutri_mst_subscription_plan.*','city.city_name')
                            ->orderBy('nutri_mst_subscription_plan.sub_plan_id', 'DESC')->first();
        //$plan_details = $this->base_model->where(['sub_plan_id'=>$plan_id])->first();
        $subscription_duration    = \DB::table('nutri_dtl_subscription_duration')->where(['sub_plan_id'=>$plan_id])->orderBy('duration_id', 'ASC')->get();

        $location_data = $this->base_location->where(['city'=>$plan_details->city])->get();
        

           
              
    
        $html='<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Subscription Plan :</b> '.ucfirst($plan_details->sub_name).' </h4>
                <hr/>
                <div class="row">
              
                  <div class="col-md-4"><h5 class="modal-title"><b>City: </b>'.ucfirst($plan_details->city_name).'</h5></div>
                  <div class="col-md-4"><h5 class="modal-title"></h5></div> 
                  <div class="col-md-4"><h5 class="modal-title"></h5></div>
                  <div class="col-md-12"><h5 class="modal-title"><b>Area: </b>';
                foreach ($location_data as $key => $value1) 
                { 
                  
                  if(in_array($value1->id,explode(",",$plan_details->area))){  
                   $area_name = $value1->area; 
                    $html.= $area_name." | ";
                  }
                }          
               
               $html.='</h5></div></div> </div>
              <div class="modal-body">
                <table class="table table-bordered">
                    <thead style="background-color: #ccb591;">
                       <tr>
                         <th>Sr.No</th>
                         <th>Duration</th>
                         <th>Meal Plan</th>
                         <th>Price</th>
                         <th>Discount Price</th>
                       </tr> 
                    </thead>
                    <tbody>';
         $i=1;           
        foreach ($subscription_duration as $value) 
        {   
            $type ="";
            $price = "";
            if(!empty($value->price_per_meal))
            {
                $type = "Per Meal";
                $price =  $value->price_per_meal;
            }                  
            if(!empty($value->price_per_pack))
            {
                $type = "Per Pack"; 
                $price = $value->price_per_pack;
            }
                                               
            $html.= '<tr>
                        <td>'.$i.' </td>
                        <td>'.$value->duration.' Days</td>
                        <td>'.$type.'</td>
                        <td> <i class="fa fa-rupee"></i> '.number_format($price,2).'</td>  
                        <td> <i class="fa fa-rupee"></i> '.number_format($value->discount_price,2).'</td>  
                    </tr>';               
        $i++;
        }     

        $html.='</tbody>
                </table>
                </div>
            <div class="modal-footer">
              
            </div>';
              return $html;
    } 

    public function delete($id)
    {
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['sub_plan_id'=>$id])->update($arr_data);
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
        $this->base_model->where(['sub_plan_id'=>$plan_id])->update($arr_data);
        //return \Redirect::back();
    }
     public function status_duration(Request $request)
    {

        $status                   =  $request->status;
        $duration_id              =  $request->durations_id;
        $check_day_assign_cnt     =  \DB::table('nutri_dtl_subscriber')->where('duration_id','=',$duration_id)->where('expiry_date','>=',date('Y-m-d'))->get()->count(); 

        if($check_day_assign_cnt == 0)
        { 
            $arr_data                =  [];
            if($status=="true")
            {
             $arr_data['is_active']   =  '1';
            }
            if($status=="false")
            {
             $arr_data['is_active']   =  '0';
            }   
            $dur_status = \DB::table('nutri_dtl_subscription_duration')->where(['duration_id'=>$duration_id])->update($arr_data);
            
            $message = "success";
        }
        else
        {
             $message = "failed";
        }    
        return $message;
    }
}
