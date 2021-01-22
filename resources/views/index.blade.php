@extends('layouts.master')
@section('content')
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
   <div class="carousel-inner">
      @foreach($arr_data as $row)
      <div <?php if($single_data['id']==$row['id']) {?> class="carousel-item active" <?php }else{ ?> class="carousel-item" <?php } ?> >
         <img src="{{url('')}}/uploads/images/{{$row['image']}}" class="d-block w-100" alt="...">
         <div class="carousel-caption text-md-left text-center">
            <div class="" data-aos="zoom-out" data-aos-delay="100">
              <a href="http://order.nutridock.com/" target="_tab" class="btn btn-success btn-lg">Order Now</a>
              <a href="{{url('')}}/subscribe_info" class="btn btn-outline-success btn-lg">Subscription</a>
            </div>
         </div>
      </div>
      @endforeach
   </div>
   <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
   <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
   <div class="sketch-slider" style=""></div>
</div>
<style>.sketch-slider{position:absolute;bottom:0;left:0;width:100%;z-index:3;background:url('{{url('')}}/public/front/img/sketch.png') repeat center bottom;background-size:auto 100%;height:40px}</style>
<main id="main">
   <section class="elementor-element">
      <div class="container">
         <div class="row" style="display: block;">
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
         </div>
      </div>
   </section>
   <section>
      <div class="container">
         <div class="">
            <h2 class="elementor-heading-title mb-3">Top Categories</h2>
         </div>
         <div class="">
            <div class="w-100 d-flex justify-content-center mt-3">
               <ul class="nav nav-pills Categories-portfolio" role="tablist">
                  @foreach($cate_data as $key => $row)
                  <li class="nav-item">
                     <a @if($key==0) class="nav-link active" @endif class="nav-link" data-toggle="pill" href="#tab{{$row->menu_category_id}}">
                     {{$row->name}} </a> 
                  </li>
                  @endforeach
               </ul>
            </div>
            <div class="w-100 d-flex justify-content-center mt-2">
               <div class="tab-content w-100">
                  @foreach($cate_data as $count => $row)
                  <div id="tab{{$row->menu_category_id}}" @if($count==0) class="tab-pane active filter-active" @else class="container tab-pane" @endif><br>
                  <div class="row">
                     <?php $menu_data=\DB::table('menu')->where('menu_category_id',$row->menu_category_id)->limit(4)->get();
                        foreach($menu_data as $menu_row):
                        $menu_id= $menu_row->id; ?>
                     <div class="col-lg-4 col-xl-3 col-md-6">
                        <div class="meal-card-wrapper">
                           <div class="meal-card">
                              <div class="meal-img">
                              <a data-toggle="modal" data-target="#myModal" 
                                id="getMenu" 
                                data-url="{{ route('dynamicModal',['id'=>$menu_row->id])}}" border="0">
                                 <img src="{{url('')}}/uploads/images/{{$menu_row->image}}" class="img-fluid">
                                </a>                              
                              </div>
                              <div>
                                 <div class="nutridock-meal mt-2">
                                    <div class="nutridock-meal-name text-center"> <span title="{{$menu_row->menu_title}}"> {{$menu_row->menu_title}}</span> </div>
                                    <div class="nutridock-meal-ingredients text-center"> <span class="txt-side-dish-s" title="with Sautéed Carrots &amp; French Green Beans">{{$menu_row->menu_description}}</span> </div>
                                    <div class="nutridock-icon over-xs-limit">
                                       <?php $whats_inside_value=\DB::table('whats_inside')->where('menu_id',$menu_id)->orderBy('id','Asc')->limit('1')->get();
                                          foreach($whats_inside_value as $whats_inside_row);?>
                                       <div class="meal-icon">
                                          <a href="javascript:" class="tooltip" title="" style="margin-left:-40px;color:#5cc62b;cursor: pointer;">
                                          <span class="tooltiptext">Calories</span><?php $string=$whats_inside_row->unit;$s = ucfirst($string);
                                             $bar = ucwords(strtolower($s));
                                             echo $data = preg_replace('/\s+/', '', $bar); ?>
                                          </a>
                                       </div>
                                       <?php $spec_value=\DB::table('menu_specification')->where('menu_id',$menu_id)->get();
                                          foreach($spec_value as $spec_row):
                                          $spec_id = $spec_row->specification_id;
                                          $specifiction = \DB::table('specification')->where('id',$spec_id)->get();
                                          foreach($specifiction as $specifiction_row); ?>
                                       <div class="meal-icon">
                                          <a href="javascript:" class="tooltip" title="<?php echo $specifiction_row->name; ?>">
                                          <span class="tooltiptext"><?php echo $specifiction_row->name; ?></span>
                                          <img src="{{url('')}}/uploads/images/{{$spec_row->icon_image}}" alt="<?php echo $specifiction_row->name; ?>">
                                          </a>
                                       </div>
                                       <?php endforeach; ?>
                                       <div class="meal-icon">
                                       <a class="tooltip" data-toggle="modal" data-target="#myModal" 
                                       id="getMenu" 
                                       data-url="{{ route('dynamicModal',['id'=>$menu_row->id])}}" border="0" style="cursor: pointer;">
                                          <span class="tooltiptext">show more</span> <img src="{{url('')}}/public/front/img/designs-menu.png" alt="show more"> </a> 
                                       </div>
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
         <div class="" style="display: block;">
            <h2 class="elementor-heading-title mb-3">Our Pillars</h2>
            <?php $i=0; foreach($whyus_arr as $key=> $row1)
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
            <?php }else{?>
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
            <?php $i++; } ?>
         </div>
      </div>
   </section>
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
                  <h4 class="text-dark">
                    The secret of getting healthy life, with  free guide to easy and enjoyable nutrition, Grab it now!    
                  </h4>
               </div>
               <form action="{{url('/')}}/subscribe" method="post" class="form-inline" onsubmit="return submitUserForm()">
                  {{csrf_field()}}
                  <div class="row">
                     <div class="col-lg-5 col-md-4 col-sm-7 mb-2">
                        <div class="form-group">
                           <input type="text" type="name" name="name" placeholder="Enter your name" required class="form-control" id="inputPassword2" required="required">
                        </div>
                     </div>
                     <div class="col-lg-5 col-md-4 col-sm-7 mb-2">
                        <div class="form-group">
                           <input type="text" type="email" name="email" placeholder="Enter your email" required class="form-control" id="inputPassword2" required="required">
                        </div>
                     </div>
                     <div class="col-lg-2 col-md-4 col-sm-5 text-md-left text-center">
                        <input type="submit" class="button black" value="Get it now">
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </section>
</main>
<div  class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
         
    </div>
</div>
<script>
$(document).ready(function(){
    $(document).on('click', '#getMenu', function(e) {      
        e.preventDefault();
        var url = $(this).data('url');

        $('#dynamic-content').html(url); // leave it blank before ajax call
        $('#modal-loader').show();      // load ajax loader

        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'html'
        })
        .done(function(data){
            console.log(data); 
            $('.modal-content').html(data); // load response 
            $('#modal-loader').hide();        // hide ajax loader   
        })
        .fail(function(){
            $('#dynamic-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            $('#modal-loader').hide();
        });
    });
});
</script>
@endsection