@extends('layouts.master')
@section('content')
  <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    @foreach($arr_data as $row)
    <div <?php if($single_data['id'] == $row['id']) {?>  class="carousel-item active" <?php }else{ ?> class="carousel-item" <?php } ?> > 
    <img src="{{url('')}}/uploads/images/{{$row['image']}}" class="d-block w-100" alt="...">
      <div class="carousel-caption text-md-left text-center">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
          <a href="http://order.nutridock.com/" target="_tab" class="btn btn-success btn-lg pull-right">Order Now</a>
        </div>
      </div>
    </div>
    @endforeach
    <!-- <div class="carousel-item"> <img src="{{url('')}}/public/front/img/slider-2.png" class="d-block w-100" alt="..."> </div>
      <div class="carousel-caption text-left">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
          <h1 class="slider-containt">The Soul Food and Bistro</h1>
        </div>
      </div>
    </div> -->
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> 
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> 
   <div class="sketch-slider" style="">
   </div>
</div>
   

<!-- End Hero -->
<style>
    .sketch-slider{
    position: absolute; 
    bottom: 0; left: 0; 
    width: 100%; 
    z-index: 3; 
    background: url('{{url('')}}/public/front/img/sketch.png') repeat center bottom; 
    background-size: auto 100%; 
    height: 40px; 
}

</style>
<main id="main">
  <section class="elementor-element">
     
    <div class="container">

      <div class="row">
        <h2 class="elementor-heading-title mb-2">Welcome to Nutridock</h2>
        <p class="elementor-image-box-description text-center"><?php echo $healthyfarm_arr[0]['description']; ?></p>
      </div>
      <div class="row">
       <?php $cnt=0; foreach($healthyfarm_arr as $row): $cnt++; ?>
        <div class="col-md-4">
          <div class="elementor-image-box-wrapper">
            <?php if($cnt==1){ ?>
            <figure class="elementor-image-box-img"> <img src="{{url('')}}/public/front/img/1.jpg" class="attachment-full size-full" alt="" width="66" height="54"> </figure>
          <?php }elseif($cnt==2){ ?>
            <figure class="elementor-image-box-img"> <img src="{{url('')}}/public/front/img/2.jpg" class="attachment-full size-full" alt="" width="66" height="54"> </figure>
          <?php }else{ ?>
            <figure class="elementor-image-box-img"> <img src="{{url('')}}/public/front/img/3.jpg" class="attachment-full size-full" alt="" width="66" height="54"> </figure>
            <?php } ?>
            <div class="elementor-image-box-content">
              <p class="elementor-image-box-title"><?php echo $row['title']; ?></p>
              <p class="elementor-image-box-description"> <?php echo $row['title_description']; ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <!-- <div class="col-md-4">
          <div class="elementor-image-box-wrapper">
            <figure class="elementor-image-box-img"> <img src="{{url('')}}/public/front/img/2-1.webp" class="attachment-full size-full" alt="" width="66" height="54"> </figure>
            <div class="elementor-image-box-content">
              <p class="elementor-image-box-title">Farmer Products</p>
              <p class="elementor-image-box-description"> We work with many farms to provide you with natural products grown with love and care with no GMO or pesticides. </p>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="elementor-image-box-wrapper">
            <figure class="elementor-image-box-img"> <img src="{{url('')}}/public/front/img/3.webp" class="attachment-full size-full" alt="" width="66" height="54"> </figure>
            <div class="elementor-image-box-content">
              <p class="elementor-image-box-title">Fast Delivery</p>
              <p class="elementor-image-box-description"> We want our client to receive their fresh products as soon as possible, so we process and ship the order at once. </p>
            </div>
          </div>
        </div> -->
      </div>
    </div>
  </section>
  <section>
    <div class="container">
      <div class="row">
        <h2 class="elementor-heading-title mb-3">Top Categories</h2>
        <!--<p class="elementor-image-box-description text-center">Lorem Ipsum is simply dummy text of the printing and</p>-->
      </div>
      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-12 d-flex justify-content-center mt-3"> 
          <!-- Nav pills -->
          <ul class="nav nav-pills Categories-portfolio" role="tablist">
            @foreach($cate_data as $key => $row)
              <li class="nav-item"> 
              <a @if($key == 0) class="nav-link active" @endif  class="nav-link" data-toggle="pill" href="#tab{{$row->menu_category_id}}"> 
              {{$row->name}} </a> </li>
            @endforeach
          </ul>
        </div>
        <div class="col-lg-12 d-flex justify-content-center mt-2"> 
          <!-- Tab panes -->
          <div class="tab-content w-100">
            @foreach($cate_data as $count => $row)
            <div id="tab{{$row->menu_category_id}}"  @if($count == 0) class="container tab-pane active filter-active" @else class="container tab-pane" @endif><br>
              <div class="row">
                 <?php 
                 $menu_data     = \DB::table('menu')->where('menu_category_id',$row->menu_category_id)->limit(4)->get(); 
                 foreach($menu_data as $menu_row): 
                 $menu_id= $menu_row->id; ?>
                <div class="col-lg-4 col-xl-3 col-md-6">
                  <div class="meal-card-wrapper">
                    <div class="meal-card">
                      <div class="meal-img"> 
                        <a href="" data-toggle="modal" data-target="#myModal-{{$menu_row->id}}"> 
                          <img src="{{url('')}}/uploads/images/{{$menu_row->image}}" class="img-fluid"> 
                        </a> 
                      </div>
                      <div>
                        <div class="nutridock-meal mt-2">
                          <div class="nutridock-meal-name text-center"> <span title="{{$menu_row->menu_title}}"> {{$menu_row->menu_title}}</span> </div>
                          <div class="nutridock-meal-ingredients text-center"> <span class="txt-side-dish-s" title="with Sautéed Carrots &amp; French Green Beans">{{$menu_row->menu_description}}</span> </div>
                          <div class="nutridock-icon over-xs-limit">
                            <?php $whats_inside_value     = \DB::table('whats_inside')->where('menu_id',$menu_id)->orderBy('id','Asc')->limit('1')->get();
                                foreach($whats_inside_value as $whats_inside_row);?>
                            <div class="meal-icon">
                             <a href="javascript:;" class="tooltip" title="" style="margin-left: -40px; color:#5cc62b;"> 
                             <span class="tooltiptext">Calories<!--469kcal--></span><?php $string = $whats_inside_row->unit;$s = ucfirst($string);
