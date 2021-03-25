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
        <div class="jumbotron text-center">
            <h3>Thank you for subscribing!</h3>
            <p class="lead">We wanted to thank you for being a part of Nutridock Fit Family.<br />
            Our Customer Care will contact you for further details.</p>
            <hr>
            <p> Having trouble? <a href="{{url('')}}/contact">Contact us</a></p>
            <p class="lead">
                <a class="btn btn-success btn-sm" href="{{url('')}}/dashboard" role="button">
                Go to My Account
                </a>
            </p>
        </div>
    </div>
</section>
@endsection