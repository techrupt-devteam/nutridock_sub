@extends('layouts.master') 
@section('content') 
<link rel="stylesheet" href="{{url('')}}/public/front/css/subscribe.css" />
<main>
   <!-- <div id="demo" class="carousel slide" data-ride="carousel">
      <div class="carousel-inner">
         <div class="carousel-item active">
            <img src="{{url('')}}/public/front/img/proper-nutrition.png" alt="Proper nutrition is the key to unlock your full potential. Subscribe to our meals daily and enjoy abundant health and deliciousness." style="width: 100%">
         </div>
         <div class="carousel-item">
            <img src="{{url('')}}/public/front/img/Pre-workout.png" alt="Pre-workout nutrition is necessary for performance and post-workout nutrition is necessary for progress." style="width: 100%">
         </div>
         <div class="carousel-item">
            <img src="{{url('')}}/public/front/img/expert-nutritionist.png" alt="You can’t fix your health, until you fix your diet. Reach your health goals with personalised meal plans by our expert nutritionist. " style="width: 100%">
         </div>
         <div class="carousel-item">
            <img src="{{url('')}}/public/front/img/group-woman.png" alt="Exercise is king. Nutrition is queen. Put them together and you have got a kingdom. Let us help you build your kingdom. " style="width: 100%">    
         </div>
         <div class="carousel-item">
            <img src="{{url('')}}/public/front/img/eating-well.png" alt="Eating well is a habit. Cultivate it with our subscription plans customised as per your needs and loaded with flavours. " style="width: 100%">
         </div>
      </div>
   </div> -->
   <section class="banner-section-top">
      <div  class="banner-shape">
         <img  src="{{url('')}}/public/front/img/shape/shape1.png" alt="Shape">
         <img  src="{{url('')}}/public/front/img/shape/shape2.png" alt="Shape">
         <img  src="{{url('')}}/public/front/img/shape/shape3.png" alt="Shape">
         <img  src="{{url('')}}/public/front/img/shape/banner-shape.png" alt="Shape">
      </div>
      <div class="container">
         <div class="row">
            <div class="col-md-6 align-self-center">
               <div class="">
                  <div class="select-our-plan-new">
                     <div class="align-self-center">
                        <div class="zig-zac-text-div">
                           <form  role="form" id="frm-subscribe-info" data-parsley-validate="parsley">
                              <div class="row">
                                 <div class="col-12">
                                    <span class="darkgrey light-weight text-transform-none">
                                       <h1 class="header mt-2 pt-2 mb-4"> Pre-workout nutrition is necessary for performance, Post-workout nutrition is necessary for progress. </h1>
                                    </span>
                                 </div>
                              </div>
                              <div class="form-group" data-parsley-validate="parsley">
                                 <div class="row">
                                   <div  class="col-12 pb-2">
                                   <a href="{{url('')}}/faq" class="d-block text-dark my-2"> 
                                     <strong style="color: red;">*</strong> 
                                     Please find answers to all your subscription related queries
                                     </a>
                                   </div>                 
                                    <div class="col-12 col-md-9">                    
                                       <div class="input-group mx-auto">
                                          <input type="number" class="form-control pincode" maxlength="6" placeholder="Pincode"  data-parsley-type="digits" data-parsley-length="[6,6]" data-parsley-zip="in" data-parsley-errors-container="#zip-errors" name="pincode" id="pincode" required="required" autocomplete="off" maxlength="6">
                                          <div class="input-group-append">
                                             <button type="button" value="button" class="text-white btn get-start-btn btn btn-darkblue" onclick="chkValidPin()">Get Started</button>
                                          </div>                           
                                       </div>  
                                       <div id="errValidZip" style="color: red; font-size: 14px;" class="text-center" ></div>                     
                                    </div>                    
                                 </div>         
                                 <div class="row">
                                    <div class="col-md-12">
                                       <span id="zip-errors" style="color: red; font-size: 14px;" ></span>                        
                                    </div>
                                 </div>
                              </div>
                           </form>           
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6">
               <!-- <div class="bg-gradient-img">
                  <img src="{{url('')}}/public/front/img/foodNew.png" class="right-sideBanner img-fluid"/>
            </div> -->
            <div id="demo" class="carousel slide" data-ride="carousel">
               <div class="carousel-inner">
                  <div class="carousel-item active">
                     <img src="{{url('')}}/public/front/img/banner-1.png" alt="Proper nutrition is the key to unlock your full potential. Subscribe to our meals daily and enjoy abundant health and deliciousness." style="width: 100%">
                  </div>
                  <div class="carousel-item">
                     <img src="{{url('')}}/public/front/img/banner-2.png" alt="Pre-workout nutrition is necessary for performance and post-workout nutrition is necessary for progress." style="width: 100%">
                  </div>
                  <div class="carousel-item">
                     <img src="{{url('')}}/public/front/img/banner-3.png" alt="You can’t fix your health, until you fix your diet. Reach your health goals with personalised meal plans by our expert nutritionist. " style="width: 100%">
                  </div>
               </div>
            </div>
         </div>
         </div>
      </div>
   </section>
  
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
                     <img src="{{url('')}}/public/front/img/Health-Profile.svg" class="ltx-icon bg-main">
                     <!-- <span class="ltx-icon fa fa-cutlery bg-main"></span> -->
                     <h2 class="header"> Give your Health Profile </h2>
                     <div class="descr">Once you sign up, the first step is letting us know details about your health such as height and weight, lifestyle, medical condition, and personal food choices.</div>
                  </div>
               </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 mt-3">
               <div class="ltx-block-icon">
                  <div class="in">
                     <img src="{{url('')}}/public/front/img/Personal-Nutritionist.svg" class="ltx-icon bg-main">
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
                     <img src="{{url('')}}/public/front/img/meal-plan.svg" class="ltx-icon bg-main">
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
                     <img src="{{url('')}}/public/front/img/Doorstep-Delivery.svg" class="ltx-icon bg-main">
                     <h2 class="header"> Contactless Doorstep Delivery</h2>
                     <div class="descr">Get your breakfast, lunch and dinner daily delivered to you fresh at your doorstep. Your meals will be delivered with all the Covid safety guidelines in place.</div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="section bg-green">
      <!-- bg-default -->
      <div class="container">
         <h2 class="title-style-3 text-white mb-3 font-weight-bold"style="margin-left: -8px;"> Menu Highlights </h2>
         <div class="row row-30">
            <!-- justify-content-center align-items-center -->
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
                                 <div class="new-meal-sub-text">Black Rice, Tofu, Herb Vegetables, Peri Peri Sauce</div>
                                 <div class="new-meal-cal-and-btn-div fit">
                                    <div class="carbs-info">
                                       <div class="cal-div gray-color">
                                          <div>469</div>
                                          <div>Cals</div>
                                       </div>
                                       <div class="cal-div gray-color">
                                          <div>53 G</div>
                                          <div>Carbs</div>
                                       </div>
                                       <div class="cal-div gray-color no-border">
                                          <div>13.54 G</div>
                                          <div>Protein</div>
                                       </div>
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
                                       <div class="cal-div gray-color">
                                          <div>168</div>
                                          <div>Cals</div>
                                       </div>
                                       <div class="cal-div gray-color">
                                          <div>17.7 G</div>
                                          <div>Carbs</div>
                                       </div>
                                       <div class="cal-div gray-color no-border">
                                          <div>4.13 G</div>
                                          <div>Protein</div>
                                       </div>
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
                                       <div class="cal-div gray-color">
                                          <div>225</div>
                                          <div>Cals</div>
                                       </div>
                                       <div class="cal-div gray-color">
                                          <div>32.5 G</div>
                                          <div>Carbs</div>
                                       </div>
                                       <div class="cal-div gray-color no-border">
                                          <div>6.55 G</div>
                                          <div>Protein</div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </article>
                        </div>
                        <div class="col-sm-6 col-md-4 col-6  pr-2 mb-3 fit-meal-card">
                           <article class="product product-3">
                              <div class="product-body">
                                 <div class="product-figure">
                                 <img src="{{url('')}}/uploads/images/647399ddc20ecf2f6038977eb876c3bca6dd738b.jpg" class="img-fluid" /> 
                                 </div>
                                 <h5 class="product-title">
                                 <a href="">The Indian Wrestler</a></h5>
                                 <div class="new-meal-sub-text">
                                 Tandoori Cottage Cheese Steak, Coriander, Brown Rice, Kadai Grav
                                 </div>
                                 <div class="new-meal-cal-and-btn-div fit">
                                    <div class="carbs-info">
                                       <div class="cal-div gray-color">
                                          <div>607</div>
                                          <div>Cals</div>
                                       </div>
                                       <div class="cal-div gray-color">
                                          <div>54 G</div>
                                          <div>Carbs</div>
                                       </div>
                                       <div class="cal-div gray-color no-border">
                                          <div>13.45 G</div>
                                          <div>Protein</div>
                                       </div>
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
                                       <div class="cal-div gray-color">
                                          <div>270</div>
                                          <div>Cals</div>
                                       </div>
                                       <div class="cal-div gray-color">
                                          <div>36.27 G</div>
                                          <div>Carbs</div>
                                       </div>
                                       <div class="cal-div gray-color no-border">
                                          <div>15.97 G</div>
                                          <div>Protein</div>
                                       </div>
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
                                       <div class="cal-div gray-color">
                                          <div>486</div>
                                          <div>Cals</div>
                                       </div>
                                       <div class="cal-div gray-color">
                                          <div>53.3 G</div>
                                          <div>Carbs</div>
                                       </div>
                                       <div class="cal-div gray-color no-border">
                                          <div>7.46 G</div>
                                          <div>Protein</div>
                                       </div>
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
/* check deleivery location*/
function chkValidPin()
{
  $("#errValidZip").html('');
  if(true === $('#frm-subscribe-info').parsley().validate()) {
      $.ajax({
        type: "POST",
        url:  "{{ URL::to('/') }}/check_valid_pin",
          data: {
          pincode : $("#pincode").val(),
          },
        success: function (data) {          
          if(data != ''){ 
            location.href = "{{ URL::to('/') }}/sign-up";
          } else {
            $("#errValidZip").html('Sorry we are not delivering at '+ $("#pincode").val());
            return false;
          }
        },
        error: function (data) {        
          return false;
        },
      }); 
  }  
}   

</script>
@endsection