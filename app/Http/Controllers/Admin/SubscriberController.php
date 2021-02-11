<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\city;
use App\Models\Plan;
use Session;
use Sentinel;
use Validator;
use DB;
use Config;
class SubscriberController extends Controller
{
    public function __construct(State $State,City $City)
    {
        $data                = [];
        //$this->base_model    = $Subscription; 
        $this->base_State    = $State; 
        $this->base_city     = $City; 
        $this->title         = "Subscriber";
        $this->url_slug      = "subscriber";
        $this->folder_path   = "admin/subscriber/";
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
        $data     = \DB::table('subscriber_dtl')
                    ->join('subscriber','subscriber_dtl.subscriber_id','=','subscriber.id')
                    ->join('city','subscriber_dtl.city','=','city.id')
                    ->join('state','subscriber_dtl.state','=','state.id')
                    ->where('subscriber_dtl.is_deleted','=','NO')
                    ->select('subscriber_dtl.*','city.city_name','state.name as state_name','subscriber.email','subscriber.mobile')
                    ->orderBy('subscriber_dtl.sub_plan_id', 'DESC')
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
    
    
    public function getSubscriberData(Request $request)
    {
        
        $columns = array( 
                            0 =>'id', 
                            1 =>'Name',
                            2=> 'Email',
                            3=> 'Mobile',
                            4=> 'Action',
                        );
        $data     = \DB::table('subscriber_dtl')
                    ->join('subscriber','subscriber_dtl.subscriber_id','=','subscriber.id')
                    ->join('city','subscriber_dtl.city','=','city.id')
                    ->join('state','subscriber_dtl.state','=','state.id')
                    ->where('subscriber_dtl.is_deleted','<>',1)
                    ->select('subscriber_dtl.*','city.city_name','state.name as state_name','subscriber.email','subscriber.mobile')
                    ->orderBy('subscriber_dtl.sub_plan_id', 'DESC')
                    ->get();
        
  
        $totalData = count($data);
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {       
            $get_tbl_data  = \DB::table('subscriber_dtl')
                    ->join('subscriber','subscriber_dtl.subscriber_id','=','subscriber.id')
                    ->join('city','subscriber_dtl.city','=','city.id')
                    ->join('state','subscriber_dtl.state','=','state.id')
                    ->where('subscriber_dtl.is_deleted','<>',1)
                    ->select('subscriber_dtl.*','city.city_name','state.name as state_name','subscriber.email','subscriber.mobile')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();   

        }
        else {
            $search = $request->input('search.value'); 

                 $get_tbl_data  = \DB::table('subscriber_dtl')
                    ->join('subscriber','subscriber_dtl.subscriber_id','=','subscriber.id')
                    ->join('city','subscriber_dtl.city','=','city.id')
                    ->join('state','subscriber_dtl.state','=','state.id')
                    ->where('subscriber_dtl.is_deleted','<>',1)                    ->where('subscriber_dtl.id','LIKE',"%{$search}%")
                    ->orWhere('subscriber_dtl.subscriber_name', 'LIKE',"%{$search}%")
                    ->select('subscriber_dtl.*','city.city_name','state.name as state_name','subscriber.email','subscriber.mobile')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            /*$totalFiltered = value::where('id','LIKE',"%{$search}%")
                             ->orWhere('title', 'LIKE',"%{$search}%")
                             ->count();*/
        }

        $data = array();
        if(!empty($get_tbl_data))
        {
            $cnt = 1;
            foreach ($get_tbl_data as $key => $value)
            {
                //$show =  route('values.show',$value->id);
                //$edit =  route('values.edit',$value->id);

                $nestedData['id'] = $value->id;
                $nestedData['name'] = $value->subscriber_name;
                $nestedData['email'] = $value->email;
                $nestedData['mobile'] = $value->mobile;
                if($value->is_approve=='1'){
                     $status="Verified <i class='fa fa-check-circle'></i>"; $style="success"; 
                }else{
                    $status="Pending <i class='fa fa-times-circle'></i>"; $style="danger";}     

                   
                  $nestedData['action'] = "<button type='button' class='btn btn-warning btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails(".$value->id.")><i class='fa fa-info-circle'></i> View Details</button>
                      <button type='button' value=".$value->is_approve." class='btn btn-sm btn-".$style." verifybtn' >".$status."</button>";



                $data[] = $nestedData;
                $cnt++;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
        
    }


  

   

    public function detail(Request $request)
    {
        $plan_id = $request->input('plan_id');

        $plan_details     = \DB::table('subscriber_dtl')
                           
                            ->join('city','nutri_mst_subscription_plan.city','=','city.id')
                            ->join('locations','nutri_mst_subscription_plan.area','=','locations.id')
                            ->where('nutri_mst_subscription_plan.sub_plan_id','=',$plan_id)
                            ->select('nutri_mst_subscription_plan.*','city.city_name','locations.area as area_name')
                            ->orderBy('nutri_mst_subscription_plan.sub_plan_id', 'DESC')->first();
        //$plan_details = $this->base_model->where(['sub_plan_id'=>$plan_id])->first();


        $subscription_duration    = \DB::table('nutri_dtl_subscription_duration')->where(['sub_plan_id'=>$plan_id])->orderBy('duration_id', 'ASC')->get();
        $html='<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b>Subscription Plan :</b> '.ucfirst($plan_details->sub_name).' </h4>
                <hr/>
                <div class="row">
              
                  <div class="col-md-4"><h5 class="modal-title"><b>City: </b>'.ucfirst($plan_details->city_name).'</h5></div>
                  <div class="col-md-4"><h5 class="modal-title"></h5></div>
                  <div class="col-md-4"><h5 class="modal-title"><b>Area: </b>'.ucfirst($plan_details->area_name).'</h5></div>
                   
                </div>
                
             
               
              </div>
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

   

    public function verify_subscriber(Request $request)
    {

      /*  $status  = $request->status;
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
        //return \Redirect::back();*/
    }
}
