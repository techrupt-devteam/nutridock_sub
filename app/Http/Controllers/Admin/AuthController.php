<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
//use Session;
use Carbon\Carbon;
use Config;
class AuthController extends Controller
{

    public function __construct()
    {
        $data                = [];
        $this->email         =  Config::get('constants.mail.email');
        $this->Host          =  Config::get('constants.mail.host');
        $this->Port          =  Config::get('constants.mail.port');
        $this->Password      =  Config::get('constants.mail.password');
      
    }


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

        $arr_user = \DB::table('users')->where('email',$request->input('email'))->where('is_deleted','<>',1)->first();
        
        if($arr_user->is_active == 0 & $arr_user->roles!='admin')
        {
            Session::flash('error', '!! You account has been deactivated please contact Nutridock Admin !!');
            return \Redirect::back();
        }

        $credentials = [
            'email'    => $request->input('email'),
            'password' => $request->input('password'),
        ];
        
        $Auth = Auth::guard('web')->attempt($credentials);

      
        //get_role_permission  
        if($arr_user->roles!='admin'){
            $get_permission_data = \DB::table('permission')->where(['role_id'=>$arr_user->roles])->select('permission_access')->get()->toarray();
            //$get_permission_data = \DB::table('permission')->where(['role_id'=>$arr_user->roles,'type_id'=>$arr_user->type_id])->select('permission_access')->get()->toarray();
            if(!empty($get_permission_data))
            {
                $permission_arr = explode(",",$get_permission_data[0]->permission_access);
            }
            //get module list type  wise 
            //$get_module_data = \DB::table('module')->where(['type_id'=>$arr_user->type_id])->get()->toarray();
            
             $get_module_data = \DB::table('module')->get()->toarray();
             $get_parent_menu = \DB::table('module')->where('parent_id','=',0)->get()->toarray();

             $parent_menu = [];
             $sub_menu = [];
             foreach ($get_parent_menu as $key1 => $pmvalue) 
             {
                 
                    $parent_menu[$key1][] = $pmvalue->module_name;
                    $parent_menu[$key1][] = $pmvalue->module_url;
                    $parent_menu[$key1][] = $pmvalue->module_id;
                    $parent_menu[$key1][] = $pmvalue->module_url_slug;
                    
                    $get_child_menu = \DB::table('module')->where('parent_id','=', $pmvalue->module_id)->get()->toarray();
                    if(count($get_child_menu)>0)
                    {   
                        foreach ($get_child_menu as $key2 => $cmvalue) {
                          $sub_menu[$pmvalue->module_name]['menu'][$key2][] = $cmvalue->module_id;
                          $sub_menu[$pmvalue->module_name]['menu'][$key2][] = $cmvalue->module_name;
                          $sub_menu[$pmvalue->module_name]['menu'][$key2][]  = $cmvalue->module_url; 
                          $sub_menu[$pmvalue->module_name]['menu'][$key2][]  = $cmvalue->module_url_slug; 
                        }
                    }
            }
        }
        
        if(!IS_Null($request->input('city')) && !empty($request->input('city')) && $arr_user->roles=='admin')
        {
            if($request->input('city')!= 'all'){
              $get_city   = \DB::table('city')->where('id','=',$request->input('city'))->first();
              $request->session()->put("login_city_name",$get_city->city_name);
              $request->session()->save();
              $request->session()->put("login_city_id",$request->input('city'));
              $request->session()->save();
              
              $request->session()->put("login_city_state",$get_city->state_id);
              $request->session()->save(); 
            }
            else
            {

              $request->session()->put("login_city_id",$request->input('city'));
              $request->session()->save();
            }

        }
        elseif($arr_user->roles!='admin')
        {
              $get_city   = \DB::table('city')->where('id','=',$arr_user->city)->first();


              $get_assign_Subscriber_id   = \DB::table('nutri_mst_subcriber_assign')
                                            ->where('nutritionist_id','=',$arr_user->id)
                                            ->where('is_deleted','<>',1)
                                            ->select('subscriber_id')->first();
           
              if(!empty($get_assign_Subscriber_id) && isset($get_assign_Subscriber_id))
              {

                $subscribers = explode(',',$get_assign_Subscriber_id->subscriber_id);                              
                $request->session()->put("assign_subscriber",$subscribers);
                $request->session()->save(); 
              }



              $request->session()->put("login_city_name",$get_city->city_name);
              $request->session()->save();
              $request->session()->put("login_city_id",$arr_user->city);
              $request->session()->save();
              $request->session()->put("login_city_state",$get_city->state_id);
              $request->session()->save(); 
                
        }


