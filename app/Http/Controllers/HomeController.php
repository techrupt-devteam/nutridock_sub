<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NewsletterModel;
use App\Models\NotifymeModel;
use App\Models\BlogModel;
use App\Models\SliderModel;
use App\Models\OurHealthyFarmModel;
use App\Models\WhyusModel;
use App\Models\TestimonialsModel;
use App\Models\SubscriptionModel;
use App\Models\MenuModel;
use App\Models\MenuCategoryModel;
use App\Models\SpecificationMenuModel;
use Illuminate\Support\Arr;

use Session;
use Sentinel;
use Validator;
use DB;
use URL;
use Mail;

class HomeController extends Controller
{
    
    public function __construct()
    {
       $this->NewsletterModel = new NewsletterModel();
       $this->NotifymeModel = new NotifymeModel();
       $this->BlogModel = new BlogModel();
       $this->SliderModel = new SliderModel();
       $this->OurHealthyFarmModel = new OurHealthyFarmModel();
       $this->WhyusModel = new WhyusModel();
       $this->TestimonialsModel = new TestimonialsModel();
       $this->SubscriptionModel = new SubscriptionModel();
       $this->MenuModel         = new MenuModel();
       $this->MenuCategoryModel = new MenuCategoryModel();
       $this->SpecificationMenuModel               = new SpecificationMenuModel();
    }


    public function dashboard()
    {   
        $data=[];
        $data['seo_title'] = "Home";

         /*Recent Data*/
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;
       
        return view('dashboard',$data);
    }


    public function index()
    {
        $data['seo_title'] = "Home";
        $obj_data = $this->SliderModel->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }   
        $data['arr_data'] = $arr_data;

        $single_data = $this->SliderModel->first();
        
        if($single_data)
        {
            $single_arr_data = $single_data->toArray();
        }   
        $data['single_data'] = $single_arr_data;
        
        $healthyfarm_data = $this->OurHealthyFarmModel->get();
        if($healthyfarm_data)
        {
            $healthyfarm_array = $healthyfarm_data->toArray();
        }   
        $data['healthyfarm_arr'] = $healthyfarm_array;
        
        $result1 = \DB::select("SELECT * FROM why_us group by id having mod(id,2) = 1");
        
        $data['whyus_arr1'] = $result1;

        $result2 = \DB::select("SELECT * FROM why_us group by id having mod(id,2) = 0");
        $data['whyus_arr2'] = $result2;

        $whyus_data = \DB::select("SELECT * FROM why_us order by id asc");
        $data['whyus_arr'] = $whyus_data;
        
        $testimonials_data = $this->TestimonialsModel->get();
        if($testimonials_data)
        {
            $testimonials_array = $testimonials_data->toArray();
        }   
        $data['testimonials_arr'] = $testimonials_array;

