<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\MenuModel;
use App\Models\MenuCategoryModel;
use App\Models\IngredientsModel;
use App\Models\SpecificationModel;
use App\Models\MealType;
use Config;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Sentinel;
use Validator;
use DB;

class MenuController extends Controller
{
    public function __construct(MealType $MealType,MenuModel $MenuModel,MenuCategoryModel $MenuCategoryModel,IngredientsModel $IngredientsModel,SpecificationModel $SpecificationModel)
    {
        $data                            = [];
        $this->base_model                = $MenuModel; 
        $this->base_meal_type            = $MealType; 
        $this->base_menucatgorymodel     = $MenuCategoryModel; 
        $this->base_specificationmodel   = $SpecificationModel; 
        $this->base_ingredientsmodel     = $IngredientsModel; 
        $this->title                     = "Menu";
        $this->url_slug                  = "menu";
        $this->upload_image_base_path    = base_path().'/uploads/images/';
        $this->upload_image              = 'uploads/images/';
        $this->folder_path               = "admin/menu/";
        //Message
        $this->Insert = Config::get('constants.messages.Insert');
        $this->Update = Config::get('constants.messages.Update');
        $this->Delete = Config::get('constants.messages.Delete');
        $this->Error = Config::get('constants.messages.Error');
        $this->Is_exists = Config::get('constants.messages.Is_exists');

    }

    //Menu  Function
    public function index()
    {
        $arr_data = [];
        $data     = \DB::table('nutri_mst_menu')
                    ->leftJoin('menu_categories', 'nutri_mst_menu.menu_category_id', '=', 'menu_categories.id')
                    ->select('nutri_mst_menu.*','menu_categories.name')
                   // ->where('nutri_mst_menu.is_deleted','No')
                    ->orderby('nutri_mst_menu.id','DESC')
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
        $menu_type         = $this->base_meal_type->orderby('meal_type_id','DESC')->get();
        $category          = $this->base_menucatgorymodel->orderby('id','DESC')->get();
        $specification     = $this->base_specificationmodel->orderby('id','DESC')->get();
        $data['page_name'] = "Add";
        $data['menu_type'] = $menu_type;
        $data['category']  = $category;
        $data['specification'] = $specification;
        $data['title']     = $this->title;
        $data['url_slug']  = $this->url_slug;
        return view($this->folder_path.'add',$data);
    }

