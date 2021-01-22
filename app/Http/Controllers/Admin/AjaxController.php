<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Nutritionsit;
use App\Models\Location;
use App\Models\city;
use App\Models\Role;
use App\Models\State;
use Session;
use Sentinel;
use Validator;
use DB;
class AjaxController extends Controller
{
    public function __construct(Nutritionsit $Nutritionsit,Location $Location,City $City,Role $Role,State $State)
    {
        $data                = [];
        $this->base_model    = $Nutritionsit; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->base_role     = $Role;  
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
    {
        $city_id = $request->city;
        $location_data = $this->base_location->where(['city'=>$city_id])->get();
        $html = "";
        $html = "<option value=''>-Select-</option>";
        foreach ($location_data as $key => $value) 
        {

        if(!empty($request->area) && $request->area == $value->id) 
             $html.="<option value=".$value->id." selected>".$value->area."</option>";     
         else  
          $html.="<option value=".$value->id.">".$value->area."</option>";                
        }                 
        return $html;
    }


}
