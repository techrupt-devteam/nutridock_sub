@extends('layouts.master')
@section('content')
<section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
    <div class="material-parallax parallax"> <img src="{{url('')}}/public/front/img/faq-bg.jpg" alt="" style="display: block; transform: translate3d(-50%, 149px, 0px);"> </div>
    <div class="breadcrumbs-custom-body parallax-content context-dark">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">Our Menu</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{url('')}}">Home</a></li>
        <li class="active">Menu</li>
      </ul>
    </div>
  </div>
</section>
<main>
   <section class="">
    <div class="container">
      <div class="">
        <h2 class="elementor-heading-title mb-3">Top Categories</h2>
      </div>
      <div class=""> <!-- data-aos="fade-up" data-aos-delay="100" -->
        <div class="w-100 d-flex justify-content-center mt-3"> 
          <!-- Nav pills -->
          <ul class="nav nav-pills Categories-portfolio" role="tablist">
             @foreach($cate_data as $key => $row)
              <li class="nav-item"> 
              <a @if($key == 0) class="nav-link active" @endif  class="nav-link" data-toggle="pill" href="#tab{{$row->menu_category_id}}"> 
              {{$row->name}} </a> </li>
            @endforeach
          </ul>
        </div>
        <div class="w-100 d-flex justify-content-center mt-2"> 
          <!-- Tab panes -->
          <div class="tab-content w-100">
            @foreach($cate_data as $count => $row)
            <div id="tab{{$row->menu_category_id}}"  @if($count == 0) class="tab-pane active filter-active" @else class="tab-pane" @endif><br>
              <div class="row">
                 <?php $menu_data=\DB::table('menu')->where('menu_category_id',$row->menu_category_id)->get();foreach($menu_data as $menu_row):$menu_id=$menu_row->id; ?>
                <div class="col-lg-4 col-xl-3 col-md-6">
                  <div class="meal-card-wrapper">
                    <div class="meal-card">
                      <div class="meal-img"> 
                        <a data-toggle="modal" data-target="#myModal" 
                                id="getMenu" 
                                data-url="{{ route('dynamicMenuModal',['id'=>$menu_row->id])}}" border="0">
                        <!-- <a href="" data-toggle="modal" data-target="#myModal-{{$menu_row->id}}">  -->
                          <img src="{{url('')}}/uploads/images/{{$menu_row->image}}" class="img-fluid"> 
                        </a> 
                      </div>
                      <div>
                        <div class="nutridock-meal mt-2">
                          <div class="nutridock-meal-name text-center"> <span title="{{$menu_row->menu_title}}"> {{$menu_row->menu_title}}</span> </div>
                          <div class="nutridock-meal-ingredients text-center"> <span class="txt-side-dish-s" title="with Sautéed Carrots &amp; French Green Beans">{{$menu_row->menu_description}}</span> </div>
                          <div class="nutridock-icon over-xs-limit">
                            <?php $whats_inside_value=\DB::table('whats_inside')->where('menu_id',$menu_id)->orderBy('id','Asc')->limit('1')->get();foreach($whats_inside_value as $whats_inside_row); ?>
                            <div class="meal-icon">
                             <a href="javascript:;" class="tooltip" title="" style="margin-left: -40px; color:#5cc62b;">  
                              <span class="tooltiptext">Calories<!--469kcal--></span>
                              <?php $string=$whats_inside_row->unit;$s=ucfirst($string);$bar=ucwords(strtolower($s));echo $data=preg_replace('/\s+/','',$bar); ?> </a>  
                            </div>
                            
                            <?php $spec_value=\DB::table('menu_specification')->where('menu_id',$menu_id)->get();foreach($spec_value as $spec_row):$spec_id=$spec_row->specification_id;$specifiction=\DB::table('specification')->where('id',$spec_id)->get();foreach($specifiction as $specifiction_row); ?>
                            <div class="meal-icon">
                             <a href="javascript:;" class="tooltip" title="<?php echo $specifiction_row->name; ?>">  
                              <span class="tooltiptext"><?php echo $specifiction_row->name; ?></span>
                              <img src="{{url('')}}/uploads/images/{{$spec_row->icon_image}}" alt="<?php echo $specifiction_row->name; ?>"> 
                             </a>  
                            </div>
                            <?php endforeach; ?>
                             <div class="meal-icon" >
                             <!-- <a href="" class="tooltip" data-toggle="modal" data-target="#myModal-{{$menu_row->id}}"> -->
                              <a class="tooltip" data-toggle="modal" data-target="#myModal" 
                                id="getMenu" 
                                data-url="{{ route('dynamicMenuModal',['id'=>$menu_row->id])}}" border="0">
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