    // Menu  Store Function
    public function store(Request $request)
    {
       
       $validator = Validator::make($request->all(), [
                'category_id'             =>'required',
                'menu_title'              =>'required',
                'menu_type'               =>'required',
                'menu_image'              =>'required',
                'specification_id'        =>'required',
                'menu_description'        =>'required',
                'ingredients_desc'        =>'required',
                'calories'                =>'required',
                'proteins'                =>'required',
                'fats'                    =>'required',
                'carbohydrates'           =>'required',
                'what_makes_dish_special' =>'required'
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        $is_exist = $this->base_model->where(['menu_title'=>$request->input('menu_title')])->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
        
        $menu_img              = Input::file('menu_image');
        //random number genrate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        
        //end number genrate function delete   
        //dd($request->input('menu_type'));

        $arr_data                              = [];
        $arr_data['menu_category_id']          = $request->input('category_id');
        $arr_data['menu_title']                = $request->input('menu_title');
        $arr_data['menu_description']          = $request->input('menu_description');
        $arr_data['what_makes_dish_special']   = $request->input('what_makes_dish_special');
        $arr_data['specification_id']          = implode(",",$request->input('specification_id'));
        $arr_data['menu_type']                 = implode(",",$request->input('menu_type'));
        $arr_data['ingredients']               = $request->input('ingredients_desc');
        $arr_data['image']                     = $request->input('menu_title')."".$randomString."".$menu_img->getClientOriginalName();
        $arr_data['calories']                  = $request->input('calories');
        $arr_data['proteins']                  = $request->input('proteins');
        $arr_data['carbohydrates']             = $request->input('carbohydrates');
        $arr_data['fats']                      = $request->input('fats');
        
        $menu                 = $this->base_model->create($arr_data);
        if(!empty($menu))
        {
            $destinationPath = 'uploads/menu/';
            $destinationPathThumb = $destinationPath . 'thumb/';
            $filename_menu = $menu_img->getClientOriginalName();
            $original_Menu = $menu_img->move($destinationPath, $request->input('menu_title')."".$randomString."".$filename_menu);
            
            //thumbnail create menu
            $menu_thumb = Image::make($original_Menu->getRealPath())
            ->resize(255, 250)
            ->save($destinationPathThumb . $request->input('menu_title')."".$randomString."".$filename_menu);

            //Multiple File Upload save
            $failed = 0;  
            $img_flag = $request->input('img_flag');
            for($d=1; $d <= $img_flag; $d++) 
            { 

                if(!empty($menu->id))
                {
                    $menu_multi_img        = Input::file('img'.$d);
                    $characters            = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $charactersLength      = strlen($characters);
                    $randomStringMulti = '';
                    for ($i = 0; $i < 18; $i++) 
                    {
                        $randomStringMulti          .= $characters[rand(0, $charactersLength - 1)];
                    }

                      $arr_data1                     = [];
                      $arr_data1['img_path']         = $menu->id."multi_Menu".$randomStringMulti."".$menu_multi_img->getClientOriginalName();
                      $arr_data1['menu_id']          = $menu->id;

                      $menu_multiple_images  = \DB::table('nutri_dtl_menu_img')->insert($arr_data1); 
                      if($menu_multiple_images)
                      {
                        $mutilple_file_destinationpath = 'uploads/menu/';
                        $filename_menu = $menu_multi_img->getClientOriginalName();
                        $original_menu_multi = $menu_multi_img->move($mutilple_file_destinationpath, $menu->id."multi_Menu".$randomStringMulti."".$filename_menu);

                        //thumbnail create menu            
                        $menu_multi_thumb = Image::make($original_menu_multi->getRealPath())
                        ->resize(100, 100)
                        ->save($destinationPathThumb . $menu->id."multi_Menu".$randomStringMulti."".$filename_menu);    

                        $failed = 0;
                      }
                      else
                      {
                        $failed++;
                      }
                }
            }
            //Multiple ingrediant save   
            $failed = 0;  
            $int_flag = $request->input('int_flag');
            for($int=1; $int <= $int_flag; $int++) 
            { 

                if(!empty($menu->id))
                {
                    $menu_ingrediant_img        = Input::file('int_img'.$int);
                    $characters                 = '0123456789abcdefghijklmnopqrstuvwxyz';
                    $charactersLength           = strlen($characters);
                    $randomStringMulti_int      = '';
                    for ($i = 0; $i < 18; $i++) 
                    {
                        $randomStringMulti_int       .= $characters[rand(0, $charactersLength - 1)];
                    }

                      $arr_data2              = [];
                      $arr_data2['image']     = $menu->id."menu_ingre".$randomStringMulti_int."".$menu_ingrediant_img->getClientOriginalName();
                      $arr_data2['menu_id']   = $menu->id;
                      $arr_data2['name']      = $request->input('int_title'.$int);;

                      $menu_ingre_images  = \DB::table('ingredients')->insert($arr_data2); 
                      if($menu_ingre_images)
                      {


                           $mutilple_int_destinationpath = 'uploads/menu/menu_ingrediants/';
                           $destinationPathThumbIngre = $mutilple_int_destinationpath.'thumb/' ;
                           $filename_menu_ingrediant = $menu_ingrediant_img->getClientOriginalName();
                           $original_Menu_ingrediant = $menu_ingrediant_img->move($mutilple_int_destinationpath,$menu->id."menu_ingre".$randomStringMulti_int."".$menu_ingrediant_img->getClientOriginalName());

                            //create ingrediant thumb 
                           $menu_ingre_thumb = Image::make($original_Menu_ingrediant->getRealPath())
                           ->resize(118, 100)
                           ->save($destinationPathThumbIngre . $menu->id."menu_ingre".$randomStringMulti_int."".$menu_ingrediant_img->getClientOriginalName()); 
                           $failed = 0;
                      }
                      else
                      {
                        $failed++;
                      }
                }
            }

            Session::flash('success',  $this->Insert);
            return \Redirect::to('admin/manage_menu');
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
        $data     = $this->base_model->where(['id'=>$id])->first();
        if(!empty($data))
        {
            $arr_data = $data->toArray();
        }   
        $menu_type          = $this->base_meal_type->orderby('meal_type_id','DESC')->get();
        $category          = $this->base_menucatgorymodel->orderby('id','DESC')->get();
        $specification     = $this->base_specificationmodel->orderby('id','DESC')->get();
        $ingrediants       = $this->base_ingredientsmodel->where(['menu_id'=>$id])->orderby('id','DESC')->get()->toArray();
        $menu_images       = \DB::table('nutri_dtl_menu_img')->where(['menu_id'=>$id])->get()->toArray();

        $data['menu_type']      = $menu_type;
        $data['category']      = $category;
        $data['specification'] = $specification;
        $data['ingrediants']   = $ingrediants;
        $data['menu_img']   = $menu_images;
        
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
                'category_id'      => 'required',
                'menu_title'         => 'required',
                'menu_type'         => 'required',
                'specification_id'=> 'required',
                'menu_description'   => 'required',
                'ingredients_desc'   => 'required',
                'calories'           => 'required',
                'proteins'           => 'required',
                'fats'               => 'required',
                'carbohydrates'      => 'required',
                'what_makes_dish_special'  => 'required',
            ]);
        if ($validator->fails()) 
        {
            return $validator->errors()->all();
        }
        
        $is_exist = $this->base_model->where('id','<>',$id)->where(['menu_title'=>$request->input('menu_title')])
                    ->count();
        if($is_exist)
        {
            Session::flash('error', $this->Is_exists);
            return \Redirect::back();
        }
       
        $menu_img              = Input::file('menu_image');
        //random number genrate 
        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        $randomString = '';
        
        for ($i = 0; $i < 18; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];


        }

        $specification_data = implode(",",$request->input('specification_id'));
       
        //end number genrate function delete           
        $arr_data                              = [];
        $arr_data['menu_category_id']          = $request->input('category_id');
        $arr_data['menu_title']                = $request->input('menu_title');
        $arr_data['menu_description']          = $request->input('menu_description');
        $arr_data['what_makes_dish_special']   = $request->input('what_makes_dish_special');
        $arr_data['specification_id']          = $specification_data;
        $arr_data['menu_type']                 = implode(",",$request->input('menu_type'));
        $arr_data['ingredients']               = $request->input('ingredients_desc');

       if(isset($_FILES['menu_image']["name"]) && !empty($_FILES['menu_image']["name"]))
        { 
            $arr_data['image']                 = $request->input('menu_title')."".$randomString."".$menu_img->getClientOriginalName();
        }
        else
        {
            $arr_data['image']                 = $request->input('old_img');
        }

        $arr_data['calories']                  = $request->input('calories');
        $arr_data['proteins']                  = $request->input('proteins');
        $arr_data['carbohydrates']             = $request->input('carbohydrates');
        $arr_data['fats']                      = $request->input('fats');

        $menu_update = $this->base_model->where(['id'=>$id])->update($arr_data);
       
        $destinationPath = 'uploads/menu/';
        $destinationPathThumb = $destinationPath . 'thumb/';

        if(isset($_FILES['menu_image']["name"]) && !empty($_FILES['menu_image']["name"]))
        {
          
            $filename_menu = $menu_img->getClientOriginalName();
            $original_Menu = $menu_img->move($destinationPath, $request->input('menu_title')."".$randomString."".$filename_menu);
                
            //thumbnail create menu
            $menu_thumb = Image::make($original_Menu->getRealPath())
            ->resize(255, 250)
            ->save($destinationPathThumb . $request->input('menu_title')."".$randomString."".$filename_menu);
            
            unlink($destinationPath."".$request->input('old_img'));
            unlink($destinationPathThumb."".$request->input('old_img'));

        }
        //Multiple File Upload save
        $failed = 0;  
        $img_flag = $request->input('img_flag');

        //delete  mutiple old images    
        $old_menu_img_delete  = \DB::table('nutri_dtl_menu_img')->where(['menu_id'=>$id])->delete();

        //add new multiple images
        for($d=1; $d <= $img_flag; $d++) 
        { 

            if(!empty($id))
            {
                $menu_multi_img        = Input::file('img'.$d);
                $characters            = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength      = strlen($characters);
                $randomStringMulti = '';
                for ($i = 0; $i < 18; $i++) 
                {
                    $randomStringMulti            .= $characters[rand(0, $charactersLength - 1)];
                }

                  $arr_data1                       = [];
                  if(isset($_FILES['img'.$d]["name"]) && !empty($_FILES['img'.$d]["name"]))
                  {
                    $arr_data1['img_path']         = $id."multi_Menu".$randomStringMulti."".$menu_multi_img->getClientOriginalName();
                  }
                  else
                  {
                       $arr_data1['img_path']     = $request->input('old_img'.$d);
                  }

                  $arr_data1['menu_id']            = $id;
                  $menu_multiple_images  = \DB::table('nutri_dtl_menu_img')->insert($arr_data1); 

                  if($menu_multiple_images)
                  {

                    $mutilple_file_destinationpath = 'uploads/menu/';
                 
                    if(isset($_FILES['img'.$d]["name"]) && !empty($_FILES['img'.$d]["name"]))
                    {
                        $filename_menu = $menu_multi_img->getClientOriginalName();
                        $original_menu_multi = $menu_multi_img->move($mutilple_file_destinationpath, $id."multi_Menu".$randomStringMulti."".$filename_menu);

                        //thumbnail create menu            
                        $menu_multi_thumb = Image::make($original_menu_multi->getRealPath())
                        ->resize(100, 100)
                        ->save($destinationPathThumb . $id."multi_Menu".$randomStringMulti."".$filename_menu); 
                    }
                    
                    //delete old images
                    if(isset($_FILES['img'.$d]["name"]) && !empty($_FILES['img'.$d]["name"]) && !empty($request->input('old_img'.$d)))
                    {
                        unlink($mutilple_file_destinationpath."".$request->input('old_img'.$d));
                        unlink($destinationPathThumb."".$request->input('old_img'.$d));
                    }

                    $failed = 0;
                  }
                  else
                  {
                    $failed++;
                  }
            }
        }
        //Multiple ingrediant save   
        $failed = 0;  
        $int_flag = $request->input('int_flag');
        //delete  mutiple old images ingrediant    
        $old_ingredients_delete  = \DB::table('ingredients')->where(['menu_id'=>$id])->delete();
    
        for($int=1; $int <= $int_flag; $int++) 
        { 

            if(!empty($id) && !empty($request->input('int_title'.$int)))
            {
                $menu_ingrediant_img        = Input::file('int_img'.$int);
                $characters                 = '0123456789abcdefghijklmnopqrstuvwxyz';
                $charactersLength           = strlen($characters);
                $randomStringMulti_int      = '';
                for ($i = 0; $i < 18; $i++) 
                {
                    $randomStringMulti_int       .= $characters[rand(0, $charactersLength - 1)];
                }


                  $arr_data2              = [];

                  if(isset($_FILES['int_img'.$int]["name"]) && !empty($_FILES['int_img'.$int]["name"]))
                  {
                     $arr_data2['image']     = $id."menu_ingre".$randomStringMulti_int."".$menu_ingrediant_img->getClientOriginalName();
                  }
                  else {
                     $arr_data2['image']     = $request->input('old_int_img'.$int);
                  }

                  $arr_data2['menu_id']   = $id;
                  $arr_data2['name']      = $request->input('int_title'.$int);

                  $menu_ingre_images  = \DB::table('ingredients')->insert($arr_data2); 


                  if($menu_ingre_images)
                  {
                    $mutilple_int_destinationpath = 'uploads/menu/menu_ingrediants/';
                    $destinationPathThumbIngre = $mutilple_int_destinationpath.'thumb/';

                    if(isset($_FILES['int_img'.$int]["name"]) && !empty($_FILES['int_img'.$int]["name"]))
                    {
                          
                           $filename_menu_ingrediant = $menu_ingrediant_img->getClientOriginalName();
                           $original_Menu_ingrediant = $menu_ingrediant_img->move($mutilple_int_destinationpath,$id."menu_ingre".$randomStringMulti_int."".$menu_ingrediant_img->getClientOriginalName());

                            //create ingrediant thumb 
                           $menu_ingre_thumb = Image::make($original_Menu_ingrediant->getRealPath())
                           ->resize(118, 100)
                           ->save($destinationPathThumbIngre . $id."menu_ingre".$randomStringMulti_int."".$menu_ingrediant_img->getClientOriginalName()); 

                       

                    }
                    //delete old  images
                    if(isset($_FILES['int_img'.$int]["name"]) && !empty($_FILES['int_img'.$int]["name"]) && !empty($request->input('old_int_img'.$int)))
                    {
                        unlink($mutilple_int_destinationpath."".$request->input('old_int_img'.$int));
                        unlink($destinationPathThumbIngre."".$request->input('old_int_img'.$int)); 
                    }


                     $failed = 0;
                  }
                  else
                  {
                    $failed++;
                  }
            }
        }

        Session::flash('success', $this->Update);
        return \Redirect::to('admin/manage_menu');    
    }


