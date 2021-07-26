<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Location;
use App\Models\City;
use App\Models\Role;
use App\Models\State;
use App\Models\SubscriberDetails;
//use Session;
use Sentinel;
use Validator;
use DB;
class AjaxController extends Controller
{
    public function __construct(User $User,Location $Location,City $City,Role $Role,State $State,SubscriberDetails $SubscriberDetails)
    {
        $data                              = [];
        $this->base_model                  = $User; 
        $this->base_location               = $Location; 
        $this->base_city                   = $City; 
        $this->base_subscriber_details     = $SubscriberDetails; 
        $this->base_state                  = $State; 
        $this->base_role                   = $Role;  
    }

    public function getCity(Request $request)
    {
        $state_id = $request->state;
       
        $get_city = $this->base_city->where(['state_id'=>$state_id])->get();

        $html = "";
        $html = "<option value=''>-Select-</option>";
        foreach ($get_city as $key => $value) 
        {

        if(!empty($request->city) && $request->city == $value->id) 
             $html.="<option value=".$value->id." selected>".$value->city_name."</option>";     
         else
         $html.="<option value=".$value->id.">".$value->city_name."</option>";     
        }                
        return $html;
        
    }


    public function getArea(Request $request)
    {//dd($request);
        $city_id = $request->city;
        $location_data = $this->base_location->where(['city'=>$city_id])->where('is_active','=',1)->get();
        $html = "";
        $html .= "<option value=''>-Select-</option>";
        foreach ($location_data as $key => $value) 
        {

        if(!empty($request->area) && $request->area == $value->id) 
             $html.="<option value=".$value->id." selected>".$value->area.''.(!empty($value->pincode)?"-".$value->pincode:"")."</option>";     
         else  
          $html.="<option value=".$value->id.">".$value->area.''.(!empty($value->pincode)?"-".$value->pincode:"")."</option>";                
        }         

        return $html;
    } 

    public function getAreamultiarea(Request $request)
    {   
        //dd($request);
        $city_id = $request->city;
        $location_data = $this->base_location->where(['city'=>$city_id])->where('is_active','=',1)->get();
        $html = "";
        $html .= "<option value=''>-Select-</option>";
        foreach ($location_data as $key => $value) 
        {

         if(in_array($value->id,explode(",",$request->area))) 
             $html.="<option value=".$value->id." selected>".$value->area.''.(!empty($value->pincode)?"-".$value->pincode:"")."</option>";     
         else  
          $html.="<option value=".$value->id.">".$value->area.''.(!empty($value->pincode)?"-".$value->pincode:"")."</option>";                
        }         

        return $html;
    } 

    public function get_city_list(Request $request)
    {
        dd($request);
        $user_name = $request->email;
        
        $user      = $this->base_model->where(['email'=>$request->email]); 

        $get_city  = $this->base_city->get();
        $html      = "";
        foreach ($get_city as $key => $value) 
        {
            $html.="<option value=".$value->id.">".$value->city_name."</option>";     
        }
        return $html;
    }

    public function getSubscriber(Request $request)
    {
        //$state_id = $request->state;
        //$city_id  = $request->city;
        $skitchen_id = $request->kitchen_id;
     /*   $get_subscriber = $this->base_subscriber_details->where(['state'=>$state_id,'city'=>$city_id,'is_approve'=>'1'])->get(); */
     $get_subscriber = $this->base_subscriber_details->where(['skitchen_id'=>$skitchen_id,'is_approve'=>'1'])->get();

        $html = "";
        $html = "<option value=''>-Select-</option>";
        foreach ($get_subscriber as $key => $value) 
        {
             $date     = strtotime(date("Y-m-d"));
             $exp_date = strtotime($value->expiry_date);
             if($date > $exp_date)
             {

               $status = "expired";  
             }
             else
             {
               $status = "ongoing";  
             }

             $html.="<option value=".$value->id.">".$value->subscriber_name." (".$status.")</option>";     
        }                
        
        return $html;
    }

}
