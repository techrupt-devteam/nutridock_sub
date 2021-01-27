<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\USer;
use App\Models\Location;
use App\Models\city;
use App\Models\Role;
use App\Models\State;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Session;
use Sentinel;
use Validator;
use DB;
class OperationManagerController extends Controller
{
    public function __construct(USer $OperationManager,Location $Location,City $City,Role $Role,State $State)
    {
        $data                = [];
        $this->email         = "bhushantechrupt@gmail.com";
        $this->Host          = "smtp.gmail.com";
        $this->Port          = 587;
        $this->Password      = "bhushan@9912";
        $this->base_model    = $OperationManager; 
        $this->base_location = $Location; 
        $this->base_city     = $City; 
        $this->base_state    = $State; 
        $this->base_role     = $Role;  
        $this->title         = "Operation Manager";
        $this->url_slug      = "operation_manager";
        $this->folder_path   = "admin/operationmanager/";
    }
    
    //operation_manager folder index view call  function
    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('users')
                     ->join('role','users.roles','=','role.role_id')
                     ->join('state','users.state','=','state.id')
                     ->join('city','users.city','=','city.id')
                     ->join('locations','users.area','=','locations.id')
                     ->select('role.role_name','state.name as state_name','city.city_name','locations.area as area_name','users.*')
                     ->where('users.roles','=',2)
                     ->where('users.is_deleted','<>',1)
                     ->orderBy('id', 'DESC')
                     ->get();

         if(!empty($data))
        {
            $arr_data = $data->toArray();
        }     
        $data['data']      = $arr_data;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
 

    //operation_manager folder add view call function for insert data
    public function add()
    {
        $role              = $this->base_role->get();
        $state             = $this->base_state->get();
        $data['page_name'] = "Add";
        $data['role']      = $role;
        $data['state']      = $state;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }


    //store operation_manager save function     
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'operation_manager_name'   => 'required',
                'operation_manager_email'  => 'required',
                'operation_manager_mobile' => 'required',
                'operation_manager_city'   => 'required',
                'operation_manager_state'  => 'required',
                'operation_manager_area'   => 'required',
                'operation_manager_role'   => 'required'
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
      
        $is_exist = $this->base_model->where(['name'=>$request->input('operation_manager_name'),'mobile'=>$request->input('operation_manager_mobile')])->count();

        if($is_exist)
        {
            Session::flash('error', "operation_manager already exist!");
            return \Redirect::back();
        }

        $password             = uniqid();
        $arr_data                          = [];
        $arr_data['name']     = $request->input('operation_manager_name');
        $arr_data['email']    = $request->input('operation_manager_email');
        $arr_data['mobile']   = $request->input('operation_manager_mobile');
        $arr_data['city']     = $request->input('operation_manager_city');
        $arr_data['state']    = $request->input('operation_manager_state');
        $arr_data['area']     = $request->input('operation_manager_area');
        $arr_data['roles']    = $request->input('operation_manager_role');
        $arr_data['password'] = bcrypt($password);

        $store_operation_manager = $this->base_model->create($arr_data);
      
        if(!empty($store_operation_manager))
        {
            $arr_dat = []; 
            $arr_dat['user_id'] = $store_operation_manager->id; 
            $arr_dat['completed_at'] = 1; 
            $arr_dat['completed'] = 1;   
            $activations = \DB::table('activations')->insert($arr_dat);
            //send mail function 
            $html = '<tr>
            <td style="padding: 20px 25px 10px 25px;background-color: #d8ffcf;">
              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                <tr>
                  <td style="color: #1a2127; font-family: Arial, sans-serif;">
                    <h1 style="font-size: 24px; color: #6dc83c;">Welcome to Nutridock Team,</h1>
                    <h2 style="margin: 0px;text-transform: uppercase">Hello, '.ucfirst($request->input('operation_manager_name')).'</h2>
                  </td>
                </tr>
                <tr>
                  <td style="color: #222; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                    <p style="margin: 0;">To start using your Nutridock account, login to Operation Panel using following login credentials:</p>
                    <p><b>Operation Panel Url</b>: nutridoc.com</p>
                    <p><b>Username:</b> '.ucfirst($request->input('operation_manager_email')).'</p>
                    <p><b>Password:</b> '.$password.'</p>
                  </td>
                </tr>
                <tr>
                  <td style="color: #222; font-family: Arial, sans-serif; font-size: 16px; line-height: 24px; padding: 20px 0 30px 0;">
                    <p style="margin: 0">P.S. If you experience problems, please contact us at info@nutridock.com</p>
                  </td>
                </tr>
              </table>
            </td></tr>';

            $subject ="Operation Panel Login Details";

            $this->send_mail($html,$request->input('operation_manager_email'),$subject);
            
            Session::flash('success', 'Success! Record added successfully.'.uniqid());
            return \Redirect::to('admin/manage_operation_manager');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }
   