$bar = ucwords(strtolower($s));
echo $data = preg_replace('/\s+/', '', $bar); ?>
                              </a>  
                            </div>
                               
                            <?php $spec_value     = \DB::table('menu_specification')->where('menu_id',$menu_id)->get(); 
                              foreach($spec_value as $spec_row):
                                $spec_id = $spec_row->specification_id;
                                $specifiction     = \DB::table('specification')->where('id',$spec_id)->get(); 
                                foreach($specifiction as $specifiction_row); ?>
                            <div class="meal-icon">
                             <a href="javascript:;" class="tooltip" title="<?php echo $specifiction_row->name; ?>">  
                              <span class="tooltiptext"><?php echo $specifiction_row->name; ?></span>
                              <img src="{{url('')}}/uploads/images/{{$spec_row->icon_image}}" alt="<?php echo $specifiction_row->name; ?>"> 
                             </a>  
                            </div>
                            <?php endforeach; ?>
                             <div class="meal-icon" ><a href="" class="tooltip" data-toggle="modal" data-target="#myModal-{{$menu_row->id}}">
                               <span class="tooltiptext">show more</span>  <img src="{{url('')}}/public/front/img/designs-menu.png" alt="show more"> </a>  </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               <?php endforeach; ?>
              </div>
            </div>
             @endforeach
          </div>
        </div>
      </div>
    </div>
    <div class="text-center">
      <a href="{{url('')}}/menu" class="btn btn-dark btn-lg">View Menu</a>
    </div>
  </section>

<section class="buyer-section">
    <div class="container">
      <div class="row">
        <h2 class="elementor-heading-title mb-3">Our Pillars</h2>
        <?php 
        $i = 0; 
        foreach($whyus_arr as $key => $row1)
        {
          if($i%2 == 0)
          {
            if($i == 0)
            {
              echo ' <p class="elementor-image-box-description text-center col-lg-6 mx-auto">'.$row1->description.'</p>';
            }?>
              <div class="row mt-3">
        <div class="col-md-6 col-lg-5 offset-lg-1">
          <div class="buyer-img"> <img src="{{url('')}}/uploads/images/{{$row1->image}}" class="img-fluid"> </div>
        </div>
        <div class="col-md-6">
          <div class="buyer-containt">
            <div>
              <h3>{{$row1->title}}</h3>
              <p>{{$row1->title_description}}</p>
            </div>
          </div>
        </div>
      </div>
            <?php
          }else{?>
<div class="row mt-4">
        <div class="col-md-6 col-lg-5 offset-lg-1 order-2">
          <div class="buyer-containt">
            <div>
              <h3>{{$row1->title}}</h3>
              <p>{{$row1->title_description}}</p>
            </div>
          </div>
        </div>
        <div class="col-md-5 order-md-2">
          <div class="buyer-img"> <img src="{{url('')}}/uploads/images/{{$row1->image}}" class="img-fluid"> </div>
        </div>
      </div>
<?php } ?>
      
      
<?php 
$i++;
}
?>
</div>
    </div>
  </section>
  
  <!-- ======= Testimonials Section ======= -->
  <!--<section id="testimonials" class="testimonials">
    <div class="container">
      <div class="row">
        <h2 class="elementor-heading-title mb-4 mt-3 text-white">Our Clients Testimonials</h2>
      </div>
    </div>
    <div class="container" data-aos="zoom-in">
      <div class="owl-carousel testimonials-carousel">
         @foreach($testimonials_arr as $row)
        <div class="testimonial-item"> <img src="{{url('')}}/uploads/images/{{$row['image']}}" class="testimonial-img" alt=""> <img src="{{url('')}}/public/front/img/quote.svg" class="d-block mx-auto m-2" style="max-width: 40px">
          <p> {{$row['details']}}</p>
          <h3 class="text-dark">{{$row['name']}}</h3>
          <h4>{{$row['post']}}</h4>
        </div>
        @endforeach
      </div>
    </div>
  </section>-->

  
