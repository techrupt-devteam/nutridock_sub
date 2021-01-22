<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Support\Str;
use Illuminate\Support\Arr;



use App\Models\SubscribeNowPlan;
use App\Models\MealType;

use Session;
use Sentinel;

use DB;
use Validator;
use URL;
use Mail;

class SubscribeinfoController extends Controller
{
    public function __construct()
    {
       //$this->AboutusModel = new AboutusModel();
    }
    
    public function index()
    {
        $data['seo_title'] = "Subscribe Info";
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
        
        Arr::set($data, 'getSubscribeNowPlan', SubscribeNowPlan::getData());
        //print_r($data); die;
        Arr::set($data, 'getMealTypeData', MealType::getData());
        return view('subscribe-info')->with(['data' => $data,'recent_data' => $recent_data, 'seo_title' => "Subscribe Now"]); 
    }
}
