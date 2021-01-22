@extends('layouts.master') @section('content') 
<!-- <section class="breadcrumbs-custom">
  <div class="parallax-container" data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
    <div class="material-parallax parallax"><img alt="" src="{{url('')}}/public/front/img/faq-bg.jpg" style="display: block; transform: translate3d(-50%, 149px, 0);" /></div>
    <div class="breadcrumbs-custom-body context-dark parallax-content">
      <div class="container">
        <h2 class="breadcrumbs-custom-title">Subscribe Info</h2>
      </div>
    </div>
  </div>
  <div class="breadcrumbs-custom-footer">
    <div class="container">
      <ul class="breadcrumbs-custom-path">
        <li><a href="{{url('')}}">Home</a></li>
        <li class="active">Subscribe Info</li>
      </ul>
    </div>
  </div>
</section> -->
<style type="text/css">
.ltx-video-bg-2 {
    z-index: -1;
    display: block;
    width: 159px;
    height: 100%;
    position: absolute;
    left: 0px;
    background-repeat: no-repeat;
    top: 0;
}
.heading-header-subheader h1 {
    font-weight: 700;
    -ms-word-wrap: break-word;
    word-wrap: break-word;
    color: #222;
    font-size: 48px;
    line-height: 1.3em;
}
.heading-header-subheader h1 span {
    color: #91c439;
}
.wpb_wrapper p {
    line-height: 1.8em;
    font-size: 14px;
    line-height: 2em;
    font-weight: 600;
    font-family: "Open Sans", sans-serif;
    color: rgb(41, 45, 53);
    max-width: 80%;
}
.ltx-icon-h-right {
    list-style: none;
    padding: 0;
    margin-top: 30px;
}
.ltx-icon {
    font-size: 40px;
    color: #8cbd38;
}
.in.d-flex .header {
    padding: 7px 0 0 15px !important;
    margin: 5px;
    font-size: 16px;
    font-weight: 800;
}
.ltx-icon-h-right li {
    margin: 18px 5px;
}
.image img.image {
    max-width: 80%;
    -webkit-border-radius: 24px;
    -moz-border-radius: 24px;
    border-radius: 24px;
    background-clip: border-box;
    margin-left: 100px;
}
.ltx-btn-wrap a {
padding: 16px 30px;
line-height: 1.4em;
min-width: 200px;
font-size: 16px;
background-color: #8bbd36;
color: #fff;
-webkit-transition-delay: .3s,0s,0s !important;
-moz-transition-delay: .3s,0s,0s !important;
-o-transition-delay: .3s,0s,0s !important;
transition-delay: .3s,0s,0s !important;
border-radius: 36px;
font-weight: 700;
}
.ltx-btn-wrap a:hover {
    background-color: #1c2a39;
}
.fixed-top {
    position: sticky !important;
}
.vc_column-inner {
    padding: 2rem;
}
.how-to-work {
    background-color: #f2f4eb;
    padding: 50px 0px 60px;
}
.ltx-icon.bg-main {
    width: 80px;
    height: 80px;
    background-color: #8abb36;
    border: 2px solid #8abb36;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    background-clip: border-box;
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -o-transition: all .3s ease;
    transition: all .3s ease;
    -webkit-transform: scaleX(1);
    -moz-transform: scaleX(1);
    -ms-transform: scaleX(1);
    -o-transform: scaleX(1);
    transform: scaleX(1);
    color: #fff;
    line-height: 2.1em;
    text-align: center;
    margin-bottom: 20px;
}
.ltx-icon.bg-main:hover {
    -webkit-transform: scaleX(-1);
    -moz-transform: scaleX(-1);
    -ms-transform: scaleX(-1);
    -o-transform: scaleX(-1);
    transform: scaleX(-1);
}
.ltx-block-icon .header {
	margin: 8px 0 5px;
	font-weight: 800;
	font-size: 18px;
	line-height: 1.3em;
	color: #1c2a39;
	text-transform: capitalize;
}
.ltx-block-icon .in {
    text-align: center;
    background-clip: border-box;
}
.ltx-block-icon .descr {
    padding: 12px 60px;
}
.ltx-block-icon .descr {
    padding: 12px 15px;
    font-size: 14px;
    color: rgb(43, 47, 55);
}
.ltx-block-icon .in::after {
    content: "";
    right: -55px;
    top: 50px;
    border-top: 2px solid rgba(0,0,0,.08);
    width: 80px;
    position: absolute;
}
.ltx-block-icon.remove-after .in::after {
    display: none;
}
.how-to-work h2 {
    font-size: 35px;
    text-align: center;
    font-weight: 800;
    text-transform: uppercase;
    margin-bottom: 3rem;
    color: #70bb43;
}
.What-you-get{
	/*background-image: url(public/front/img/bg-pattern-1.jpeg);*/
	background-repeat: repeat;
	background-position: center center;
	padding: 60px 0 30px;
	background-size: auto;
	background-color: #fff;
}
.fw-main-row.ls.section_padding_top_50 {
    background-image: url(public/front/img/bg-pattern-1.jpeg);
    background-repeat: repeat;
    background-position: center center;
}
.bordered-2 > div + div > * {
    padding-top: 50px;
    border-top: 1px solid #e1e1e1;
}
.row-lg-50 > * {
    margin-bottom: 50px;
}
.unit {
    display: flex;
    flex: 0 1 100%;
    margin-bottom: -10px;
    margin-left: -10px;
}
.flex-lg-row-reverse {
    flex-direction: row-reverse !important;
}
.unit-left, .unit-right {
    flex: 0 0 auto;
    max-width: 100%;
}
.unit > * {
    margin-bottom: 10px;
    margin-left: 10px;
}
.box-icon-classic-icon, .box-icon-classic-svg {
    height: 90px;
    width: 90px;
}
.box-icon-classic-svg {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0;
    line-height: 0;
}
.box-icon-classic-svg, .box-icon-classic-icon {
    border-radius: 50%;
	background: #eaeaea;
    box-shadow: 5px 5px 10px 0 rgba(0, 0, 0, 0.06);
    animation: iconClassic 20s ease-in-out infinite;
}
.unit-body {
    flex: 0 1 auto;
}
.box-icon-classic-title {
    margin-top: 4px;
}
.box-icon-classic-title {
    font-weight: 600;
	font-size: 20px;
	color: #222;
}
.box-icon-classic-title a, .box-icon-classic-title a:focus, .box-icon-classic-title a:active {
    color: inherit;
}
* + .box-icon-classic-text {
    margin-top: 10px;
}
.box-icon-classic-svg img {
    max-width: 100%;
    height: 50px;
}
.fw-pricing .default-col, .fw-pricing .highlight-col {
    margin-bottom: 50px;
}
.fw-pricing .default-col .fw-package, .fw-pricing .highlight-col .fw-package {
    border: 0;
    border-radius: 5px;
    box-shadow: 0 0 15px 0 rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
	text-align: center;
	background-color: #fbfbfb;
	padding-bottom: 25px;
}
.fw-package-wrap:nth-child(3n+1) .plan-name {
    background-color: #fcdd3f;
	background-image: url(public/front/img/price_img2.jpeg);
}
.fw-package-wrap:nth-child(3n-1) .plan-name::after {
    background-color: rgba(249, 164, 80, 0.8);
}
.plan-name {
    padding: 36px 0 36px;
    margin-bottom: -1px;
    display: block;
    background-color: #a2cc41;
    background-image: url(public/front/img/price_img1.jpeg);
    background-position: 50% 50%;
    background-size: cover;
}
.plan-name h3 {
    text-transform: none;
    font-size: 30px;
    font-weight: 300;
    color: #ffffff;
    text-align: center;
    margin: 0;
    position: relative;
    z-index: 3;
}
.plan-name h3 strong {
    font-weight: 600;
}
.fw-package-wrap:nth-child(3n+1) .plan-name::after {
    background-color: rgba(252, 221, 63, 0.8);
}
.plan-name::after {
    content: "";
    background-color: rgba(162, 204, 65, 0.8);
    position: absolute;
    width: 100%;
    display: block;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
}
.plan-price {
    padding: 48px 0 30px;
    position: relative;
    color: #323232;
}
.plan-price span {
    font-size: 40px;
    font-weight: 300;
    letter-spacing: -0.05em;
}
.plan-price span strong {
    font-size: 60px;
    font-weight: 300;
}
.plan-price p {
    font-family: "Raleway", sans-serif;
    color: #b4b4b4;
    display: block;
    width: 100%;
    text-transform: uppercase;
    font-size: 13px;
    font-weight: 600;
    text-align: center;
    margin-top: 5px;
    line-height: 1;
}
.fw-pricing .fw-default-row {
    line-height: 29px;
}
.before_cover, .after_cover, .before_cover > *, .after_cover > * {
    position: relative;
    z-index: 2;
}
.fw-package.price-table hr {
    margin-left: 65px;
    margin-right: 65px;
}
.fw-package.price-table hr {
    margin-left: 30px;
    margin-right: 30px;
    margin-top: 15px;
    margin-bottom: 15px;
    background-color: rgba(50, 50, 50, 0.1);
}
.theme_button.inverse.color2 {
    color: #fcdd3f;
    background-color: transparent;
    border-color: #fcdd3f;
}
.call-to-action .theme_button {
    padding: 23px 25px 21px;
}
.wide_buttons a, .wide_button {
    min-width: 200px;
}
</style>
<main>
  <section class="mt-4 bg-default vc_section">
    <div class="row">
      <div class="col-md-6 col-lg-5">
        <div class="">
          <div class=""> <span class="image"> <span class="ltx-video-bg-2" style="background-image: url('{{url('')}}/public/front/img/video-bg.png'); visibility: visible; transform: translateX(0px) scale(1); opacity: 1; transition: all 0.3s ease 0s;"></span> <img src="{{url('')}}/public/front/img/about_02.jpeg" class="image"> </span> </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-6 col-lg-7 align-self-center">
        <div class="vc_column-inner">
          <div class="wpb_wrapper">
            <div class="heading-header-subheader">
              <h1 class="ltx-sr">Healthy and tasty foods with<br>
                <span> natural ingredients </span> </h1>
            </div>
            <div class="ltx-content-width">
              <div class="ltx-wrapper">
                <div class="wpb_content_element ">
                  <div class="wpb_wrapper">
                    <p>Quisque pretium dolor turpis, quis blandit turpis semper ut. Nam malesuada eros nec luctus laoreet. Fusce sodales consequat velit eget dictum. Integer ornare magna vitae ex eleifend congue. Morbi sit amet nisi iaculis, fringilla orci nec.</p>
                  </div>
                </div>
              </div>
            </div>
            <ul class="ltx-icon-h-right">
              <li>
                <div class="in d-flex"><span class="ltx-icon fa fa-clock-o bg-transparent"></span>
                  <h6 class="header"> Every day from 8:00 to 12:00</h6>
                </div>
              </li>
              <li>
                <div class="in d-flex"><span class="ltx-icon fa fa-phone bg-transparent"></span>
                  <h6 class="header"> +49260-5731-08</h6>
                </div>
              </li>
            </ul>
            <div class="btn-wrap mt-3"> <span class="ltx-btn-wrap"> <a href="" class="btn  btn-lg btn-second color-hover-default">Subscribe Now</a> </span> </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="how-to-work">
    <h2>How to work</h2>
    <div class="container-fluid	">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12">
          <div class="ltx-block-icon">
            <div class="in"> <span class="ltx-icon fa fa-cutlery bg-main"></span>
              <h2 class="header"> Give your health profile</h2>
              <div class="descr">Nam malesuada eros nec luctus laoreet fusce sodales consequat</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12">
          <div class="ltx-block-icon">
            <div class="in"> <span class="ltx-icon fa fa-cutlery bg-main"></span>
              <h2 class="header"> personal nutritionist will be assigned</h2>
              <div class="descr">Nam malesuada eros nec luctus laoreet fusce sodales consequat</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12">
          <div class="ltx-block-icon">
            <div class="in"> <span class="ltx-icon fa fa-cutlery bg-main"></span>
              <h2 class="header"> meal plans will be created</h2>
              <div class="descr">Nam malesuada eros nec luctus laoreet fusce sodales consequat</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-ms-12 col-xs-12">
          <div class="ltx-block-icon remove-after">
            <div class="in"> <span class="ltx-icon fa fa-cutlery bg-main"></span>
              <h2 class="header"> delivered to your doorstep</h2>
              <div class="descr">Nam malesuada eros nec luctus laoreet fusce sodales consequat</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="What-you-get">
    <div class="container">
      <div class="row row-xl row-30 row-md-40 row-lg-50 align-items-center">
        <div class="col-md-5 col-xl-4">
          <div class="row row-30 row-md-40 row-lg-50 bordered-2">
            <div class="col-sm-6 col-md-12">
              <article class="box-icon-classic box-icon-nancy-right text-center text-lg-right">
                <div class="unit flex-column flex-lg-row-reverse">
                  <div class="unit-left">
                    <div class="box-icon-classic-svg"> <img src="{{url('')}}/public/front/img/tailor-made-nutrition.svg" /> </div>
                  </div>
                  <div class="unit-body">
                    <h4 class="box-icon-classic-title"><a href="#">Tailor made nutrition</a></h4>
                    <p class="box-icon-classic-text">We make our products from 100% organic and fresh ingredients full of vitamins and nutrients.</p>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-12">
              <article class="box-icon-classic box-icon-nancy-right text-center text-lg-right wow fadeInLeft">
                <div class="unit flex-column flex-lg-row-reverse">
                  <div class="unit-left">
                    <div class="box-icon-classic-svg"> <img src="{{url('')}}/public/front/img/delicious-meals.svg" /> </div>
                  </div>
                  <div class="unit-body">
                    <h4 class="box-icon-classic-title"><a href="#">Delicious Meals</a></h4>
                    <p class="box-icon-classic-text">Our drinks are exceptionally good for boosting your health and increasing your energy level.</p>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
        <div class="col-md-2 col-xl-4 d-none d-md-block wow fadeScale"> <img src="{{url('')}}/public/front/img/index-1-399x407.png" alt="" width="399" height="407" class="img-fluid"> </div>
        <div class="col-md-5 col-xl-4">
          <div class="row row-30 row-md-40 row-lg-50 bordered-2">
            <div class="col-sm-6 col-md-12">
              <article class="box-icon-classic box-icon-nancy-left text-center text-lg-left">
                <div class="unit flex-column flex-lg-row">
                  <div class="unit-left">
                    <div class="box-icon-classic-svg"> <img src="{{url('')}}/public/front/img/sustainable-plans.svg" /> </div>
                  </div>
                  <div class="unit-body">
                    <h4 class="box-icon-classic-title"><a href="#">Sustainable plans</a></h4>
                    <p class="box-icon-classic-text">Our smoothies, healthy drinks, and energy bowls contain no artificial additives, only vital elements.</p>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-12">
              <article class="box-icon-classic box-icon-nancy-left text-center text-lg-left">
                <div class="unit flex-column flex-lg-row">
                  <div class="unit-left">
                    <div class="box-icon-classic-svg"> <img src="{{url('')}}/public/front/img/personalised-nutritionist.svg" /> </div>
                  </div>
                  <div class="unit-body">
                    <h4 class="box-icon-classic-title"><a href="#">Personalised nutritionist</a></h4>
                    <p class="box-icon-classic-text">We designed our products as the universal organic energetics that can quench your thirst.</p>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="fw-main-row  ls section_padding_top_50 section_padding_bottom_50 columns_padding_15">
	 <div class="col-xs-12 w-100">
      <div class="special-heading text-center ">
        <h3 class="section_header margin_0"> <span class="darkgrey light-weight text-transform-none"> Special <strong>Diet Plans!</strong> </span> </h3>
        <h6 class="section_header margin_0"> <span class="highlight semibold text-uppercase"> We offer specific plans </span> </h6>
      </div>
      <div class="fw-divider-space " style="margin-top: 40px;"></div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12 w-100">
          <div class="row fw-pricing">
            <div class="fw-package-wrap col-md-4 default-col ">
              <div class="fw-package price-table after_cover">
                <div class="fw-heading-row plan-name">
                  <h3> Weight <strong>Loss</strong> </h3>
                </div>
                <div class="fw-pricing-row plan-price"> <span></span> <span><i class="fa fa-inr" aria-hidden="true"></i><strong>99</strong>.00</span>
                  <p>7 DAYS DIET PLAN</p>
                </div>
                <hr>
                <div class="fw-default-row"> 2 Meetings </div>
                <hr>
                <div class="fw-default-row"> Customized to your needs </div>
                <hr>
                <div class="fw-default-row"> Lose excess weight </div>
                <hr>
                <div class="fw-default-row"> 1 Follow up </div>
                <hr>
                <div class="fw-button-row call-to-action"> <a href="#" target="_self" class="btn btn-outline-success"> Subscribe Now </a> </div>
              </div>
            </div>
            <div class="fw-package-wrap col-md-4 default-col ">
              <div class="fw-package price-table after_cover">
                <div class="fw-heading-row plan-name">
                  <h3> Weight <strong>Loss</strong> </h3>
                </div>
                <div class="fw-pricing-row plan-price"> <span></span> <span><i class="fa fa-inr" aria-hidden="true"></i><strong>159</strong>.00</span>
                  <p>SIX MONTHS DIET &amp; EXERCISE</p>
                </div>
                <hr>
                <div class="fw-default-row"> Special Diet </div>
                <hr>
                <div class="fw-default-row"> Excercise Yoga Plan </div>
                <hr>
                <div class="fw-default-row"> Weekly meetings </div>
                <hr>
                <div class="fw-default-row"> Breast Feeding Sessions </div>
                <hr>
                <div class="fw-button-row call-to-action"> <a href="#" target="_self" class="btn btn-outline-success"> Subscribe Now </a> </div>
              </div>
            </div>
            <div class="fw-package-wrap col-md-4 default-col ">
              <div class="fw-package price-table after_cover">
                <div class="fw-heading-row plan-name">
                  <h3> Body <strong>Sculpting</strong> </h3>
                </div>
                <div class="fw-pricing-row plan-price"> <span></span> <span><i class="fa fa-inr" aria-hidden="true"></i><strong>220</strong>.00</span>
                  <p>FOUR WEEKS MEAL &amp; gym PLAN</p>
                </div>
                <hr>
                <div class="fw-default-row"> Affordable </div>
                <hr>
                <div class="fw-default-row"> Preventive Care </div>
                <hr>
                <div class="fw-default-row"> Diagnostic Tests </div>
                <hr>
                <div class="fw-default-row"> Skilled Nursing Care </div>
                <hr>
                <div class="fw-button-row call-to-action"> <a href="#" target="_self" class="btn btn-outline-success"> Subscribe Now </a> </div>
              </div>
            </div>
          </div>
          <div class="fw-divider-space " style="margin-top: 10px;"></div>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection 