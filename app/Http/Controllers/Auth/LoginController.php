<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SubscriberMaster;
use App\Models\User;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


use Config;
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
    public function __construct() {
    
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

      $msg='You system generated One time password is '.$randstring.'. ';   
      Arr::set($data, 'mobile', $input['mobile']);
      Arr::set($data, 'msg', $msg);            
      /* @Start: code to send email through smtp */
                          
      $to = 'developer@techrupt.in';
      $cc = 'developer@techrupt.in';
      //$bcc = array('it@sevagroup.co.in', 'marketing@nutridock.com', 'eatoasb@gmail.com', 'sales@nutridock.com');
      $subject = 'Nutridock Fit - Otp verification';
      echo $customer_mail = Mail::send('loginmail', $data, function($message) use($to, $subject) {
            $message->to($to);
            //$message->cc($cc);
            //$message->bcc($bcc);
            $message->subject($subject);
            $message->from('admin@nutridock.com','Nutridock Fit');
        });   
            
      

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