<section class="newsletter-section orange-bg">
  <div class="container mt-3">
    <div class="row">
      <div class="col-lg-4 col-md-4">
        <div class="newsletter-image">
          <img class="img-responsive center-block" src="{{url('')}}/public/front/img/15.jpg" alt="">
        </div>
      </div>
      <div class="col-lg-8 col-md-8 text-center">
        <div class="newsletter-title mb-4 text-md-left">
          <h4 class="text-dark">Subscribe to get the free guide to easy and enjoyable nutrition! </h4>
        </div>
        <form action="{{url('/')}}/subscribe" method="post" class="form-inline" onsubmit="return submitUserForm();">
            {{csrf_field()}}
          <div class="row">
              
            <div class="col-lg-4 col-md-4 col-sm-7 mb-2">
              <div class="form-group">
                <input type="text" type="name" name="name" placeholder="Enter your name" required class="form-control" id="inputPassword2" required="required">
              </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-7 mb-2">
              <div class="form-group">
                <input type="text" type="email" name="email" placeholder="Enter your email" required class="form-control" id="inputPassword2" required="required">
              </div>
            </div>
            
             <div class="col-lg-4 col-md-4 col-sm-5 text-md-left text-center">
              <div class="g-recaptcha" data-sitekey="6LeUQvcZAAAAADPLG3rEpvKuzN8eIOdy1zrLdXoP" data-callback="verifyCaptcha"></div>
              <div id="g-recaptcha-error"></div>
            </div>
            
            
            <div class="col-lg-4 col-md-4 col-sm-5 text-md-left text-center">
              <input type="submit" class="button black" value="Subscribe now">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
  <!-- End Testimonials Section --> 
</main>
<!-- End #main --> 
    <!-- The Modal -->

@foreach($cate_data as $key => $row)
<?php 
$id = $row->id;
$menu_data     = \DB::table('menu')->get(); //->where('menu_category_id',$id)

