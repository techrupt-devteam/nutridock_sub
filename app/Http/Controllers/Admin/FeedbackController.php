<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\City;
use App\Models\State;
use App\Models\Notification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Session;
use Sentinel;
use Validator;

class FeedbackController extends Controller
{
    public function __construct(Feedback $Feedback,City $City,Notification $Notification)
    {
        $data               = [];
        $this->base_model   = $Feedback;
        $this->base_city    = $City;
        $this->base_notification    = $City;
        $this->url_slug    = "feedback";
        $this->title        = "FeedBack";
        $this->folder_path  = "admin/feedback/";
    }

    public function index()
    {
        $arrdata = \DB::table('nutri_mst_feedback')
                  ->join('locations','nutri_mst_feedback.area','=','locations.id')
                  ->join('city','nutri_mst_feedback.city','=','city.id')
                  ->select('city.city_name','locations.area as area_name','nutri_mst_feedback.*')
                  ->get();

        $data['data']      = $arrdata;
        $data['page_name'] = "Manage";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'index',$data);
    }
   
    public function add()
    {
        $city = $this->base_city->get();
        $data['seo_title'] = "FeedBack";
        $data['url_slug']  = $this->url_slug;
        $data['city']      = $city;
        return view('feedback',$data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'email'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }


        $arr_data               = [];
        $arr_data['name']       = $request->input('name');
        $arr_data['email']      = $request->input('email');
        $arr_data['mobile_no']  = $request->input('mobile_no');
        $arr_data['feedback']   = $request->input('feedback');
        $arr_data['city']       = $request->input('city');
        $arr_data['area']       = $request->input('area');

        $feedback = $this->base_model->create($arr_data);
        if (!empty($feedback))
        {
             $notify_arr['message']    = 'New Feedback from <b>'.$request->input('name')."</b>";
            $notify_arr['users_role'] = 'admin' ; 
            $notify_arr['user_id']    = 1; 
            $assign_nutritionist_notification = $this->base_notification->create($notify_arr);
            Session::flash('success', 'Success! FeedBack Send successfully.');
            return \Redirect::to('feedback');
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }
    }

    public function view($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "View";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'view',$data);
    }

    public function edit($id)
    {
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }

        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'category'     => 'required',
            ]);

        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('id','<>',$id)->where(['category'=>$request->input('category')])->count();

        if($is_exist)
        {
            Session::flash('error', "Record already exist!");
            return \Redirect::back();
        }

        $arr_data               = [];
        $arr_data['category']     = $request->input('category');
        if(isset($_FILES["image"]["name"]) && !empty($_FILES["image"]["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
      
            $file_name                         = $_FILES["image"]["name"];
            $file_tmp                          = $_FILES["image"]["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $latest_image                   = 'upload/category_image/'.$random_file_name;

            if(move_uploaded_file($file_tmp,env('BASE_PATH').$latest_image))
            {
                $arr_data['category_image']      = $latest_image;
            }
        }   
        
        $category = $this->base_model->where(['id'=>$id])->update($arr_data);
            Session::flash('success', 'Success! Record update successfully.');
            return \Redirect::to('admin/manage_collection');
        /*if (!empty($category))
        {
        }
        else
        {
            Session::flash('error', "Error! Oop's something went wrong.");
            return \Redirect::back();
        }*/
    }

    public function delete($id)
    {
        $this->base_model->where(['id'=>$id])->delete();
        Session::flash('success', 'Success! Record deleted successfully.');
        return \Redirect::back();
    }
}
