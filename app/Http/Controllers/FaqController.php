<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\FaqModel;

use Session;
use Sentinel;
use Validator;

class FaqController extends Controller
{
    public function __construct()
    {
       $this->FaqModel = new FaqModel();
    }
    
    public function index()
    {
        $data['seo_title'] = "FAQ";
        $obj_data = $this->FaqModel->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }   
        $data['arr_data'] = $arr_data;

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


        return view('faq',$data)->with('no', 1);
    }
}