    //operation_manager folder edit view call function for edit 
    public function edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();
        $role              = $this->base_role->get();
        $state             = $this->base_state->get();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
       
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['role']      = $role;
        $data['state']     = $state;
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    //operation_manager update function 
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'operation_manager_name'   => 'required',
                'operation_manager_email'  => 'required',
                'operation_manager_mobile' => 'required',
                'operation_manager_city'   => 'required',
                'operation_manager_state'  => 'required',
                'operation_manager_area'   => 'required',
                'operation_manager_role'   => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('id','<>',$id)->where(['name'=>$request->input('operation_manager_name'),'mobile'=>$request->input('operation_manager_mobile')])
                    ->count();

        if($is_exist)
        {
            Session::flash('error', "operation_manager already exist!");
            return \Redirect::back();
        }
        $arr_data             = [];
        $arr_data['name']     = $request->input('operation_manager_name');
        $arr_data['email']    = $request->input('operation_manager_email');
        $arr_data['mobile']   = $request->input('operation_manager_mobile');
        $arr_data['city']     = $request->input('operation_manager_city');
        $arr_data['state']    = $request->input('operation_manager_state');
        $arr_data['area']     = $request->input('operation_manager_area');
        $arr_data['roles']    = $request->input('operation_manager_role');

        if(!empty($request->input('operation_manager_password_new'))){
            $arr_data['password'] = bcrypt($request->input('operation_manager_password_new'));
        }else
        {
            $arr_data['password'] = bcrypt($request->input('password'));  
        }


        $update_operation_manager  = $this->base_model->where(['id'=>$id])->update($arr_data);

        Session::flash('success', 'Success! Record update successfully.');
        return \Redirect::to('admin/manage_operation_manager');
        
    }

  
     public function send_mail($html_body,$reciver_mail,$subject)
     {
            $html_content ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml" lang="en-GB">
            <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
            <title>Email Design</title><meta name="viewport" content="width=device-width, initial-scale=1.0"/><style type="text/css">
            a[x-apple-data-detectors] {color: inherit !important;}
            </style></head><body style="margin: 0; padding: 0;">  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"><tr>
            <td style="padding: 20px 0 30px 0;"><table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse;"><tr><td align="center" bgcolor="#70bbd9"></td></tr>';
            $html_content.=$html_body;
            $html_content.='<tr><td bgcolor="#33363d" style="padding: 20px 20px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;"><tr><td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
            <p style="margin: 0;">The Nutridock Team</p><p style="margin: 0"> <a href="https://nutridock.com" style="color: #0087ff;font-weight: 600;letter-spacing: 0.5px;">https://nutridock.com</p></td>
            <td align="right"><table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;"><tr>
            <td>
            <a href="https://www.facebook.com/nutridock0/" target="_blank">
            <img src="https://nutridock.com/uploads/images/facebook.png" alt="Facebook" width="30" height="30" style="display: block;" border="0" /></a></td><td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td><td><a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24" target="_blank"><img src="https://nutridock.com/uploads/images/instagram.png" alt="Instagram" width="30" height="30" style="display: block;" border="0" /></a></td></tr></table></td></tr></table></td></tr></table></td></tr></table></body></html>';

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
                $mail->Subject    = $subject;
                $mail->setFrom($this->email,'Nutridock-Admin'); //sender
                $mail->MsgHTML($html_content);
                $mail->addAddress($reciver_mail); // reciviwer
                $mail->send();
                return "success";
            } 
            catch (Exception $e) 
            {
                Session::flash('error', 'Internal Server Issue.'.$e);
                return \Redirect::back();
            } 
               
      }

    public function delete($id)
    {
        $arr_data               = [];
        $arr_data['is_deleted'] = '1';
        $this->base_model->where(['id'=>$id])->update($arr_data);
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    } 

    public function status(Request $request)
    {
        $status  = $request->status;
        $id = $request->plan_ids;
        $arr_data               = [];
        if($status=="true")
        {
           $arr_data['is_active'] = '1';
        }
        if($status=="false")
        {
           $arr_data['is_active'] = '0';
        }   
        $this->base_model->where(['id'=>$id])->update($arr_data);
        //return \Redirect::back();
    }


}
