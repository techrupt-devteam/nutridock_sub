<?php

namespace App\Http\Controllers;
use App\Models\MenuModel;
use App\Models\MenuCategoryModel;
use App\Models\SpecificationMenuModel;
use Illuminate\Http\Request;

use Sentinel;
use DB;

class MenuController extends Controller
{
    function __construct()
    {   
        $this->arr_view_data                = [];
        $this->module_title                 = "Menu";
        $this->module_view_folder           = "admin";
        $this->product_image_base_path      = base_path().'/uploads/images/';
        $this->product_image_public_path    = url('/').config('app.project.img_path.images');
        $this->MenuModel                    = new MenuModel();
        $this->MenuCategoryModel            = new MenuCategoryModel();
        $this->SpecificationMenuModel               = new SpecificationMenuModel();
    }


    public function index()
    {
        $data['seo_title'] = "Menu";
        $arr_data = [];
        $obj_data = $this->MenuModel->orderBy('id','ASC')->get();
        if($obj_data)
        {
            $arr_data = $obj_data->toArray();
        }
        $data['arr_data']      = $arr_data;
        /*Menu Category*/
        $cate_data = [];
        $sqlQuery = "SELECT * FROM menu_categories INNER JOIN menu ON menu.menu_category_id=menu_categories.id group by menu_categories.name";
        $data['cate_data'] = \DB::select(DB::raw($sqlQuery));
           
        /*Recent Data*/
        $recent_data = [];
        $recent_value     = \DB::table('blog')->orderby('id','DESC')->limit(3)->get();
        if($recent_value)
        {
            $recent_data = $recent_value->toArray();
        }
        $data['recent_data']  = $recent_data;
        return view('menu',$data);
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
                            </div>
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
