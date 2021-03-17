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
            $msg='You system generated One time password is '.$randstring.'. ';        
            
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
