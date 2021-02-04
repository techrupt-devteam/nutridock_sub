<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SpecificationModel;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Config;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;

class MenuSpecificationController extends Controller
{
    public function __construct(SpecificationModel $SpecificationModel)
    {
        $data               = [];
        $this->base_model   = $SpecificationModel; 
        $this->title        = "Menu Specification";
        $this->url_slug     = "menu_specification";
        $this->folder_path  = "admin/menu_specification/";
        //Message
        $this->Insert = Config::get('constants.messages.Insert');
        $this->Update = Config::get('constants.messages.Update');
        $this->Delete = Config::get('constants.messages.Delete');
        $this->Error = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');
    }

    //Menu  Specification Listing Function
    public function index()
    {
        $arr_data = [];
        $data     = $this->base_model->orderby('id','DESC')->get();
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

    // Menu specification Add Function 
    public function add()
    {
        $data['page_name'] = "Add";
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    // Menu specification Store Function
    public function store(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
                'specification_title' => 'required',
                'icon_image' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where(['specification_title'=>$request->input('specification_title')])->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        $file                              = Input::file('icon_image');
        //random number genrate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        //end number genrate function delete   

        $arr_data                          = [];
        $arr_data['specification_title']   = $request->input('specification_title');
        $arr_data['icon_image']            = $randomString."".$file->getClientOriginalName();
        
        $specification_menu                = $this->base_model->create($arr_data);
        if(!empty($specification_menu))
        {
            $destinationPath = 'uploads/specification_icon/';
            $filename = $file->getClientOriginalName();
            $original = $file->move($destinationPath, $randomString."".$filename);

            Session::flash('success', $this->Insert);
            return \Redirect::to('admin/manage_menu_specification');
        }
        else
        {
            Session::flash('error', $this->Error );
            return \Redirect::back();
        }
    }

    // Menu Edit Function
    public function edit($id)
    {
        $id= base64_decode($id);
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

    // Menu specification update function
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
                'specification_title' => 'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $is_exist = $this->base_model->where('id','<>',$id)->where(['specification_title'=>$request->input('specification_title')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }

        $arr_data                          = [];

        $arr_data['specification_title']   = $request->input('specification_title');

        //@FILE UPLOAD FUNCTIONALITY
       
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        $destinationPath = 'uploads/specification_icon/';
        if(isset($_FILES['icon_image']["name"]) && !empty($_FILES['icon_image']["name"]))
        { 
            $file                    = Input::file('icon_image');
            $filename                = $file->getClientOriginalName();
            $original                = $file->move($destinationPath, $randomString."".$filename);    
            $arr_data['icon_image']  = $randomString."".$file->getClientOriginalName();
            unlink($destinationPath."".$request->input('old_icon_img'));
        }

        $specification_menu_update = $this->base_model->where(['id'=>$id])->update($arr_data);
        
        Session::flash('success', $this->Update );
        return \Redirect::to('admin/manage_menu_specification');        
    }

    // Menu specification delete function
    public function delete($id)
    {
        $id= base64_decode($id);
        $img = $this->base_model->select('icon_image')->first();
        $this->base_model->where(['id'=>$id])->delete();
        unlink("uploads/specification_icon/".$img->icon_image);
        Session::flash('success', $this->Delete);
        return \Redirect::back();
    }

    //File Upload Function
    public function file_upload($name_input,$path)
    {
        if(isset($_FILES['"'.$name_input.'"']["name"]) && !empty($_FILES['"'.$name_input.'"']["name"]))
        {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 18; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
      
            $file_name                         = $_FILES['"'.$name_input.'"']["name"];
            $file_tmp                          = $_FILES['"'.$name_input.'"']["tmp_name"];
            $ext                               = pathinfo($file_name,PATHINFO_EXTENSION);
            $random_file_name                  = $randomString.'.'.$ext;
            $upload_image_name                 = $path.''.$random_file_name;

            if(move_uploaded_file($file_tmp,env('BASE_PATH').$upload_image_name))
            {
               // $arr_data['images']      = $upload_image_name;
               return $upload_image_name;
            }
        }  
    }    
}
