<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SubscriberMaster;
use App\Models\User;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use Mail;
use Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       // $this->middleware('guest')->except('logout');


        $this->email         = "bhushantechrupt@gmail.com";
        $this->Host          = "smtp.gmail.com";
        $this->Port          = 587;
        $this->Password      = "bhushan@9912";
    }


    public function checkLogin()
    {
        $input = Input::all(); 

        $mobile_no = $input['mobile'];

        $checkExist = SubscriberMaster::where('mobile', $input['mobile'])
        ->where('is_active', '1')
        ->where('is_deleted', '0')
        ->first();  
       

       if($checkExist) {
        $characters = '01234567';
        $randstring = '';

        for ($i = 0; $i < 6; $i++) {
           $randstring.= rand(0, strlen($characters));
        }

        $updatePassword = SubscriberMaster::where(['mobile'=>$input['mobile']])
                          ->update(['password'=>bcrypt($randstring)]);

        if($updatePassword) {
            Session::put('subscriber_email', $checkExist->email);

            $mobile_no = $input['mobile'];
            //$msg='You system generated One time password is '.$randstring.'. ';  
            
            

            $msg = '<div class="es-wrapper-color" style="background-color:#FAFAFA"> 
            <table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;padding:0;Margin:0;width:100%;height:100%;background-repeat:repeat;background-position:center top">
              <tr style="border-collapse:collapse">
                <td valign="top" style="padding:0;Margin:0">
                    
                  <table class="es-header" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                    <tr style="border-collapse:collapse">
                      <td class="es-adaptive" align="center" style="padding:0;Margin:0"><table class="es-header-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#1d2a3a;width:600px" cellspacing="0" cellpadding="0" bgcolor="#1d2a3a" align="center">
                          <tr style="border-collapse:collapse">
                            <td style="Margin:0;padding-top:10px;padding-bottom:10px;padding-left:20px;padding-right:20px;background-color:#1d2a3a" bgcolor="#1d2a3a" align="left"><!--[if mso]><table style="width:560px" cellpadding="0" cellspacing="0"><tr><td style="width:270px" valign="top"><![endif]-->
                              <table class="es-left" cellspacing="0" cellpadding="0" align="left" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:left">
                                <tr style="border-collapse:collapse">
                                  <td class="es-m-p20b" align="left" style="padding:0;Margin:0;width:270px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                      <tr style="border-collapse:collapse">
                                        <td class="es-m-p0l es-m-txt-c" style="padding:0;Margin:0;font-size:0" align="left">
                                            <a href="nutridockfit.com" target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;">
                                            <img src="white-logo.svg" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="183" height="57">
                                          </a>
                                        </td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table>
                             
                              <table class="es-right" cellspacing="0" cellpadding="0" align="right" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;float:right">
                                <tr style="border-collapse:collapse">
                                  <td align="left" style="padding:0;Margin:0;width:270px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                      <tr style="border-collapse:collapse">
                                        <td class="es-m-txt-c" align="right" style="padding:0;Margin:0;">
                                             <span class="es-button-border" style="border-style:solid;border-color:#1d2a3a;background:#FFFFFF;border-width:2px;display:inline-block;border-radius:10px;width:auto">
                                            <a href="#" class="es-button" target="_blank" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:14px;color:#1d2a3a;border-style:solid;border-color:#FFFFFF;border-width:15px 20px 15px 20px;display:inline-block;background:#FFFFFF;border-radius:10px;font-weight:bold;font-style:normal;line-height:17px;width:auto;text-align:center">Go to Website</a></span>
                                        </td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table>
                             </td>
                          </tr>
                        </table>
                        </td>
                    </tr>
                  </table>
                  <table class="es-content" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%">
                    <tr style="border-collapse:collapse">
                      <td style="padding:0;Margin:0;background-color:#FAFAFA" bgcolor="#fafafa" align="center"><table class="es-content-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:#ececec;width:600px" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                          <tr style="border-collapse:collapse">
                            <td style="padding:0;Margin:0;padding-left:20px;padding-right:20px;padding-top:40px;background-color:transparent;background-position:left top" bgcolor="transparent" align="left"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                  <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-position:left top" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                      <tr style="border-collapse:collapse">
                                        <td style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px;font-size:0" align="center">
                                            <img src="otpicon.png" alt style="display:block;border:0;outline:none;text-decoration:none;-ms-interpolation-mode:bicubic" width="175" height="208">
                                         </td>
                                      </tr>
                                      <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px"><h1 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333"><strong> OTP </strong></h1>
                                          <h1 style="Margin:0;line-height:24px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:20px;font-style:normal;font-weight:normal;color:#333333"><strong>'.$randstring.'</strong></h1></td>
                                      </tr>
                                      <tr style="border-collapse:collapse">
                                        <td align="left" style="padding:0;Margin:0;padding-left:40px;padding-right:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;color:#666666;text-align:center">HI,&nbsp;%FIRSTNAME|% %LASTNAME|%</p></td>
                                      </tr>
                                      <tr style="border-collapse:collapse">
                                        <td align="left" style="padding:0;Margin:0;padding-right:35px;padding-left:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;color:#666666;text-align:center">There was a request to send your OTP on this number 258963</p></td>
                                      </tr>
                                      <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0;padding-top:25px;padding-left:40px;padding-right:40px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:16px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:24px;color:#666666">If did not make this request, just ignore this email. Otherwise, please click the button below to change your password:</p></td>
                                      </tr>
                                      
                                    </table>
                                    </td>
                                </tr>
                              </table>
                              </td>
                          </tr>
                          
                          <tr style="border-collapse:collapse">
                            <td style="Margin:0;padding-top:5px;padding-bottom:20px;padding-left:20px;padding-right:20px;background-position:left top" align="left"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                  
                                </tr>
                              </table>
                              </td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                  <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                    <tr style="border-collapse:collapse">
                      <td style="padding:0;Margin:0;background-color:#FAFAFA" bgcolor="#fafafa" align="center"><table class="es-footer-body" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px">
                          <tr style="border-collapse:collapse">
                            <td style="Margin:0;padding-top:10px;padding-left:20px;padding-right:20px;padding-bottom:15px;background-color:#5CB031;background-position:left top" bgcolor="#0b5394" align="left"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                  <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                      <tr style="border-collapse:collapse">
                                        <td align="left" style="padding:0;Margin:0;padding-top:5px;padding-bottom:5px"><h2 style="Margin:0;line-height:19px;mso-line-height-rule:exactly;font-family:arial, "helvetica neue", helvetica, sans-serif;font-size:16px;font-style:normal;font-weight:normal;color:#FFFFFF"><strong>Have quastions?</strong></h2></td>
                                      </tr>
                                      <tr style="border-collapse:collapse">
                                        <td align="left" style="padding:0;Margin:0;padding-bottom:5px"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;color:#FFFFFF">We are here to help, learn more about us <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:14px;text-decoration:none;color:#1d2a3a" href="">here</a></p>
                                          <p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:14px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:21px;color:#FFFFFF">or <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:14px;text-decoration:none;color:#1d2a3a" href="">contact us</a><br>
                                          </p>
                                          </td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                  
                  <table class="es-footer" cellspacing="0" cellpadding="0" align="center" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;table-layout:fixed !important;width:100%;background-color:transparent;background-repeat:repeat;background-position:center top">
                    <tr style="border-collapse:collapse">
                      <td style="padding:0;Margin:0;background-color:#FAFAFA" bgcolor="#fafafa" align="center"><table class="es-footer-body" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px;background-color:transparent;width:600px" cellspacing="0" cellpadding="0" bgcolor="transparent" align="center">
                          <tr style="border-collapse:collapse">
                            <td align="left" style="Margin:0;padding-bottom:5px;padding-top:15px;padding-left:20px;padding-right:20px"><table width="100%" cellspacing="0" cellpadding="0" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                <tr style="border-collapse:collapse">
                                  <td valign="top" align="center" style="padding:0;Margin:0;width:560px"><table width="100%" cellspacing="0" cellpadding="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px">
                                      <tr style="border-collapse:collapse">
                                        <td align="center" style="padding:0;Margin:0"><p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-size:12px;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;line-height:18px;color:#666666">This daily newsletter was sent to info@name.com from company name because you subscribed. If you would not like to receive this email <a target="_blank" style="-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:helvetica, "helvetica neue", arial, verdana, sans-serif;font-size:12px;text-decoration:underline;color:#333333" class="unsubscribe" href="">unsubscribe here</a>.</p></td>
                                      </tr>
                                    </table></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
                  </td>
              </tr>
            </table>
          </div>';

            
            $mail = new PHPMailer(true);
            try
            {
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->CharSet    = "utf-8";
                $mail->SMTPAuth   = true;
                $mail->SMTPSecure = "tls";
                $mail->Host       = $this->Host;
                $mail->Port       = $this->Port;
                $mail->Username   = $this->email;
                $mail->Password   = $this->Password;
                $mail->IsHTML(true);
                $mail->Subject    = "One Time Password for Nutridock Fit login";
                $mail->setFrom($this->email,'Nutridock-Admin'); //sender
                $mail->MsgHTML($msg);
                $mail->addAddress($checkExist->email); // reciviwer
                $mail->send();
                return "success";
            } catch (Exception $e) {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
            }

            /* @End: code to send email through smtp */     


            // if(strlen($input['mobile'])>10)
            // {
            //     $keycount=strlen($mobile_no)-10;
            //     $mobile_no = substr($mobile_no,$keycount);
            // }
            // $url='http://fastsms.way2mint.com/SendSMS/sendmsg.php?uname=hoh12&pass=admin@12&send=CHKTLK&dest=91'.$mobile_no.'&msg='.urlencode($msg).'&prty=1&vp=30';
            // $ch = curl_init();
            // curl_setopt( $ch,CURLOPT_URL, $url);
            // curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            // curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            // curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            // $result = curl_exec($ch );
            // curl_close( $ch );

        }
       }   
       else {
           return 'false';
       }     
    }



    public function checkOtp()
    {
        $input = Input::all(); 
        $otp = '';
        for ($j = 1; $j <= 6; $j++) {
            $otp .= $input['digit-'.$j];
        }      

        $checkPwdExist = SubscriberMaster::where('mobile', $input['mobile'])->first();         

        if(Hash::check($otp,$checkPwdExist['password'])) { 
            $updatePassword = User::where('subscriber_id', $checkPwdExist->id)
            ->update(['password'=>bcrypt($otp)]);   

            Session::put('subscriber_id', $checkPwdExist->id);
            Session::put('subscriber_mobile', $input['mobile']);
            Session::put('subscriber_otp', $otp);  
                          
            
            return 'true';
        } else {
            return 'false';
        }

        
    }
}
