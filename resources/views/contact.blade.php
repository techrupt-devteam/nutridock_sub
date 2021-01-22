@extends('layouts.master') @section('content')
<section class="breadcrumbs-custom">
  <div class="parallax-container"data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
    <div class="material-parallax parallax"><img alt=""src="{{url('')}}/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)"></div>
    <div class="breadcrumbs-custom-body context-dark parallax-content">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">Contact Us</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="index.html">Home</a></li>
        <li><a href="grid-blog.html">Blog</a></li>
        <li class="active">Contact Us</li>
      </ul>
    </div>
  </div>
</section>
<section class="contact"id="contact">
  <div class="container-fluid"data-aos="fade-up">
    <div class="row"data-aos="fade-up"data-aos-delay="100">
      <div class="col-lg-6">
        <div class="mb-4 info-box"><i class="fa fa-map-marker"></i>
          <h3>Our Address</h3>
          <p>Nutridock, Store B-17,MIDC Ambad, Nashik, Next To Seva Nexa Service Center, Maharashtra 422010</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="mb-4 info-box"><i class="fa fa-envelope-o"></i>
          <h3>Email Us</h3>
          <p>customercare@nutridock.com</p>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="mb-4 info-box"><i class="fa fa-phone"></i>
          <h3>Call Us</h3>
          <p>+91 7447725922</p>
        </div>
      </div>
    </div>
    <div class="row"data-aos="fade-up"data-aos-delay="100">
      <div class="col-lg-6">
        <iframe allowfullscreen class="mb-4 mb-lg-0"frameborder="0"src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3750.2642324361564!2d73.74918294998845!3d19.955387028861825!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMTnCsDU3JzE5LjQiTiA3M8KwNDUnMDUuMCJF!5e0!3m2!1sen!2sin!4v1605162064423!5m2!1sen!2sin"style="border:0;width:100%;height:460px"></iframe>
      </div>
      <div class="col-lg-6 align-self-center">
        <form action="{{url('/')}}/contact-store"method="post"onsubmit="return submitUserForm()">
          {{csrf_field()}}
          <div class="form-row">
            <div class="form-group col">
              <input class="form-control"data-msg="Please enter at least 4 chars"data-rule="minlen:4"id="name"name="name"placeholder="Your Name"required>
              <div class="validate"></div>
            </div>
            <div class="form-group col">
              <input class="form-control"data-msg="Please enter a valid email"data-rule="email"id="email"name="email"placeholder="Your Email"required type="email">
              <div class="validate"></div>
            </div>
          </div>
           <div class="form-group">
            <input class="form-control"data-msg="Please enter at least 8 chars of subject"data-rule="minlen:4"id="subject"name="subject"placeholder="Subject"required>
            <div class="validate"></div>
          </div>
           <div class="form-group">
            <textarea class="form-control"data-msg="Please write something for us"data-rule="required"name="message"placeholder="Message"rows="5"></textarea>
            <div class="validate"></div>
          </div>
          <div class="form-group col pl-0">
            <div class="g-recaptcha"data-callback="verifyCaptcha"data-sitekey="6LeUQvcZAAAAADPLG3rEpvKuzN8eIOdy1zrLdXoP"></div>
            <div id="g-recaptcha-error"></div>
          </div>
          <div class="mb-2">
            <button class="button"name="sumbit"type="sumbit"value="submit">Submit</button>
          </div>
        </form>
      </div>
      <div class="mt-3 alert alert-success text-center mx-auto col-11 col-md-9">
      	<div class="feed-back">
        	To help us best serve you and others, could you click on this <a class="btn btn-link" href="https://forms.gle/7L9DEok2KCsdXBTT9" target="_blank">Feedback now</a> to give your feedback about your experience with Nutridock
        </div>
      </div>
    </div>
  </div>
</section>
@endsection