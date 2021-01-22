@extends('layouts.master') @section('content') 
<link rel="stylesheet" href="{{url('')}}/public/front/css/subscribe.css" />
<main> 
 <div id="demo" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="{{url('')}}/public/front/img/proper-nutrition.png" alt="Proper nutrition is the key to unlock your full potential. Subscribe to our meals daily and enjoy abundant health and deliciousness." style="max-height: 520px;width: 100%">
      <div class="carousel-caption">
        <h1 class="ff-h1 _38">Proper nutrition is the key to unlock your full potential. Subscribe to our meals daily and enjoy abundant health and deliciousness.
        </h1>
        <!-- <form action="{{url('')}}/search" target="blank" method="GET"> -->
        <div class="input-group mx-auto" style="max-width: 460px;">
          <input type="number" class="form-control pincode" placeholder="Pincode" maxlength="6"  aria-describedby="basic-addon3" required="required">
         <!--  <input type="number" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Mobile" name="phone_no" required="required" maxlength="10" minlength="10" > -->
          <div class="input-group-append">
            <span class="input-group-text btn btn-darkblue">
              <!-- <a href="https://nutridock.com/subscribe_now" class="text-white btn get-start-btn">Get Started</a> -->
              <button type="submit" value="submit" class="text-white btn get-start-btn" onclick="searchPincode()">Get Started</button>
            </span>
          </div>
        </div>
        <div class="mx-auto text-left" style="max-width: 460px">
        <span id="err_pincode_not_available" style="color: red;font-size: 15px;"></span>
        <span id="err_pincode_value" style="color: red;font-size: 15px;"></span>
        </div>
        <!-- </form> -->
      </div>  

    </div>
    <div class="carousel-item">
      <img src="{{url('')}}/public/front/img/Pre-workout.png" alt="Pre-workout nutrition is necessary for performance and post-workout nutrition is necessary for progress." style="max-height: 520px;width: 100%">
      <div class="carousel-caption">
        <h1 class="ff-h1 _38">Pre-workout nutrition is necessary for performance and post-workout nutrition is necessary for progress.  <br/> Subscribe Now!
        </h1>
        
        <div class="input-group mx-auto" style="max-width: 460px;">
          <input type="text" class="form-control pincode1" placeholder="Pincode" maxlength="6"  aria-describedby="basic-addon3" required="required">
          <div class="input-group-append">
            <span class="input-group-text btn btn-darkblue">
              <!-- <a href="https://nutridock.com/subscribe_now" class="text-white btn get-start-btn">Get Started</a> -->
               <button type="submit" value="submit" class="text-white btn get-start-btn" onclick="searchPincode1()">Get Started</button>
            </span>
          </div>
        </div>
        <div class="mx-auto text-left" style="max-width: 460px">
          <span id="err_pincode_not_available1" style="color: red;font-size: 15px;"></span>
          <span id="err_pincode_value1" style="color: red;font-size: 15px;"></span>
        </div>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="{{url('')}}/public/front/img/expert-nutritionist.png" alt="You can’t fix your health, until you fix your diet. Reach your health goals with personalised meal plans by our expert nutritionist. " style="max-height: 520px;width: 100%">
      <div class="carousel-caption">
        <h1 class="ff-h1 _38">You can’t fix your health, until you fix your diet. Reach your health goals with personalised meal plans by our expert nutritionist. 
        </h1>
        
       <div class="input-group mx-auto" style="max-width: 460px;">
          <input type="text" class="form-control pincode2" id="command" placeholder="Pincode" maxlength="6"  aria-describedby="basic-addon3" required="required">
          <div class="input-group-append">
            <span class="input-group-text btn btn-darkblue">
              <!-- <a href="https://nutridock.com/subscribe_now" class="text-white btn get-start-btn">Get Started</a> -->
              <button type="submit" value="submit" class="text-white btn get-start-btn" onclick="searchPincode2()">Get Started</button>
            </span>
          </div>
        </div>
        <div class="mx-auto text-left" style="max-width: 460px">
        <span id="err_pincode_not_available2" style="color: red;font-size: 15px;"></span>
        <span id="err_pincode_value2" style="color: red;font-size: 15px;"></span>
      </div>   
    </div>
    </div>
    <div class="carousel-item">
      <img src="{{url('')}}/public/front/img/group-woman.png" alt="Exercise is king. Nutrition is queen. Put them together and you have got a kingdom. Let us help you build your kingdom. " style="max-height: 520px;width: 100%">
      <div class="carousel-caption">
        <h1 class="ff-h1 _38">Exercise is king. Nutrition is queen. Put them together and you have got a kingdom. Let us help you build your kingdom. 
        </h1>
        
        <div class="input-group mx-auto" style="max-width: 460px;">
          <input type="text" class="form-control pincode3" id="command" placeholder="Pincode" maxlength="6" aria-describedby="basic-addon3" required="required">
          <div class="input-group-append">
            <span class="input-group-text btn btn-darkblue">
              <!-- <a href="https://nutridock.com/subscribe_now" class="text-white btn get-start-btn">Get Started</a> -->
              <button type="submit" value="submit" class="text-white btn get-start-btn" onclick="searchPincode3()">Get Started</button>
            </span>
          </div>
        </div>
        <div class="mx-auto text-left" style="max-width: 460px">
        <span id="err_pincode_not_available3" style="color: red;font-size: 15px;"></span>
        <span id="err_pincode_value3" style="color: red;font-size: 15px;"></span>
      </div>
      </div>   
    </div>
    <div class="carousel-item">
      <img src="{{url('')}}/public/front/img/eating-well.png" alt="Eating well is a habit. Cultivate it with our subscription plans customised as per your needs and loaded with flavours. " style="max-height: 520px;width: 100%">
      <div class="carousel-caption">
        <h1 class="ff-h1 _38">Eating well is a habit. Cultivate it with our subscription plans customised as per your needs and loaded with flavours. 
        </h1>
        
       <div class="input-group mx-auto" style="max-width: 460px;">
          <input type="text" class="form-control pincode4" id="command" placeholder="Pincode" maxlength="6" aria-describedby="basic-addon3" required="required">
          <div class="input-group-append">
            <span class="input-group-text btn btn-darkblue">
              <!-- <a href="https://nutridock.com/subscribe_now" class="text-white btn get-start-btn">Get Started</a> -->
              <button type="submit" value="submit" class="text-white btn get-start-btn" onclick="searchPincode4()">Get Started</button>
            </span>
          </div>
        </div>
        <div class="mx-auto text-left" style="max-width: 460px">
          <span id="err_pincode_not_available4" style="color: red;font-size: 15px;"></span>
          <span id="err_pincode_value4" style="color: red;font-size: 15px;"></span>
        </div>
        
      </div>   
    </div>
  </div>
