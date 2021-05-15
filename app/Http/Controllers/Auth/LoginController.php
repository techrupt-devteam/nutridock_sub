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
                          
      $to = $checkExist->email;
      $cc = 'developer@techrupt.in';
      //$bcc = array('it@sevagroup.co.in', 'marketing@nutridock.com', 'eatoasb@gmail.com', 'sales@nutridock.com');
       $subject = 'Nutridock Fit - Otp verification';
       $customer_mail = Mail::send('loginmail', $data, function($message) use($to, $subject) {
            $message->to($to);
            //$message->cc($cc);
            //$message->bcc($bcc);
            $message->subject($subject);
            $message->from('admin@nutridock.com','Nutridock Fit');
        });   

        return "success";
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
