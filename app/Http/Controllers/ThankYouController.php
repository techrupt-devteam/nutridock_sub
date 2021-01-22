<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Sentinel;
use Session;
//use Cookie;
use DB;
use Validator;



class ThankYouController extends Controller
{
    function __construct()
    {   
        $this->arr_view_data                = [];
        $this->module_title                 = "Thank You";
        $this->product_image_base_path      = base_path().'/uploads/images/';
        $this->product_image_public_path    = url('/').config('app.project.img_path.images');
    
    }
    public function index()
    {
        $data['seo_title'] = "Thank You";   
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
        return view('thank_you',$data);
    }

}