</div>


  <section class="how-to-work">
    <h2>How does it work?</h2>
    <p class="ff-paragraph text-center mx-auto mb-4" style="max-width: 700px;">
      The aim of Nutridock’s subscription plan is to solve your everyday problem of cooking something tasty and filling. Here is how our subscription-based meal delivery service works.
    </p>
    <div class="container-fluid ">
      <div class="row">
        <div class="col-lg-3 col-sm-6 mt-3">
          <div class="ltx-block-icon">
            <div class="in"> 
              <img src="{{url('')}}/public/front/img/lede-gif-1554316333.gif" class="ltx-icon bg-main">
              <!-- <span class="ltx-icon fa fa-cutlery bg-main"></span> -->
              <h2 class="header"> Give your Health Profile </h2>
              <div class="descr">Once you sign up, the first step is letting us know details about your health such as height and weight, lifestyle, medical condition, and personal food choices.</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
          <div class="ltx-block-icon">
            <div class="in"> 
              <img src="{{url('')}}/public/front/img/health-profile.gif" class="ltx-icon bg-main">
              <h2 class="header"> Get a Personal Nutritionist </h2>
              <div class="descr">
                Based on your health details, we will match you with one of our experienced nutritionists. The nutritionist will study your overall health and preferences in detail.
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
          <div class="ltx-block-icon">
            <div class="in"> 
              <img src="{{url('')}}/public/front/img/meal-plan.gif" class="ltx-icon bg-main">
              <h2 class="header"> Customized Meal Plan </h2>
              <div class="descr">
                The nutritionist will curate a perfectly balanced and macro counted meal plan centered around your health needs and goals along with weekly health tracking 
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
          <div class="ltx-block-icon remove-after">
            <div class="in"> 
              <img src="{{url('')}}/public/front/img/delivered-to-your-doorstep.gif" class="ltx-icon bg-main">
              <h2 class="header"> Contactless Doorstep Delivery</h2>
              <div class="descr">Get your breakfast, lunch and dinner daily delivered to you fresh at your doorstep. Your meals will be delivered with all the Covid safety guidelines in place.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="meal-plan-d">
    <div class="container-fluid pl-0 pr-0">
      <div class="row no-gutters">
        <div class="col-4">
          <article class="item__module">
            <figure class="item_img img-intro">
              <img src="{{url('')}}/public/front/img/1-1.jpg" alt="" class="img-fluid">
            </figure>
            <div class="image_content">
              <div class="image_content_inner">
                <div class="wrapper">
                    <div class="item_introtext">
                      80% Nutrition
                    </div>
                  </div>
              </div>
            </div>
          </article>
        </div>
        <div class="col-4">
          <article class="item__module">
            <figure class="item_img img-intro">
              <img src="{{url('')}}/public/front/img/1-2.jpg" alt="" class="img-fluid">
            </figure>
            <div class="image_content">
              <div class="image_content_inner">
                <div class="wrapper">
                    <div class="item_introtext">
                      20% Activity
                    </div>
                  </div>
              </div>
            </div>
          </article>
        </div>
        <div class="col-4">
          <article class="item__module">
            <figure class="item_img img-intro">
              <img src="{{url('')}}/public/front/img/1-3.jpg" alt="" class="img-fluid">
            </figure>
            <div class="image_content">
              <div class="image_content_inner">
                <div class="wrapper">
                    <div class="item_introtext">
                      100% results
                    </div>
                </div>
              </div>
            </div>
          </article>
        </div>
      </div>
    </div>
  </section>
  <section class="What-you-get">
    <div class="container">
      <div class="special-heading text-center mb-4" style="margin-top: -14px;">
        <h3 class="section_header margin_0"> 
          <span class="darkgrey light-weight text-transform-none">What 
            <strong>will you get?</strong> </span> 
          </h3>
         <!--  <p class="mx-auto" style="max-width: 700px">Nutritdock ensures our food has all these qualities and more.Here is a quick view on what you can expect from our subscription plans.</p> -->
      </div>
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
                    <h4 class="box-icon-classic-title"><a href="#">Tailor Made Nutrition</a></h4>
                    <p class="box-icon-classic-text">
                      Our nutritionists create meal plans that are centered around your preferences, body type and medical conditions. The meals are, thus, customized to suit you.
                    </p>
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
                    <h4 class="box-icon-classic-title"><a href="#">Flavoursome Food</a></h4>
                    <p class="box-icon-classic-text">
                      Nutridock is here to bust the myth of ‘healthy food can’t be tasty’. Our food, created by professional chefs, is always a delight for the senses.
                    </p>
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
                    <h4 class="box-icon-classic-title"><a href="#">Sustainable Plan</a></h4>
                    <p class="box-icon-classic-text">
                      Our healthy meal plans are unlike those diets that stay in and out of fashion. Our meal plans have a long-term impact on your overall health. Nothing fad about them, they are here to stay for long!
                    </p>
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
                    <p class="box-icon-classic-text">A personal nutritionist will be assigned to you to create your meal plans, monitor your health, tweak and tailor your diet, and undertake weekly checkups</p>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="Subscription-Plans">
    <div class="container">
     <div class="row">  
      <div class="col-md-6  d-none d-md-block d-lg-block">
        <div class="zig-zag-left-image fit-home"></div>
       <!--  <img src="{{url('')}}/public/front/img/10.jpeg" alt="New York" style="max-height: 520px;width: 100%"> -->
      </div>
      <div class="col-md-6 align-self-center">
        <div class="zig-zac-text-div">
          <h2>Our Subscription Plans</h2>
          <form>
            <div class="form-group">
              <label class="label-control">Number of Meals</label>
              <div class="chk-toolbar has-error">
                @foreach($data['getMealTypeData'] as $getMealTypeData)
                    <input type="checkbox" id="radio{{ $getMealTypeData['meal_type_name'] }}" name="radioFruit[]" data-value="radioFruitValue" class="meal_type_id valid" value="{{ $getMealTypeData['meal_type_id'] }}" onclick="calculatePrice();" required="required" aria-required="true" aria-invalid="false">
                    <label for="radio{{ $getMealTypeData['meal_type_name'] }}">{{ $getMealTypeData['meal_type_name'] }}</label>
                @endforeach
                  <!--<input type="checkbox" id="radioBreakfast" name="radioFruit[]" data-value="radioFruitValue" class="meal_type_id valid" value="1" onclick="calculatePrice();" required="required" aria-required="true" aria-invalid="false">
                    <label for="radioBreakfast">Breakfast</label>
                  <input type="checkbox" id="radioLunch" name="radioFruit[]" data-value="radioFruitValue" class="meal_type_id" value="2" onclick="calculatePrice();" required="required" aria-required="true" aria-invalid="false">
                    <label for="radioLunch">Lunch</label>
                  <input type="checkbox" id="radioSnack" name="radioFruit[]" data-value="radioFruitValue" class="meal_type_id" value="3" onclick="calculatePrice();" required="required" aria-required="true" aria-invalid="false">
                    <label for="radioSnack">Snack</label>
                  <input type="checkbox" id="radioDinner" name="radioFruit[]" data-value="radioFruitValue" class="meal_type_id" value="4" onclick="calculatePrice();" required="required" aria-required="true">
                    <label for="radioDinner">Dinner</label>-->
              </div>

            </div>
            <div class="form-group">
              
              <div class="row">
                <div class="col-4 pr-0 px-md-2">
                  <label class="label-control">Pincode</label>
                  <input type="number" placeholder="Pincode" class="form-control pincode_form" maxlength="6" required="required">
                  

                </div>
                <div class="col-4 ">
                  <label class="label-control">Number&nbsp;of&nbsp;days</label>
                  <select class="form-control" name="radNoOfDays" id="noofdays" onclick="calculatePrice();">
                  @foreach($data['getSubscribeNowPlan']['duration'] as $key => $duration_dtl)
                  <option value="{{ $duration_dtl['subscribe_now_duration'] }}">{{ $duration_dtl['subscribe_now_duration'] }}</option>
                  @endforeach
                  <!--<option>7</option>
                  <option>15</option>
                  <option>30</option>
                  <option>60</option>-->
                </select>
                </div>
                <div class="col-4 col-lg-4 px-0 px-md-2">
                  <span class="Plans-price" style="margin-top: 31px; text-align:left" id="rs_html">Rs.</span>
                  <span class="Plans-price" style="margin-top: 31px; text-align:left" id="final_value"></span>
                  <span style="color:red; font-size: 12px;"><b>* 5% GST applicable</b></span>
                </div>


              </div>
              <div class="row">
                <div class="col-md-12">
                <span id="err_pincode_not_available_form" style="color: red; font-size: 14px;"></span>
                  <span id="err_pincode_value_form" style="color: red; font-size: 14px;"></span>
              </div>
              </div>

            </div>
            <!--<a href="{{url('')}}/subscribe_now" class="btn btn-darkblue text-white">Get Started</a>-->
            <button type="submit" value="submit" class="btn btn-darkblue text-white" onclick="searchPincodeForm()">Get Started</button><br>
            
          </form>
          <a href="{{url('')}}/faq" style="color: #222;" class="d-block mt-3"> <strong style="color: red;">*</strong> Please find answers to all your subscription related queries</a>
        </div>
      </div>
     </div> 
    </div>
  </section>
   
  <!--Only Mobile -->
  <!-- <section class="d-block d-md-none d-lg-none">
    <div class="container">
      <div class="w-100 d-flex justify-content-center mt-3"> 
        <ul class="nav nav-pills Categories-portfolio" role="tablist">
          <li class="nav-item"> <a class="nav-link active pl-3 pr-3" data-toggle="pill" href="#tab1"> 7 </a> </li>
          <li class="nav-item"> <a class="nav-link pl-3 pr-3" data-toggle="pill" href="#tab2"> 15 </a> </li>
          <li class="nav-item"> <a class="nav-link pl-3 pr-3" data-toggle="pill" href="#tab3"> 30 </a> </li>
          <li class="nav-item"> <a class="nav-link pl-3 pr-3" data-toggle="pill" href="#tab4"> 60 </a> </li>
        </ul>
      </div>
      <div class="w-100 d-flex justify-content-center mt-2 text-center">
        <div class="tab-content w-100">
          <div id="tab1" class="tab-pane active filter-active">
            <div>
              <div class="plan-card-title">7 MEALS</div>
              <div class="plane-time-text">per week</div>
              <div class="meal-price-text">$11.49 / meal</div>
              <div class="meal-price-text bottom-padding"> </div>
              <a href="" class="btn btn-success btn-lg">Select the 4 meal plan</a></div>
          </div>
          <div id="tab2" class="tab-pane">
            <div>
              <div class="plan-card-title">15 MEALS</div>
              <div class="plane-time-text">per week</div>
              <div class="meal-price-text">$11.49 / meal</div>
              <div class="meal-price-text bottom-padding"> </div>
              <a href="" class="btn btn-success btn-lg">Select the 6 meal plan</a></div>
          </div>

          <div id="tab3" class="tab-pane">
            <div>
              <div class="plan-card-title">30 Days MEALS</div>
              <div class="plane-time-text">per week</div>
              <div class="meal-price-text">$11.49 / meal</div>
              <div class="meal-price-text bottom-padding"> </div>
              <a href="{{url('')}}/subscribe_now" class="btn btn-success btn-lg">Select the 6 meal plan</a></div>
          </div>

          <div id="tab4" class="tab-pane">
            <div>
              <div class="plan-card-title">60 Days MEALS</div>
              <div class="plane-time-text">per week</div>
              <div class="meal-price-text">$11.49 / meal</div>
              <div class="meal-price-text bottom-padding"> </div>
              <a href="" class="btn btn-success btn-lg">Select the 6 meal plan</a></div>
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <section class="section bg-green"><!-- bg-default -->
    <div class="container">
      <h2 class="title-style-3 text-white font-weight-bold"style="margin-left: -8px;">Menu Highlights</h2>
      <div class="row row-30"> <!-- justify-content-center align-items-center -->
        <div class="col-md-9 col-lg-4 d-none d-md-block d-lg-block p-2">
          <div class="fit-meal-side" style="padding-bottom: 2% !important;"> </div>
        </div>
        <div class="col-md-10 col-lg-8 p-2">
          <div class="fit-meals-child"> 
            <div class="collection-list-wrapper-10 w-dyn-list">
          <div class="row row-30 row-md-40 new-meal-card-parent fit">
            <div class="col-sm-6 col-md-4 col-6  pr-2 mb-3 fit-meal-card"> 
              <article class="product product-3">
                <div class="product-body">
                  <div class="product-figure"><img src="{{url('')}}/uploads/images/15ed36a41ed2238aa0512bff66308d3ac215505d.jpg" class="img-fluid" /> </div>
                  <h5 class="product-title"><a href="">Forbidden Rice Bowl</a></h5>
                  <!-- <div class="product-price-wrap">
                    <div class="product-price"><i class="fa fa-inr" aria-hidden="true"></i> 15.00</div>
                  </div> -->
                  <div class="new-meal-sub-text">Black Rice, Tofu, Herb Vegetables, Peri Peri Sauce</div>
                  <div class="new-meal-cal-and-btn-div fit">
                    <div class="carbs-info">
                      <div class="cal-div gray-color"><div>469</div><div>Cals</div></div>
                      <div class="cal-div gray-color"><div>53 G</div><div>Carbs</div></div>
                      <div class="cal-div gray-color no-border"><div>13.54 G</div><div>Protein</div></div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-4 col-6 pl-2 pr-2 mb-3 fit-meal-card"> 
              <article class="product product-3">
                <div class="product-body">
                  <div class="product-figure"><img src="{{url('')}}/uploads/images/c7996dfb0ea8a0a92346a12cf6673ee6b07c3eb4.jpg" class="img-fluid" /> </div>
                  <h5 class="product-title"><a href="">Raw Brownie Bliss</a></h5>
                   <div class="new-meal-sub-text">Chewy, fudgy, deliciously chocolatey and guilt-free!</div>
                  <div class="new-meal-cal-and-btn-div fit">
                    <div class="carbs-info">
                      <div class="cal-div gray-color"><div>168</div><div>Cals</div></div>
                      <div class="cal-div gray-color"><div>17.7 G</div><div>Carbs</div></div>
                      <div class="cal-div gray-color no-border"><div>4.13 G</div><div>Protein</div></div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-4 col-6 pl-2 pr-2 mb-3 fit-meal-card"> 
              <article class="product product-3">
                <div class="product-body">
                  <div class="product-figure"><img src="{{url('')}}/uploads/images/95c7ae53605c065179545265ef5655305c095cf8.jpg" class="img-fluid" /> </div>
                  <h5 class="product-title"><a href="">Buddha Bowl</a></h5>
                   <div class="new-meal-sub-text">Stir Fried Quinoa, Oriental Wok Tossed Veggies, Sambal Chutney</div>
                  <div class="new-meal-cal-and-btn-div fit">
                    <div class="carbs-info">
                      <div class="cal-div gray-color"><div>225</div><div>Cals</div></div>
                      <div class="cal-div gray-color"><div>32.5 G</div><div>Carbs</div></div>
                      <div class="cal-div gray-color no-border"><div>6.55 G</div><div>Protein</div></div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-4 col-6  pr-2 mb-3 fit-meal-card"> 
              <article class="product product-3">
                <div class="product-body">
                  <div class="product-figure"><img src="{{url('')}}/uploads/images/647399ddc20ecf2f6038977eb876c3bca6dd738b.jpg" class="img-fluid" /> </div>
                  <h5 class="product-title"><a href="">The Indian Wrestler</a></h5>
                   <div class="new-meal-sub-text">Tandoori Cottage Cheese Steak, Coriander, Brown Rice, Kadai Grav</div>
                  <div class="new-meal-cal-and-btn-div fit">
                    <div class="carbs-info">
                      <div class="cal-div gray-color"><div>607</div><div>Cals</div></div>
                      <div class="cal-div gray-color"><div>54 G</div><div>Carbs</div></div>
                      <div class="cal-div gray-color no-border"><div>13.45 G</div><div>Protein</div></div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-4 col-6 pl-2 pr-2 mb-3 fit-meal-card"> 
              <article class="product product-3">
                <div class="product-body">
                  <div class="product-figure"><img src="{{url('')}}/uploads/images/2accb5793e936a81e03b1d280f45dbae8e3bb0eb.jpg" class="img-fluid" /> </div>
                  <h5 class="product-title"><a href="">Sandwich Italiano</a></h5>
                   <div class="new-meal-sub-text">Taking your regular little sandwich a notch up to spectacular</div>
                  <div class="new-meal-cal-and-btn-div fit">
                    <div class="carbs-info">
                      <div class="cal-div gray-color"><div>270</div><div>Cals</div></div>
                      <div class="cal-div gray-color"><div>36.27 G</div><div>Carbs</div></div>
                      <div class="cal-div gray-color no-border"><div>15.97 G</div><div>Protein</div></div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-sm-6 col-md-4 col-6 pl-2 pr-2 mb-3 fit-meal-card"> 
              <article class="product product-3">
                <div class="product-body">
                  <div class="product-figure">
                    <img src="{{url('')}}/uploads/images/91b3d9bf56d3344bec2dda10af5a85d61889f122.jpg" class="img-fluid" /> 
                  </div>
                  <h5 class="product-title"><a href="">AB's Favourite</a></h5>
                   <div class="new-meal-sub-text">Wok Tossed Schezwan Cottage Cheese, Basil Brown Rice, Steamed </div>
                  <div class="new-meal-cal-and-btn-div fit">
                    <div class="carbs-info">
                      <div class="cal-div gray-color"><div>486</div><div>Cals</div></div>
                      <div class="cal-div gray-color"><div>53.3 G</div><div>Carbs</div></div>
                      <div class="cal-div gray-color no-border"><div>7.46 G</div><div>Protein</div></div>
                    </div>
                  </div>
                </div>
              </article>
            </div>
           </div> 
          </div> 
          </div>
        </div>
      </div>
      <div class="helper-div ff text-center">
        
        <!--<a href="{{url('')}}/subscribe_now" class="btn btn-darkblue">Get Started</a>-->
      </div>
    </div>
  </section>
  
  
  <div class="section-2 gray">
    <div class="container">
      <div class="section-title-div">
        <h2>Pure and Fresh</h2>
        <p class="ff-paragraph">
          Eating a fresh and guilt-free meal does wonders for your body and mind. You experience bliss and increase in awareness and energy levels right after you eat a pure meal.
        </p>
      </div>
      <div class="row align-items-stretch justify-content-center">
        <div class="mt-2 col-md-4 col-4 p-2">
          <div class="child-column-fueled text-center">
            <img src="{{url('')}}/public/front/img/perfect-protion.svg" class="img-fluid" width="180">
            <p class="ff-paragraph mt-2">Meals packed with ingredients that satiate you for long.</p>
          </div>
        </div>
        <div class="mt-2 col-md-4 col-4 p-2">
          <div class="child-column-fueled text-center">
            <img src="{{url('')}}/public/front/img/power-macros.svg" class="img-fluid" width="180">
            <p class="ff-paragraph mt-2">Get power in every bite with the goodness of essential nutrients.</p>
          </div>
        </div>
        <div class="mt-2 col-md-4 col-4 p-2">
          <div class="child-column-fueled text-center">
            <img src="{{url('')}}/public/front/img/paleo-keto.svg" class="img-fluid" width="180">
            <p class="ff-paragraph mt-2">Now healthy eating is enjoyable too!</p>
          </div>
        </div>
      </div>

      <div class="container" style="text-align: center;">
        <a href="{{url('')}}/faq#tab2" style="color: #222;" class="d-block mt-3"> <strong style="color: red;">*</strong> Please find answers to all your subscription related queries</a>
      </div>
      
    </div>
  </div>
