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



class TermsConditionsController extends Controller
{
    
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
        return view('terms_conditions',$data);
    }

}
