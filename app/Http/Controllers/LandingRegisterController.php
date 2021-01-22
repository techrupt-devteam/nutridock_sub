<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\SurveyModel;
use App\Models\SubscriptionModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Sentinel;
use Session;
//use Cookie;
use DB;
use Validator;

class LandingRegisterController extends Controller
{
	function __construct()
	{  	
		$this->arr_view_data                = [];
		$this->module_title                 = "Product";
		$this->module_view_folder           = "admin";
		$this->product_image_base_path      = base_path().'/uploads/images/';
		$this->product_image_public_path 	= url('/').config('app.project.img_path.images');
	
		$this->SurveyModel					= new SurveyModel();
		$this->SubscriptionModel			= new SubscriptionModel();
	}

	
	public function user_register(Request $request)
	{
	     echo"1"; die;
	}
	

}