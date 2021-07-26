<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Link;
use App\Models\StoryType;

use Config;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;

class LinkController extends Controller
{
    public function __construct(Link $Link,StoryType $StoryType)
    {
        $data                            = [];
        $this->base_model                = $Link; 
        $this->base_story                = $StoryType; 
        $this->title                     = "Link";
        $this->url_slug                  = "link";
        $this->upload_image_base_path    = base_path().'/uploads/images/';
        $this->upload_image              = 'uploads/images/';
        $this->folder_path               = "admin/link/";
        //Message
        $this->Insert = Config::get('constants.messages.Insert');
        $this->Update = Config::get('constants.messages.Update');
        $this->Delete = Config::get('constants.messages.Delete');
        $this->Error = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');

    }
    public function home(Request $request)
    {
         $data     = \DB::table('nutri_mst_link')
                        ->leftJoin('nutri_mst_story_type', 'nutri_mst_link.story_id', '=','nutri_mst_story_type.story_id')
                        ->select('nutri_mst_link.*','nutri_mst_story_type.story_name')
                        ->orderby('nutri_mst_link.link_id','DESC')
                        ->get();

        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }
         $data['data']      = $arr_data;
        return view('coverage',$data);


    }
    //Menu  Function
    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('nutri_mst_link')
                    ->leftJoin('nutri_mst_story_type', 'nutri_mst_link.story_id', '=', 'nutri_mst_story_type.story_id')
                    ->select('nutri_mst_link.*','nutri_mst_story_type.story_name')
                   // ->where('nutri_mst_link.is_deleted','No')
                    ->orderby('nutri_mst_link.link_id','DESC')
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



    // Menu  Add Function 
    public function add()
    {
        $story             = $this->base_story->orderby('story_id','DESC')->where('is_active','=',1)->get();
     
        $data['page_name'] = "Add";
        $data['story']     = $story;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    // Menu  Store Function
    public function store(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
                'story_id'           =>'required',
                'link_name'          =>'required',
                'link'               =>'required',
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where(['link_name'=>$request->input('link_name')])->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        
        $link_img              = Input::file('image');
        //random number genrate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        //end number genrate function delete   
        //dd($request->input('menu_type'));

        $arr_data                               = [];
        $arr_data['story_id']                   = $request->input('story_id');
        $arr_data['link_name']                  = $request->input('link_name');
        $arr_data['link']                       = $request->input('link');
        $arr_data['short_description']          = $request->input('short_description');
        $arr_data['cdate']                      = date('Y-m-d',strtotime($request->input('cdate')));

        $arr_data['image']                      = $request->input('link_name')."".$randomString."".$link_img->getClientOriginalName();
      
        
        $link                 = $this->base_model->create($arr_data);
        if(!empty($link))
        {
            $destinationPath = 'uploads/link/';
            $destinationPathThumb = $destinationPath . 'thumb/';
            $filename_menu = $link_img->getClientOriginalName();
            $original_Menu = $link_img->move($destinationPath, $request->input('link_name')."".$randomString."".$filename_menu);

            $menu_thumb = Image::make($original_Menu->getRealPath())
            ->resize(255, 250)
            ->save($destinationPathThumb . $request->input('link_name')."".$randomString."".$filename_menu);

            Session::flash('success',  $this->Insert);
            return \Redirect::to('admin/manage_link');
        }
        else
        {
            Session::flash('error', $this->Error);
            return \Redirect::back();
        }
    }

    // Menu Edit Function
    public function edit($id)
    {
        $id= base64_decode($id);
        $arr_data = [];
        $data     = $this->base_model->where(['link_id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
        $story          = $this->base_story->orderby('story_id','DESC')->where('is_active','=',1)->get();
        
        $data['story']     = $story;
        $data['data']      = $arr_data;
        $data['page_name'] = "Edit";
        $data['url_slug']  = $this->url_slug;
        $data['title']     = $this->title;
        return view($this->folder_path.'edit',$data);
    }

    // Menu  update function
    public function update(Request $request, $id)
    {

          
       $validator = Validator::make($request->all(), [
                'story_id'           =>'required',
                'link_name'          =>'required',
                'link'               =>'required',
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }

        $is_exist = $this->base_model->where('link_id','<>',$id)->where(['link_name'=>$request->input('menu_title')])->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
       
        $link_img              = Input::file('image');
        //random number genrate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];


        }

         //end number genrate function delete           
        $arr_data                              = [];
             $arr_data                              = [];
        $arr_data['story_id']          = $request->input('story_id');
        $arr_data['link_name']                = $request->input('link_name');
        $arr_data['link']                   = $request->input('link');
        $arr_data['short_description']          = $request->input('short_description');
        $arr_data['cdate']          = date('Y-m-d',strtotime($request->input('cdate')));

       if(isset($_FILES['image']["name"]) && !empty($_FILES['image']["name"]))
        { 
            $arr_data['image']                 = $request->input('link_name')."".$randomString."".$link_img->getClientOriginalName();
        }
        else
        {
            $arr_data['image']                 = $request->input('old_img');
        }


        $link = $this->base_model->where(['link_id'=>$id])->update($arr_data);
       
        $destinationPath = 'uploads/link/';
        $destinationPathThumb = $destinationPath . 'thumb/';

        if(isset($_FILES['image']["name"]) && !empty($_FILES['image']["name"]))
        {
          
            $filename_menu = $link_img->getClientOriginalName();
            $original_Menu = $link_img->move($destinationPath, $request->input('link_name')."".$randomString."".$filename_menu);
                
            //thumbnail create menu
            $menu_thumb = Image::make($original_Menu->getRealPath())
            ->resize(255, 250)
            ->save($destinationPathThumb . $request->input('link_name')."".$randomString."".$filename_menu);
            
            unlink($destinationPath."".$request->input('old_img'));
            unlink($destinationPathThumb."".$request->input('old_img'));

        }
       

        Session::flash('success', $this->Update);
        return \Redirect::to('admin/manage_link');    
    }


    // Menu  delete function
    public function delete($id)
    {
        $id             = base64_decode($id);
        $img            = $this->base_model->where(['link_id'=>$id])->select('image')->first();
        //  dd($ingrediant_img);
        //delete menu  iamage
        if(!empty($img))
        {
            if(file_exists("uploads/link/".$img->image)){
              unlink("uploads/link/".$img->image);
              unlink("uploads/link/thumb/".$img->image); 
            }
        }

        $this->base_model->where(['link_id'=>$id])->delete();


        Session::flash('success', $this->Delete);
        return \Redirect::back();
    }
     
    //change menu_status  
    public function status(Request $request)
    {
        $status  = $request->status;
        $plan_id = $request->plan_ids;
        $arr_data               = [];
        if($status=="true")
        {
         $arr_data['is_active'] = '1';
        }
        if($status=="false")
        {
         $arr_data['is_active'] = '0';
        }   
        $this->base_model->where(['link_id'=>$plan_id])->update($arr_data);
        //return \Redirect::back();
    }

    //menu Details 
  /*  public function details (Request $request)
    {

        $id= $request->menu_id;
        $arr_data = [];
        $data     = $this->base_model->where(['id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   

        $menu_type             = $this->base_meal_type->orderby('meal_type_id','DESC')->get();
        $category              = $this->base_menucatgorymodel->where('id','=',$data->menu_category_id)->first();
        $specification         = $this->base_specificationmodel->orderby('id','DESC')->where('is_active','=',1)->get();
        $ingrediants           = $this->base_ingredientsmodel->where(['menu_id'=>$id])->orderby('id','ASC')->get()->toArray();
        $images           = \DB::table('nutri_dtl_link_img')->where(['menu_id'=>$id])->get()->toArray();
        $data['menu_type']     = $menu_type;
        $data['category']      = $category;
        $data['specification'] = $specification;
        $data['ingrediants']   = $ingrediants;
        $data['link_img']      = $images;
        $data['data']          = $arr_data;
        
        return view($this->folder_path.'menu-details',$data);
    }
*/
   
}