foreach($menu_data as $menu_row): ?>
  <div class="modal" id="myModal-{{$menu_row->id}}">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h3 class="modal-title">{{$menu_row->menu_title}} <br>
          <small style="font-size: 14px;display: block;">{{$menu_row->menu_description}}</small>
        </h3>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body" style="background-color: #f7f7f7;">
          <div>
            <ul class="list-inline mb-0" data-test="tags">
              <?php  $menu_data_id = $menu_row->id;
                   $menu_data     = \DB::table('menu')->where('id',$menu_data_id)->get(); 
                   foreach($menu_data as $menu_row);
                   $speci = $menu_row->specification;
                   $abc = explode(",",$speci);
                   //$string_version = implode(',', $abc);
                   //print_r($abc[0]); die;
                   if($speci){
                   for($i=0;$i<count($abc); $i++){?>
                    <li class="list-inline-item mr-1 mb-1"><span class="badge-list-item"><?php echo $abc[$i]; ?></span></li>
                  <?php }  
                  } ?>

              <!-- <li class="list-inline-item mr-1 mb-1"><span class="badge-list-item">&lt;500 Cal</span></li>
              <li class="list-inline-item mr-1 mb-1"><span class="badge-list-item">Gluten Free</span></li>
              <li class="list-inline-item mr-1 mb-1"><span class="badge-list-item">&lt;35g Carbs</span></li>
              <li class="list-inline-item mr-1 mb-1"><span class="badge-list-item">High Protein</span></li>
              <li class="list-inline-item mr-1 mb-1"><span class="badge-list-item">Soy Free</span></li> -->
            </ul>
          </div>
          <div class="MealModal-module">
            <article class="meals-overlay">
             <div>
               <div class="row">
                 <div class="col-md-5">
                  <?php $mult_image = $menu_row->multiple_image;
                        $exp = explode(",", $mult_image);
                        for($i=0; $i<count($exp); $i++){?>
                      <div class="position-relative">
                        <img class="mb-3 w-100" src="{{url('')}}/uploads/images/{{$exp[$i]}}">
                      </div>
                      <?php } ?>
                 </div>

                 <!-- Open Model -->
                 <div class="col-md-7">
                  <section class="title-wrap" style="padding: 11px;">
                   <div class="heading-title-">
                     <h2 class="pl-3" style="margin-left: -17px;">What makes this dish special</h2>
                     <p><?php echo stripslashes($menu_row->what_makes_dish_special); ?></p>
                   </div>
                  </section> 

                  <section class="title-wrap">
                     <div class="heading-title-">
                       <h2 class="pl-3">Ingredients</h2>
                    </div>
                    <div class="row m-0">
                          <?php $menu_id = $menu_row->id;
                                $ingredients     = \DB::table('ingredients')->where('menu_id',$menu_id)->limit(6)->get();
                                foreach($ingredients as $ingredients_value): ?>
                          <div class="col-md-4 col-4 pl-1 pr-1">
                            <figure class="text-center">
                              <img class="Ingredients-img" alt="Chicken Breast" src="{{url('')}}/uploads/images/{{$ingredients_value->image}}">
                              <figcaption class="Ingredients-title">{{$ingredients_value->name}}</figcaption>
                            </figure>
                          </div>
                        <?php endforeach; ?>
                        </div>
                    <button class="show-all-ingredients" data-toggle="collapse" data-target="#demo">
                      Show all ingredients
                    </button>

                     <div id="demo" class="collapse">
                      <div class="heading-title-">
                       <h2 class="pl-3" style="margin-bottom: -9px;">All ingredients</h2>
                        <?php   $name=array(); $menu_value_id = $menu_row->id;
                                $ingredients     = \DB::table('ingredients')->where('menu_id',$menu_value_id)->get();
                                foreach($ingredients as $ingredients_value1){
                                $name[] = $ingredients_value1->name;}
                              $array = implode(',', $name); ?>
                       <p class="ingredients-p" style="font-family: 'Open Sans'; color:#000;"> <?php echo $menu_row->ingredients; ?></p>
                     </div>
                   </div>
                  </section>

                   <section class="title-wrap">
                        <div class="px-3">
                         <div class="heading-title-">
                           <h2 class="pl-0">What’s inside</h2>
                        </div>
                        <div class="row">
                          <?php $menu_id=$menu_row->id;
                                $whats_inside     = \DB::table('whats_inside')->where('menu_id',$menu_id)->orderby('id','ASC')->limit(4)->get();
                                foreach($whats_inside as $whatsinside_row):
                                $title = $whatsinside_row->title;?>
                          <div class="col-md-6 col-6">
                            <div class="Featured-Nutridock-module">
                              <span class="Calories-name"><?php echo $whatsinside_row->title; ?></span>
                              <strong class="d-block"><?php echo $whatsinside_row->unit; ?></strong>
                              <!-- Graph Open --><hr>
                              <!-- <div class="progress" style="height: 0.3rem;">
                                <div class="progress-bar bg-success" style="width:<?php echo $whatsinside_row->unit; ?>%"></div>
                              </div> -->
                              <!-- Graph close -->
                              <!-- <small>25DV</small> -->
                            </div>
                          </div>
                        <?php endforeach; ?>
                        </div>
                        <!--<button class="show-all-ingredients" data-toggle="collapse" data-target="#demo2">
                      Show complete nutrition facts
                    </button>-->
                    <div id="demo2" class="collapse">
                      <h2 class="Facts-ingredients">Nutrition Facts</h2>
                      <p class="ingredients-p pt-0">
                        1 Serving Per Container
                      </p>
                      <table class="table">
                         <?php $menu_id=$menu_row->id;
                                $whats_inside     = \DB::table('whats_inside')->where('menu_id',$menu_id)->orderby('id','ASC')->get();
                                foreach($whats_inside as $whatsinside_row):
                                $title = $whatsinside_row->title; ?>
                        <tr>
                          <th>
                            <?php echo $whatsinside_row->title; ?>
                          </th>
                          <th class="text-right" style="color: #28A745;"><?php echo $whatsinside_row->unit; ?><br/>
                            <!-- % Daily Value* -->
                          </th>
                        </tr>
                      <?php endforeach; ?>
                      </table>
                  </div>
                      </div>
                    </section>
               </div>
               <!-- Close Model -->
             </div> 
            </article>
          </div>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer" style="justify-content: flex-start;">
          <!--<button type="button" class="btn btn-success" data-dismiss="modal">Order Now</button>-->
          <a href="http://order.nutridock.com/" target="_tab" class="btn btn-success">Order Now</a>
        </div>

      </div>
    </div>
  </div>
  <?php endforeach; ?>
<!-- Modal Close -->
@endforeach





@endsection