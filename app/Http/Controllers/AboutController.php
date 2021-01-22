<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\AboutusModel;
use \Illuminate\Support\Str;

use Session;
use Sentinel;
use Validator;

class AboutController extends Controller
{
    public function __construct()
    {
       $this->AboutusModel = new AboutusModel();
    }
    
    public function index()
    {
        $data['seo_title'] = "About";
        $obj_data = $this->AboutusModel->where('id', 1)->first();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }   
        $data['arr_data'] = $arr_data;
        
        $how_we_work     = \DB::table('how_we_work')->orderBy('id','ASC')->get();
        if(!empty($how_we_work))
        {
            $how_we_work_data = $how_we_work->toArray();
        }
        $data['how_we_work']      = $how_we_work_data;

        $our_services     = \DB::table('our_services')->orderBy('id','ASC')->get();
        if(!empty($our_services))
        {
            $our_services_data = $our_services->toArray();
        }

        $data['our_services']      = $our_services_data;
        
        $our_chefs     = \DB::table('our_chefs')->orderBy('id','ASC')->get();
        if(!empty($our_chefs))
        {
            $our_chefs_data = $our_chefs->toArray();
        }
        $data['our_chefs']      = $our_chefs_data;
        
        /*Recent Data*/
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;

        return view('about',$data);
    }
}
