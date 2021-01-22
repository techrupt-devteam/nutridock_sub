<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogModel;


class FeaturesController extends Controller
{
   
    function __construct()
    {   
        $this->BlogModel                    = new BlogModel();
    }

    public function index()
    {
        $obj_data = $this->BlogModel->get();

        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }
        $data['arr_data']      = $arr_data;
        return view('features',$data);
    }
}