    // Menu  delete function
    public function delete($id)
    {
        $id             = base64_decode($id);
        $img            = $this->base_model->where(['id'=>$id])->select('image')->first();
        $multi_img      = \DB::table('nutri_dtl_menu_img')->where(['menu_id'=>$id])->select('img_path')->get()->toArray();
        $ingrediant_img = \DB::table('ingredients')->where(['menu_id'=>$id])->select('image')->get()->toArray();
        //delete menu  iamage
        unlink("uploads/menu/".$img->image);
        unlink("uploads/menu/thumb/".$img->image);
        
        //deklete menu ingrediant images 
        foreach ($ingrediant_img as $key => $value) 
        {    
           unlink("uploads/menu/menu_ingrediants/".$value->image);
           unlink("uploads/menu/menu_ingrediants//thumb/".$value->image);
        }
        
        //delete menu mutliple images
        foreach ($multi_img as $key => $mvalue) 
        {
           unlink("uploads/menu/".$mvalue->img_path);
           unlink("uploads/menu/thumb/".$mvalue->img_path);
        }

        //delete db entry 
        $this->base_model->where(['id'=>$id])->delete();
        \DB::table('nutri_dtl_menu_img')->where(['menu_id'=>$id])->delete();
        \DB::table('ingredients')->where(['menu_id'=>$id])->delete();



        Session::flash('success', $this->Delete);
        return \Redirect::back();
    }


   
}
