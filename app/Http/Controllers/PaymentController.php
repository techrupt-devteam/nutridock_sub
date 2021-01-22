<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\WebinarModel;

/*use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;*/

/*use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;*/
use App\Mail\SendOrderMail;
use Session;
use Sentinel;
use Validator;
use Cookie;
use DB;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->product_image_base_path      = base_path().config('app.project.img_path.popart_image');
        $this->product_image_public_path    = url('/').config('app.project.img_path.popart_image');
        $this->WebinarModel = new WebinarModel();
    }

    public function index(Request $request)
    {

        
        $arr_rules      = $arr_data = array();
        //$status         = false;

        $arr_rules['_token']                = "required";
        $arr_rules['name']                 = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $arr_data['name']              =   $request->input('name', null); 
        $arr_data['email']        =   $request->input('email', null); 
        $arr_data['mobile']              =   $request->input('mobile', null); 
        $arr_data['city']        =   $request->input('city', null); 
        $arr_data['age']              =   $request->input('age', null); 
        $arr_data['amount']              =   150;
        $arr_data['webinar_date']   =   date('m-d-Y');  
       // print_r($arr_data); die;
        
        $data['status'] = $this->WebinarModel->create($arr_data);
        $id = $data['status']->id;
        //print_r($data['status']->id); die;
        return view('/payment',$data);
        //return view('capture_payment',$data);
    }

     public function capture_payment(Request $request)
    {
        $arr_rules      = $arr_data = array();
        $arr_rules['_token']                = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $arr_data['razorpay_payment_id']              =   $request->input('razorpay_payment_id'); 
        $arr_data['token_id']        =   $request->input('token_id'); 
        /*$arr_data['mobile']              =   $request->input('mobile_value'); 
        $arr_data['city']        =   $request->input('city_value'); */
        
        $obj_data['status'] = $this->WebinarModel->where('id', $arr_data['token_id'])->first();
        
        $id=$obj_data['status']->id;
        if($obj_data['status']->amount)
       {
        $amount = $obj_data['status']->amount;
        date_default_timezone_set("Asia/Kolkata");
        try 
        {
            //$api      = new Api('rzp_live_HDyxMBFfluOpXG', '6oeLbnEpxjB1nfRvGrVAsg41');
            $api      = new Api('rzp_test_P1IkeYutI76ExB', 'zauEEmSFCAb27S45LwrPNpYe');
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'))->capture(array('amount'=>$amount*100));
            $payment  = $api->payment->fetch($request->input('razorpay_payment_id'));
        }
        catch(Exception $e) 
        {
            header("Location: https://nutridock.com/failed");
            exit();
        }
        if($payment->status=="captured")
        {

            \DB::table('webinar')->where(['id'=>$id])->update(['payment_status'=>'Paid','webinar_date'=>date('Y-m-d h:i:s'),'transaction_id'=>$request->input('razorpay_payment_id')]);
            $to = $obj_data['status']->email;
            
            $zoom_link = "https://us04web.zoom.us/postattendee?id=1";
            
            $subject = 'Nutridock - Webinar';
            $headers = "From: pagarelaxmi@gmail.com\r\n";
            $headers .= "Reply-To: pagarelaxmi@gmail.com\r\n";
            //$headers .= "CC: it@sevagroup.co.in\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Nutridock - Webinar</title>
                </head>
                <span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif">
                <strong>Hi,</strong><br><br>
                Thank you for subscribing to this webinar. We are very pleased to have you on board. The webinar will get started at <b>5 pm on 12th September 2020.</b> <br><br>
                Well, we all agree that Good Food constitutes a Good Mood. Hence, we are here to educate you on how nutritious food can benefit your mood by supporting healthy communication in the brain, and reducing chronic inflammation. And ultimately, help you fight the daily stress. <br><br>

                <b>What you can expect in the webinar: </b><br>
                1. How the lack of nutrition affects our mental health ? <br> 
                2. Easy diets and daily habits.<br>
                3. Nutritional intake and its domination over depression.<br>
                4. The deafening claws of stress.<br>
                5. Practical tips on how to overcome stress, & much more…<br><br>

                <b>CLICK HERE TO JOIN </b><br><br>

                Note: This link is unique to you and should not be shared with others in all proximity.<br><br> 
             
                You can join from a PC, Mac, iPad, iPhone or any other Android device, according to your convenience. <br><br>
             
                <b>Kindly remember a few things:</b><br>
                 1. Join 10-min in advance so that you do not miss on anything.<br> 
                 2. Use the chat feature, if you would like to ask any question.<br>
                 3. Close all the other tabs and set all your other devices aside, as we would like to have all of your attention for a better experience. <br><br>
             
                We hope you have a pleasant and knowledgeable experience with our experts following with 15-min live questions and answers round. <br><br>
             
                If you have any queries, kindly do not hesitate to reach out to us. <br><br>

                Thanks once again, and we cannot wait to see you at the webinar.<br><br> 
             
                
                <br><br>Regards,  <br>Team NutriDock<br></span></span><br /><br />
                            </html>';

            mail($to, $subject, $message, $headers);


            $message2='<html>';
            $message2.='<body aria-readonly="false" style="cursor: auto;"><span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Dear Admin,</strong></span></span><br />
            <br />';
            $message2.='<span style="font-size:12px"><strong><span style="font-family:arial,helvetica,sans-serif">You have received a new registration. Customer details are as follows:</span></strong></span><br />
            &nbsp;';
            $message2.='<table border="0" cellpadding="2" cellspacing="2" style="width:500px;background-color:#D3D3D3">
                <tbody>';
                $message2.='<table border="0" cellpadding="2" cellspacing="2" style="width:400px;background-color:#D3D3D3" align="center">
                <tbody><tr><td>';
                    $message2.='<tr>
                        <td colspan="2><span style="color:#000000"><center><span style="font-size:14px"><strong><span>Customer Details</span></strong></span></span></center></td>
                    </tr>';
                     $message2.='<tr>
                        <td style="width: 153px;">&nbsp;</td>
                        <td style="width: 234px;">&nbsp;</td>
                    </tr>';
                    $message2.='<tr>
                        <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Customer Name :</span></strong></span></span></td>
                        <td style="width: 234px;"><span style="color:#000000"><span>'.$obj_data['status']->name.'</span></span></td>
                    </tr>';
                    $message2.='<tr>
                        <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Contact No :</span></strong></span></span></td>
                        <td style="width: 234px;"><span style="color:#000000"><span>'.$obj_data['status']->mobile.'</span></span></td>
                    </tr>';
                    $message2.='<tr>
                        <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Email ID :</span></strong></span></span></td>
                        <td style="width: 234px;"><span style="color:#000000"><span>'.$to.'</span></span></td>
                    </tr>';
                    
                    $message2.='<tr>
                        <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>City :</span></strong></span></span></td>
                        <td style="width: 234px;"><span style="color:#000000"><span>'.$obj_data['status']->city.'</span></span></td>
                    </tr>';
                    $message2.='<tr>
                        <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>State :</span></strong></span></span></td>
                        <td style="width: 234px;"><span style="color:#000000"><span>'.$obj_data['status']->age.'</span></span></td>
                    </tr>';
                    $message2.='<tr>
                        <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Address:</span></strong></span></span></td>
                        <td style="width: 234px;"><span style="color:#000000"><span>'.$obj_data['status']->amount.'/-</span></span></td>
                    </tr>';
                     
                    $message2.='<tr>
                        <td style="width: 153px;">&nbsp;</td>
                        <td style="width: 234px;">&nbsp;</td>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    </tr>
                </tbody>
            </table><br />';
            $message2.='<span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Thanks </strong></span></span></body>
            </html>';

            mail ('pagarelaxmi@gmail.com',"Nutridock Webinar - New registration received",$message2,$headers);
            
            Session::flash('payment_success', 'Congratulations !!!!!! You have registered successfully.');
            return redirect('');
            //return redirect()->back();
        }
        else
        {
          return view('failed');
          exit();
        }


       }
       else
        {
          return view('failed');
          exit();
        }
    
    }

    public function success()
    {
        return view('success');
    }

    public function failed()
    {
        return view('failed');
    }

}
