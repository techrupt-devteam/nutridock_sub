<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\BlogModel;
use App\Models\CommentModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Support\Str;


use Sentinel;
use Session;
//use Cookie;
use DB;
use Validator;

class BlogDetailController extends Controller
{
    function __construct()
    {   
        $this->arr_view_data                = [];
        $this->module_title                 = "Product";
        $this->module_view_folder           = "admin";
        $this->product_image_base_path      = base_path().'/uploads/images/';
        $this->product_image_public_path    = url('/').config('app.project.img_path.images');
        $this->BlogModel                    = new BlogModel();
        $this->CommentModel                 = new CommentModel();
    }


    public function index($id)
    {
         return view('blogd/'.$id);
    }

   
}