        /*Menu*/       
        $arr_data = [];
        $obj_data = $this->MenuModel->orderBy('id','ASC')->get();
       
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }
        $data['menu_data']      = $arr_data;

        /*Category*/
        $cate_data = [];
        $sqlQuery = "SELECT * FROM menu_categories JOIN menu ON menu.menu_category_id=menu_categories.id group by menu_categories.name";
        $data['cate_data'] = \DB::select(DB::raw($sqlQuery));

        //print_r($data['cate_data']); die;
        
        /*Recent Data*/
        $recent_data = [];
        $recent_value     = \DB::table('blog')
                        ->orderby('id','DESC')
                        ->limit(3)
                        ->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;
       

        return view('index',$data)->with('no', 1);
    }

    public function store(Request $request)
    {
        $arr_rules      = $arr_data = array();

        $arr_rules['_token']                = "required";

        $validator = validator::make($request->all(),$arr_rules);

        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $arr_data['email']  =  $request->input('email', null); 
        $obj_data = $this->NotifymeModel->where('email', $arr_data['email'])->first();

        if($obj_data){
            Session::flash('newsletter_exit_email', 'This email id already exits');
            return redirect('index');
        }else{
            $data['status'] = $this->NewsletterModel->create($arr_data);    
        }
        
        
        
        Session::flash('newsletter_success', 'Thank you for your subscription');
        return redirect('index');
    }
    
    public function subscription(Request $request)
    {
        $arr_rules      = $arr_data = array();
        $status         = false;
        $arr_rules['_token']    = "required";
        $arr_rules['email']     = "required";
        $validator = validator::make($request->all(),$arr_rules);
        if($validator->fails()) 
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $arr_data['email']  =   $request->input('email', null); 
        $arr_data['name']  =   $request->input('name', ''); 
        
        $obj_data = $this->SubscriptionModel
                    ->select('email')
                    ->where('email', $arr_data['email'])
                    ->first();
        if(empty($obj_data) || is_null($obj_data)) {
            $status = $this->SubscriptionModel->create($arr_data);
        } 
        
        $to = $request->input('email', null); 
        
        
        /* @Start: code to send email through smtp */
            $data = array('name'=> $arr_data['name']);
            $to = $arr_data['email'];
            $cc = 'info.nutridock@gmail.com';
            $bcc = array('it@sevagroup.co.in');
            $subject = 'Thank You for connecting with us';
          
            Mail::send('subscriptionmail', $data, function($message) use($to, $subject, $cc, $bcc) {
                $message->to($to);
                $message->cc($cc);
                $message->bcc($bcc);
                $message->subject($subject);
                $message->from('admin@nutridock.com','Nutridock');
            });
        /* @End: code to send email through smtp */
        
        /*$url = "https://nutridock.com";
        $subject = 'Your Nutrition Guide is inside!';
        $headers = "From: admin@nutridock.com\r\n";//
        $headers .= "CC: info.nutridock@gmail.com\r\n";
        $headers .= "BCC: it@sevagroup.co.in\r\n";
        
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $message = '';
        mail($to, $subject, $message, $headers);*/
        
        
        return redirect('/thank-you');
    }

    public function loadModal($id)
    {
        $getData = \DB::table('menu')
                    ->where('id',$id)
                    ->first();

        $title = $getData->menu_title;
        $description = $getData->menu_description;
        $menu_main_img = url('/').'/uploads/images/'.$getData->image;

        $getSpecificationData = \DB::table('menu_specification')
                                ->leftJoin('specification', 'menu_specification.specification_id', '=', 'specification.id')
                                ->select('menu_specification.icon_image','specification.name')
                                ->where('menu_specification.menu_id',$id)
                                ->where('menu_specification.status','Active')
                                ->where('menu_specification.is_deleted','No')
                                ->get();

        $getIngredientsData =   \DB::table('ingredients')
                                ->select('name','image')
                                ->where('menu_id',$id)
                                ->where('status','Active')
                                ->where('is_deleted','No')
                                ->orderby('id','ASC')->get();       


        $getWhatsInside =   \DB::table('whats_inside')
                            ->select('title','unit')
                            ->where('menu_id',$id)
                            ->orderby('id','ASC')->get();       

       
        $htmlData = '<div class="modal-header">
        <h3 class="modal-title">'.$title.'<br>
        <small style="font-size:14px;display:block">'.$description.'</small>
        </h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body"  style="background-color:#f7f7f7">
            <ul class="list-inline mb-0" data-test="tags">';
            foreach($getSpecificationData as $getSpecificationData_val)
            {
                $htmlData .= '<li class="list-inline-item mr-1 mb-1"><span class="badge-list-item">'.$getSpecificationData_val->name.'</span></li>';
            }                
            $htmlData .= '</ul>';

            $htmlData .= '<div class="MealModal-module">
            <article class="meals-overlay">
                <div class="row">
                    <div class="col-md-5">
                        <div class="position-relative">
                            <img class="mb-3 w-100" src="'.$menu_main_img.'">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <section class="title-wrap" style="padding:11px">
                            <div class="heading-title-">
                            <h2 class="pl-1">What makes this dish special</h2>
                            <p>'.stripslashes($getData->what_makes_dish_special).'</p>
                            </div>
                        </section>
                        <section class="title-wrap">
                            <div class="px-3">
                                <div class="heading-title-">
                                    <h2 class="pl-1">Ingredients</h2>
                                </div>
                                <div class="row m-0">';
                                foreach($getIngredientsData as $getIngredientsData_val)
                                {
                                    $htmlData .= '<div class="col-md-4 col-4 pl-1 pr-1">
                                        <figure class="text-center">
                                            <img class="Ingredients-img" alt="Chicken Breast" src="'.url('/').'/uploads/images/'.$getIngredientsData_val->image.'">
                                            <figcaption class="Ingredients-title">'.$getIngredientsData_val->name.'</figcaption>
                                        </figure>
                                    </div>';
                                }
                                    
                                $htmlData .= '</div>
                                 <button class="show-all-ingredients" data-toggle="collapse" data-target="#demo">
                                  Show all ingredients
                                </button>

                                <div id="demo" class="collapse">
                                  <div class="heading-title-">
                                    <h2 class="pl-3" style="margin-bottom: -9px;">All ingredients</h2>
                                   
                                    <p class="ingredients-p"> 
                                    '.$getData->ingredients.'</p>
                                  </div>
                            </div>
                            </div>
                            </section>
                            <section class="title-wrap">
                            <div class="px-3">
                                <div class="heading-title-">
                                    <h2 class="pl-1">What’s inside</h2>
                                </div>
                                <div class="row">';
                                    foreach($getWhatsInside as $getWhatsInside_val)
                                    {
                                    $htmlData .= '<div class="col-md-6 col-6">
                                                    <div class="Featured-Nutridock-module">
                                                    <span class="Calories-name">'.$getWhatsInside_val->title.'</span>
                                                    <strong class="d-block">'.$getWhatsInside_val->unit.'</strong>
                                                    <hr>
                                                    </div>
                                                </div>';
                                    }
                                    
                                    $htmlData .='</div>
                            </div>
                           
                               
                        </section>
                    </div>
                </div>
            </article>
            </div>';

        $htmlData .= '</div>';




        //dd($menu_data);
        return($htmlData);
       // return view('index',['data'=>$id]);
    }

    
}
