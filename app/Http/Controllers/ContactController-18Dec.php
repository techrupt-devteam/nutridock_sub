<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Models\ContactModel;
use App\Models\BlogModel;

use Session;
use Sentinel;
use Validator;

class ContactController extends Controller
{
    public function __construct()
    {
       $this->ContactModel = new ContactModel();
       $this->BlogModel    = new BlogModel();
    }
    
    public function index()
    {
        $data['seo_title'] = "Contact";
        $obj_data = $this->BlogModel->get();

        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }
        $data['arr_data']      = $arr_data;
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

        
        return view('contact',$data);
        
    }


    public function store(Request $request)
    {
        
        $arr_rules      = $arr_data = array();

        $arr_rules['_token']   = "required";
        $arr_rules['name']     = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $arr_data['name']         =   $request->input('name', null); 
        $arr_data['email']        =   $request->input('email', null); 
        $arr_data['subject']      =   $request->input('subject', null); 
        $arr_data['message']      =   $request->input('message', null); 
        
        $data['status'] = $this->ContactModel->create($arr_data);

        if($data['status']){
            
            $to = $request->input('email', null); 
            
            $subject = 'Nutridock';
            $headers = "From: admin@nutridock.com\r\n";//
            $headers .= "Reply-To: admin@nutridock.com\r\n";
            $headers .= "CC: info.nutridock@gmail.com\r\n";
            $headers .= "BCC: marketing@nutridock.com\r\n";
            $headers .= "BCC: it@sevagroup.co.in\r\n";
            $headers .= "BCC: urvashitikmani1310@gmail.com\r\n";
            $headers .= "BCC: geoshinsam@gmail.com\r\n";
            $headers .= "BCC: sales@nutridock.com\r\n";
            
           /* $headers = "From: pagarelaxmi@gmail.com\r\n";
            $headers .= "Reply-To: pagarelaxmi@gmail.com\r\n";
            $headers .= "CC: laxmipagare99@gmail.com\r\n";*/
        
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title>Receipt</title>
                </head>
                <body>
                    <span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Hello,'.$arr_data['name'].'</strong><br><br>Thanks for connecting with us.We will get back to you soon.<br><br>Thanks & Regards <br>Nutridock<br></span></span><br />
                <br />
                </body>
                </html>';
                 
            if(mail($to, $subject, $message, $headers)){
                
             $message2 = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title></title>
                </head>

                <body aria-readonly="false" style="cursor: auto;">
                    <span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Hello Admin,</strong></span></span><br />
                <br />
                <span style="font-size:12px"><strong><span style="font-family:arial,helvetica,sans-serif">Below are the details.</span></strong></span><br />
                &nbsp;
                <table border="0" cellpadding="2" cellspacing="2" style="width:500px;background-color:#D3D3D3">
                    <tbody>
                <table border="0" cellpadding="2" cellspacing="2" style="width:400px;background-color:#D3D3D3" align="center">
                    <tbody><tr><td>
                <tr>
                    <td colspan="2><span style="color:#000000"><center><span style="font-size:14px"><strong><span>Customer Details</span></strong></span></span></center></td>
                    </tr>
                <tr>
                            <td style="width: 153px;">&nbsp;</td>
                            <td style="width: 234px;">&nbsp;</td>
                        </tr>
                <tr>
                            <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Name :</span></strong></span></span></td>
                            <td style="width: 234px;"><span style="color:#000000"><span>'.$arr_data['name'].'</span></span></td>
                        </tr>
               
                <tr>
                            <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Email ID :</span></strong></span></span></td>
                            <td style="width: 234px;"><span style="color:#000000"><span>'.$arr_data['email'].'</span></span></td>
                        </tr>
                <tr>
                            <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Subject </span></strong></span></span></td>
                            <td style="width: 234px;"><span style="color:#000000"><span>'.$arr_data['subject'].'</span></span></td>
                        </tr>

                <tr>
                            <td style="width: 153px;"><span style="color:#000000"><span style="font-size:14px"><strong><span>Customer Message</span></strong></span></span></td>
                            <td style="width: 234px;"><span style="color:#000000"><span style="font-size:12px"><span style="font-family:arial,helvetica,sans-serif"><span>'.$arr_data['message'].'</span></span></span></span></td>
                        </tr>
                <tr>
                            <td style="width: 153px;">&nbsp;</td>
                            <td style="width: 234px;">&nbsp;</td>
                            </td>
                            </tr>
                        </tbody>
                        </table>
                        </tr>
                    </tbody>
                </table>
                <br />
                <span style="font-size:14px"><span style="font-family:arial,helvetica,sans-serif"><strong>Thank you<br>Nutridock</strong></span></span>

                </body>
                </html>';
                mail ('urvashitikmani1310@gmail.com',"Nutridock - New contact info received",$message2,$headers);
                // 
                
            return redirect('/thank-you'); 
        }
        
    }
}




}
