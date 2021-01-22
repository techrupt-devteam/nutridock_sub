<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
//use PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Session;

//use Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }

    public function login_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'email'     => 'required',
                'password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }


        $arr_user = \DB::table('users')->where('email',$request->input('email'))->first();

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
        
        //get_role_permission  
        if($arr_user->roles!='admin'){
        $get_permission_data = \DB::table('permission')->where(['role_id'=>$arr_user->roles,'type_id'=>$arr_user->type_id])->select('permission_access')->get()->toarray();
        $permission_arr = explode(",",$get_permission_data[0]->permission_access);
        //get module list type  wise 
        $get_module_data = \DB::table('module')->where(['type_id'=>$arr_user->type_id])->get()->toarray();
        //get module type
         $get_module_type = \DB::table('module_type')->where(['type_id'=>$arr_user->type_id])->select('type_name')->first();
        }
        
        //dd($arr_user);
       /* if ($request->input('remember')=='on')
        {
            setcookie("adminemail",$request->email,time()+ 3600);
            setcookie("adminpassword",$request->password,time()+ 3600);
            setcookie("adminremember",$request->remember,time()+ 3600);
        }
        else
        {
            setcookie("adminemail",'',time()+ 3600);
            setcookie("adminpassword",'',time()+ 3600);
            setcookie("adminremember",'',time()+ 3600);
        }
        */
 
    //dd(Session::getId());
        $user = \Sentinel::authenticate($credentials);

        if (!empty($user))
        {
            \Sentinel::login($user);
            //Session::put('user', $arr_user);   
            $request->session()->put("user",$arr_user);
            $request->session()->save();  
            if($arr_user->roles!='admin'){
                $request->session()->put("permissions",$permission_arr);
                $request->session()->save(); 

                $request->session()->put("module_data",$get_module_data);
                $request->session()->save();

                 $request->session()->put("module_type",$get_module_type);
                $request->session()->save();
            }

            return redirect('admin/dashbord');
        }
        else
        {
            Session::flash('error', 'Error! Incorrect username or password.');
            return \Redirect::back();
        }
    }

    public function dashbord(Request $request)
    {
        $user = \Sentinel::check();
        $login_user_details  = Session::get('user');

        
        $data = [];
        return view('admin/dashbord',$data);
    }

    public function customize_dashboard(Request $request)
    {
        $user = \Sentinel::check();
        $status = \DB::table('customize_dashboard')->insert(['user_id'=>$user->id,'div_id'=>$request->input('div')]);
        if($status)
        {
            echo 'true';
        }   
        else
        {
            echo 'false';
        }     
    }

    public function reset_customize_dashboard(Request $request)
    {
        $user = \Sentinel::check();
        $status = \DB::table('customize_dashboard')->where(['user_id'=>$user->id])->delete(); 
        Session::flash('success', 'Success! Dashbord reset successfully.');
        return \Redirect::to('admin/dashbord');
    }

    public function forget_password()
    {
        return view('admin/forget_password');
    }

    public function forget_password_process(Request $request)
    {
        if(!empty($request->input('email')))
        {
            $user = \DB::table('users')->where(['mobile_no'=>$request->input('email')])->count();
            if($user)
            {
                $characters = '0123456789';
                $randstring = '';
                for ($i = 0; $i < 8; $i++) {
                    $randstring.= $characters[rand(0, strlen($characters))];
                }
                
                \DB::table('users')->where(['mobile_no'=>$request->input('email')])->update(['password'=>bcrypt($randstring)]);
                $mobile_no = $request->input('email');
            $msg='You system generated password is '.$randstring.'. ';
            if(strlen($mobile_no)>10)
            {
                $keycount=strlen($mobile_no)-10;
                $mobile_no = substr($mobile_no,$keycount);
            }
           
                 $url='http://fastsms.way2mint.com/SendSMS/sendmsg.php?uname=hoh12&pass=admin@12&send=CHKTLK&dest=91'.$mobile_no.'&msg='.urlencode($msg).'&prty=1&vp=30';
            $ch = curl_init();
            curl_setopt( $ch,CURLOPT_URL, $url);
            curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
            $result = curl_exec($ch );

            curl_close( $ch );
               /* $mail = new PHPMailer(true); 
                try {
                    $mail->isSMTP(); 
                    $mail->CharSet    = "utf-8"; 
                    $mail->SMTPAuth   = true;  
                    $mail->SMTPSecure = env('SMTPSECURE');
                    $mail->Host       = env('HOST');
                    $mail->Port       = env('PORT');
                    $mail->Username   = env('USERNAME');
                    $mail->Password   = env('PASSWORD');
                    $mail->setFrom(env('SETFROMEMAIL'), "Kores India");
                    $mail->Subject = "Forget Password";
                    $mail->MsgHTML("Your system generated password is ".$randstring.".");
                    $mail->addAddress($request->input('email'), "Admin");
                    //$mail->send();

                } 
                catch (phpmailerException $e) 
                {
                    dd($e);
                    Session::flash('error', $e);
                } 
                catch (Exception $e) 
                {
                    dd($e);
                    Session::flash('error', $e);
                }*/
                Session::flash('success', 'Success! Please check your Mobile Number for temporary password. Please login again.');
                return redirect('admin/login');
            }
            else
            {
                Session::flash('error', 'Error! Please enter valid Mobile No..');
                return \Redirect::back();
            }
        }
    }

    public function change_password()
    {
        return view('admin/change_password');
    }

    public function change_password_process(Request $request)
    {
        $validator = \Validator::make($request->all(), [
                'oldpassword'     => 'required',
                'new_password'    => 'required',
                'confi_password'  => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $data = \Sentinel::check();
         $login_user_details  = Session::get('user');
        $credentials = [
            'email'    => $login_user_details->email,
            'password' => $request->input('oldpassword'),
        ];

        $user = \Sentinel::authenticate($credentials);

        if (!empty($user))
        {
            \DB::table('users')->where(['email'=>$login_user_details->email])->update(['password'=>bcrypt($request->input('new_password'))]);
            Session::flash('success', 'Success! Password changed successfully.');
            return \Redirect::back();
        }
        else
        {
            Session::flash('error', 'Error! Old password is wrong.');
            return \Redirect::back();
        }
    } 

    public function logout(Request $request) 
    {
        //\Sentinel::logout();
        //\Session::flush();
        //session_unset();
        //dd(uuid());
       // $request->session()->put('user', []);
        //Session::put('user', []);   
        /*$request->session()->put("user",[]);
            $request->session()->save();  */
            Session::flush();
        return redirect('admin/login');
    }
}
