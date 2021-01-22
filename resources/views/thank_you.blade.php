@extends('layouts.master')
@section('content')
<section class="breadcrumbs-custom">
    <div class="parallax-container" data-parallax-img="{{url('')}}/public/front/img/contact-bg.jpg">
      <div class="material-parallax parallax">
        <img src="{{url('')}}/public/front/img/contact-bg.jpg" alt="" style="display: block; transform: translate3d(-50%, 149px, 0px);">
      </div>
      <div class="breadcrumbs-custom-body parallax-content context-dark">
        <div class="container">
          <h2 class="breadcrumbs-custom-title">Thank You</h2>
        </div>
      </div>
    </div>
    <div class="breadcrumbs-custom-footer">
      <div class="container">
        <ul class="breadcrumbs-custom-path">
          <li><a href="{{url('')}}">Home</a></li>
          <li class="active">Thank You</li>
        </ul>
      </div>
    </div>
</section>
 <!-- ======= Contact Section ======= -->
     <section id="contact" class="contact">
      <div class="container-fluid" data-aos="fade-up">
         <div style="text-align: center;font-size: 65px;color: #8fc744;"><i class="icofont-check-circled"></i></div> 
        <h3><p style="text-align: center;">Thank You</p></h3>
        <p style="text-align: center;color: #0b0e13;font-weight: 600;margin-bottom: 1px;">For connecting with us.<!--Your details has been received.-->We have shared the guide on your email.</p>

      </div>
    </section>
@endsection