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

class LandingController extends Controller
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

	public function store_survey(Request $request)
	{
	    
		$arr_rules      = $arr_data = array();
		

		$arr_rules['_token']				= "required";
		$arr_rules['download_app']      	   		= "required";
		//$arr_rules['blog_description']      	   	= "required";

		$validator = validator::make($request->all(),$arr_rules);

		if($validator->fails()) 
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}
	    
        $refrains = $request->input('refrains');
        $comments = $request->input('comments');
       
        if($refrains){
        	$arr_data['download_app']	=	$request->input('download_app', null);	
    		$arr_data['comments']		=	'';
    		$arr_data['refrains']		=	$request->input('refrains');
        }else{
            $arr_data['download_app']	=	$request->input('download_app', null);	
    		$arr_data['comments']		=	$request->input('comments');
    		$arr_data['refrains'] =	'';
        }
	
		
		$status = $this->SurveyModel->create($arr_data);
		if($status)
		{
			Session::flash('success', 'Thank you for your feedback.');
			
			//return redirect('/landing');
			return redirect()->back();
		}
		//Session::flash('error', 'Something went wrong.');
		return redirect('/landing');
	}



	public function store_subscription(Request $request)
	{
		$arr_rules      = $arr_data = array();
		$status         = false;

		$arr_rules['_token']	= "required";
		$arr_rules['email']     = "required";
		//$arr_rules['blog_description']      	   	= "required";

		$validator = validator::make($request->all(),$arr_rules);

		if($validator->fails()) 
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}
		//$name = $request->input('name', null);

		$arr_data['email']	=	$request->input('email', null);	
			
		
		$status = $this->SubscriptionModel->create($arr_data);
		if($status)
		{
			$to = $status->email;
            $subject = 'Nutridock';
            $headers = "From: marketing@nutridock.com\r\n";
            $headers .= "Reply-To: marketing@nutridock.com\r\n";
            $headers .= "CC: it@sevagroup.co.in\r\n";
        
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Receipt</title>
				</head>
				<body>
					<span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Hello,</strong><br><br>Thanks for connecting with us.We will get back to you soon.<br><br>Thanks & Regards <br>Nutridock<br></span></span><br />
                <br />
				</body>
				</html>';
			if(mail($to, $subject, $message, $headers)){
			    
			 $message2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title>Receipt</title>
				</head>
				<body>
					<span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Hello Admin,</strong><br><br>New subscription from '.$to.'.<br><br>Thanks</span></span><br />
                <br />
				</body>
				</html>';
                mail ('marketing@nutridock.com',"Nutridock - New subscription received",$message2,$headers);
                
				Session::flash('subscription_success', 'Subscribed successfully.');
				return redirect()->back();
			}
		}
		//Session::flash('error', 'Something went wrong.');
		return redirect('/landing');
	}
	



	
}