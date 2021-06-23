@extends('layouts.master')
<?php session_start();?>
@section('content')
<section class="breadcrumbs-custom">
    <div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
        <div class="material-parallax parallax">
            <img alt=""src="{{url('')}}/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)">
        </div>
        <div class="breadcrumbs-custom-body context-dark parallax-content"><div class="container"><h2 class="breadcrumbs-custom-title">Feed Back</h2>
        </div>
    </div>
    </div>
        <div class="breadcrumbs-custom-footer"><div class="container">
            <ul class="breadcrumbs-custom-path">
                <li><a href="{{url('')}}">Home</a></li>
                <li class="active">Feed Back</li>
            </ul>
        </div>
    </div>
</section>
<main>
    <section class="mt-4 bg-default section section-xl text-md-left">
        <div class="container">
           <div class="row">
             <div class="col-md-12">

                            @if(Session::has('error'))
                              <div class="alert alert-danger alert_msg alert1">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('error') }}
                              </div>
                            @endif
                            @if(Session::has('success'))
                              <div class="alert alert-success alert_msg alert1">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                {{ Session::get('success') }}
                              </div>
                            @endif
                    <!-- form start -->
                    <form action="{{ url('')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
                      {!! csrf_field() !!}
                        <div class="row">  
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="name">Name<span style="color:red;" >*</span></label>
                                  <input class="form-control"data-msg="Please enter at least 4 chars"data-rule="minlen:4"id="name"name="name"placeholder="Your Name"required>
                              </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="email">Email<span style="color:red;" >*</span></label>
                                 <input class="form-control"data-msg="Please enter a valid email"data-rule="email"id="email"name="email"placeholder="Your Email"required type="email">
             
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="Phonene">Phone<span style="color:red;" >*</span></label>
                                   <input class="form-control"data-msg="Please enter a valid mobile number" id="mobile_no"name="mobile_no"placeholder="Your Mobile No"required type="number">
                              </div>
                          </div>
                        </div>
                        <div class="row">  
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="city_id">City<span style="color:red;" >*</span></label>
                                 <select class="form-control select2" name="city" id="city" required="true"  data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." onchange="getArea();">
                                  <option value="">-Select City-</option>
                                  @foreach($city as $city_val)
                                  <option value="{{$city_val->id}}">{{$city_val->city_name}}</option>
                                  @endforeach
                                </select>
                                 <div id="city_error" style="color:red;"></div>
                              </div>
                          </div>
                          <div class="col-md-4">
                              <div class="form-group">
                                <label for="nutritionsit_id">Area<span style="color:red;" >*</span></label>
                                 <select class="form-control select2" name="area" id="area" required="true"  data-parsley-errors-container="#area_error" data-parsley-error-message="Please select Area">
                                  <option value="">-Select Area-</option>
                                </select>
                                 <div id="area_error" style="color:red;"></div>
                              </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Feed Back<span style="color:red;">*</span></label>
                                <textarea name="feedback" class="form-control" data-parsley-error-message="Please select feedback." required=""></textarea>    
                            </div>
                        </div>
                         
                        </div> 

                      <div class="box-footer"> <div class="col-md-12">      <br/> 
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                         <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>

                      </div>
                      </div>
                     

                    </form>
           </div> 
        </div>
    </section>
</main>
@endsection
<script type="text/javascript">
    //load area drop down script 
      function  getArea(){
      var city_id = $("#city").val();
      $.ajax({
        type: "POST",
        url: "{{url('')}}/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#area").html(data);
      });
    }
</script>