</main>


<script type="text/javascript">
$(document).ready(function() {
  $('#final_value').hide();
  $('.pincode').focus();
$('.pincode').keydown(function(e) {
    var pincode_value = $(".pincode").val();
    var _token= '{{csrf_token()}}';
    if (e.which === 13) {
    if(pincode_value==''){
    $('#err_pincode_value').html('Please enter value');
  }else{
      $('.pincode').focus();
    $('#err_pincode_value').html('');
    
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if (data.message == 'success') {

        window.location.href = '{{url('')}}/subscribe-now'; 
      }else{
          $('#err_pincode_not_available').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
} 
  });


$('.pincode1').keydown(function(e) {
    var pincode_value1 = $(".pincode1").val();
    var _token= '{{csrf_token()}}';
    if (e.which === 13) {
    if(pincode_value1==''){
    $('#err_pincode_value1').html('Please enter value');
  }else{
      $('.pincode1').focus();
    $('#err_pincode_value1').html('');
    
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value1
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if (data.message == 'success') {

        window.location.href = '{{url('')}}/subscribe-now'; 
      }else{
          $('#err_pincode_not_available1').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
} 
});

$('.pincode2').keydown(function(e) {
    var pincode_value2 = $(".pincode2").val();
    var _token= '{{csrf_token()}}';
    if (e.which === 13) {
    if(pincode_value2==''){
    $('#err_pincode_value2').html('Please enter value');
  }else{
      $('.pincode2').focus();
    $('#err_pincode_value2').html('');
    
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value2
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if (data.message == 'success') {

        window.location.href = '{{url('')}}/subscribe-now'; 
      }else{
          $('#err_pincode_not_available2').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
} 
});

$('.pincode3').keydown(function(e) {
    var pincode_value3 = $(".pincode3").val();
    var _token= '{{csrf_token()}}';
    if (e.which === 13) {
    if(pincode_value3==''){
    $('#err_pincode_value3').html('Please enter value');
  }else{
      $('.pincode3').focus();
    $('#err_pincode_value3').html('');
    
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value3
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if (data.message == 'success') {

        window.location.href = '{{url('')}}/subscribe-now'; 
      }else{
          $('#err_pincode_not_available3').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
} 
});

$('.pincode4').keydown(function(e) {
    var pincode_value4 = $(".pincode4").val();
    var _token= '{{csrf_token()}}';
    if (e.which === 13) {
    if(pincode_value4==''){
    $('#err_pincode_value4').html('Please enter value');
  }else{
      $('.pincode4').focus();
    $('#err_pincode_value4').html('');
    
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value1
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if (data.message == 'success') {

        window.location.href = '{{url('')}}/subscribe-now'; 
      }else{
          $('#err_pincode_not_available4').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
} 
});

});




function searchPincode(){
  var pincode_value = $(".pincode").val();
  console.log(pincode_value);
  var _token= '{{csrf_token()}}';
  if(pincode_value==''){
    $('#err_pincode_value').html('Please enter value');
  }else{
      $('.pincode').focus();
    $('#err_pincode_value').html('');
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if(data.message == 'success'){
          window.location.href = '{{url('')}}/subscribe-now'; 
        }else{
          /*alert('You are already subscribed with us!!');
          return false;*/
          $('#err_pincode_not_available').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
}

function searchPincode1(){
  var pincode_value1 = $(".pincode1").val();
  console.log(pincode_value1);
  var _token= '{{csrf_token()}}';
  if(pincode_value1==''){
    $('#err_pincode_value1').html('Please enter value');
  }else{
      $('.pincode1').focus();
    $('#err_pincode_value1').html('');
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value1
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if(data.message == 'success'){
          window.location.href = '{{url('')}}/subscribe-now'; 
        }else{
          /*alert('You are already subscribed with us!!');
          return false;*/
          $('#err_pincode_not_available1').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
}

function searchPincode2(){
  var pincode_value2 = $(".pincode2").val();
  console.log(pincode_value2);
  var _token= '{{csrf_token()}}';
  if(pincode_value2==''){
    $('#err_pincode_value2').html('Please enter value');
  }else{
      $('.pincode2').focus();
    $('#err_pincode_value2').html('');
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value2
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if(data.message == 'success'){
          window.location.href = '{{url('')}}/subscribe-now'; 
        }else{
          /*alert('You are already subscribed with us!!');
          return false;*/
          $('#err_pincode_not_available2').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
}

function searchPincode3(){
  var pincode_value3 = $(".pincode3").val();
  console.log(pincode_value3);
  var _token= '{{csrf_token()}}';
  if(pincode_value3==''){
    $('#err_pincode_value3').html('Please enter value');
  }else{
      $('.pincode3').focus();
    $('#err_pincode_value3').html('');
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value3
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if(data.message == 'success'){
          window.location.href = '{{url('')}}/subscribe-now'; 
        }else{
          /*alert('You are already subscribed with us!!');
          return false;*/
          $('#err_pincode_not_available3').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
}

function searchPincode4(){
  var pincode_value4 = $(".pincode4").val();
  console.log(pincode_value4);
  var _token= '{{csrf_token()}}';
  if(pincode_value4==''){
    $('#err_pincode_value4').html('Please enter value');
  }else{
      $('.pincode4').focus();
    $('#err_pincode_value4').html('');
  $.ajax({
      type: "POST",
      url: "{{ URL::to('/') }}/search",             
      data: {
      _token: _token,pincode_value: pincode_value4
            },
      'async': false,
      success: function(response){
        console.log(response);
        var data = $.parseJSON(response);
        if(data.message == 'success'){
          window.location.href = '{{url('')}}/subscribe-now'; 
        }else{
          /*alert('You are already subscribed with us!!');
          return false;*/
          $('#err_pincode_not_available4').html('Sorry,we are currently serviceable only in Nashik');
          return false;
        }
      },
  });
}
}

function searchPincodeForm(){
    var pincode_form = $(".pincode_form").val();
    var _token= '{{csrf_token()}}';
    if(pincode_form==''){
      $('#err_pincode_value_form').html('Please enter value');
    }else{
      $('.pincode_form').focus();
      $('#err_pincode_value_form').html('');
    $.ajax({
        type: "POST",
        url: "{{ URL::to('/') }}/searchform",             
        data: {
        _token: _token,pincode_form: pincode_form
              },
        'async': false,
        success: function(response){
          console.log(response);
          var data = $.parseJSON(response);
          if(data.message == 'success'){
            window.location.href = '{{url('')}}/subscribe-now'; 
          }else{
            $('#err_pincode_not_available_form').html('Sorry,we are currently serviceable only in Nashik');
            return false;
          }
        },
    });
  }
}


function calculatePrice()
{
  $('#final_value').show();
  $('#final_value').html('Rs.0');
  $('#rs_html').hide();
  var no_of_days =   $('#noofdays').val();
  var subscribe_now_pkg_price_value = '';
  var subscribe_now_price_per_meal_value = '';
  $.ajax({
        type: "GET",
        url: "{{ URL::to('/') }}/getSubscribeNowPlanDuration/"+no_of_days,             
        dataType: "html",
        'async': false,
        success: function(response){ 
          var obj = $.parseJSON(response);
          var i = 0;
           $.each(obj, function() {
               
            subscribe_now_pkg_price_value =  this[0].subscribe_now_pkg_price;
            subscribe_now_price_per_meal_value =  this[0].subscribe_now_price_per_meal;
          });
          
        }
    });

  var mealtype=0;
  if(subscribe_now_pkg_price_value==0){
  $.each($("input[data-value='radioFruitValue']:checked"), function(){
    mealtype++;
   /* var final_value = no_of_days * mealtype * subscribe_now_price_per_meal_value;
    $('#final_value').html('Rs.'+final_value);
    $('#price').val(final_value);*/ 
    
    var cal_value = no_of_days * mealtype * subscribe_now_price_per_meal_value;
    console.log(subscribe_now_price_per_meal_value);
    
    if(no_of_days==7){
      var percente_amt = cal_value * 5 / 100;
      var final_value = (cal_value - percente_amt);
      var gst_value = final_value * 5 / 100;
      var final_gst_value = final_value + gst_value;

      $('#final_value').html('Rs.'+final_gst_value);
      $('#price').val(final_gst_value);   
      /*$('#final_value_details').html('Rs. 237.5 per meal');
      $('#close_value').html('Rs.'+ cal_value+' for 7 days | Rs. 250 per meal');*/
    }else if(no_of_days==15){
      var percente_amt = cal_value * 12 / 100;
      var final_value = (cal_value - percente_amt);
      var gst_value = final_value * 5 / 100;
      var final_gst_value = final_value + gst_value;

      $('#final_value').html('Rs.'+final_gst_value);
      $('#price').val(final_gst_value);    
      /*$('#final_value_details').html('Rs. 220 per meal'); 
      $('#close_value').html('Rs.'+ cal_value+' for 7 days | Rs. 250 per meal');*/
    }else if(no_of_days==30){
      var percente_amt = cal_value * 20 / 100;
      var final_value = (cal_value - percente_amt);
      var gst_value = final_value * 5 / 100;
      var final_gst_value = final_value + gst_value;

      $('#final_value').html('Rs.'+final_gst_value);
      $('#price').val(final_gst_value);
      /*$('#final_value_details').html('Rs. 200 per meal');   
      $('#close_value').html('Rs.'+ cal_value+' for 7 days | Rs. 250 per meal');*/
    }else if(no_of_days==60){
      var percente_amt = cal_value * 25 / 100;
      var final_value = (cal_value - percente_amt);
      var gst_value = final_value * 5 / 100;
      var final_gst_value = final_value + gst_value;
      
      $('#final_value').html('Rs.'+final_gst_value);
      $('#price').val(final_gst_value);  
      /*$('#final_value_details').html('Rs. 187.5 per meal');      
      $('#close_value').html('Rs.'+ cal_value+' for 7 days | Rs. 250 per meal');*/
    }
  });
  }else{
        alert(2);
  }
}

</script>
@endsection 