        //dd(Session::getId());
        $user = \Sentinel::authenticate($credentials);

        if (!empty($user))
        {
            \Sentinel::login($user);
            //Session::put('user', $arr_user);   
            $request->session()->put("user",$arr_user);
            $request->session()->save();  
            if($arr_user->roles!='admin'){

                if(!empty($get_permission_data))
                {
                  $request->session()->put("permissions",$permission_arr);
                  $request->session()->save(); 
                }else
                {
                  $request->session()->put("permissions",[]);
                  $request->session()->save();  
                }
                
                $request->session()->put("module_data",$get_module_data);
                $request->session()->save();

                $request->session()->put("parent_menu",$parent_menu);
                $request->session()->save();
                
                $request->session()->put("sub_menu",$sub_menu);
                $request->session()->save();
               
                /* $request->session()->put("module_type",$get_module_type);
                $request->session()->save();*/

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
            $user = \DB::table('users')->where(['email'=>$request->input('email')])->count();
            if($user)
            {
                
                $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength = strlen($characters);
                $randstring = '';   
                for ($i = 0; $i < 18; $i++) {
                $randstring .= $characters[rand(0, $charactersLength - 1)];
                }
        



                //dd($randstring);
                \DB::table('users')->where(['email'=>$request->input('email')])->update(['password'=>bcrypt($randstring)]);
                $mobile_no = $request->input('email');
                $msg='You system generated password is '.$randstring.'.';
                
                /*if(strlen($mobile_no)>10)
                {
                $keycount=strlen($mobile_no)-10;
                $mobile_no = substr($mobile_no,$keycount);
                }*/

                /*$url='http://fastsms.way2mint.com/SendSMS/sendmsg.php?uname=hoh12&pass=admin@12&send=CHKTLK&dest=91'.$mobile_no.'&msg='.urlencode($msg).'&prty=1&vp=30';
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, $url);
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                $result = curl_exec($ch );
                curl_close( $ch );*/

               /* $mail = new PHPMailer(true); 
                try {
                    $mail->isSMTP(); 
                    $mail->CharSet    = "utf-8"; 
                    $mail->SMTPAuth   = true;  
                    $mail->SMTPSecure = 'tls';
                    $mail->Host       = $this->Host;
                    $mail->Port       = $this->Port;
                    $mail->Username   = $this->email;
                    $mail->Password   = $this->Password;
                    $mail->Subject = "Forget Password";
                    $mail->MsgHTML("Your system generated password is ".$randstring.".");
                    $mail->addAddress($request->input('email'), "Nutridock-Admin");
                    $mail->send();

                } 
                catch (phpmailerException $e) 
                {
                    //dd($e);
                    Session::flash('error', $e);
                } 
                catch (Exception $e) 
                {
                    //dd($e);
                    Session::flash('error', $e);
                }
                Session::flash('success', 'Success! please check your registered email id for temporary password. Please login again.');
                return redirect('admin/login');*/

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
                    $mail->Subject    = "Forget Password";
                    $mail->setFrom($this->email,'Nutridock-Admin'); //sender
                    $mail->MsgHTML("Your system generated password is <b>".$randstring."</b>.");
                    $mail->addAddress($request->input('email')); // reciviwer
                    $mail->send();
                    Session::flash('success', 'Success! please check your registered email id for temporary password. Please login again.');
                    return redirect('admin/login');

                } 
                catch (Exception $e) 
                {
                    Session::flash('error', 'Internal Server Issue.'.$e);
                    return \Redirect::back();
                } 
            }
            else
            {
                Session::flash('error', 'Error! Please enter valid email.');
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


    public function get_city_list(Request $request)
    {
      
        $user_name = $request->email;
        
        $user      =  \DB::table('users')->where(['email'=>$request->email])->get()->first(); 
        if(count($user)>0)
        {

            if($user->roles =='admin')
            {
                $get_city   = \DB::table('city')->get();
                $html       = '<option value="">-Select City-</option>';
                $html      .= '<option value="all">All</option>';
                foreach ($get_city as $key => $value) 
                {
                    $html.="<option value=".$value->id.">".$value->city_name."</option>";     
                }
            }
            else
            {
              $html = "users";     
            }
        }
        else
        {
           $html = "NULL"; 
        }
        return $html;
    
    }

    
}
