<!doctype html>
<html>
<head>
<!--- basic page needs
   ================================================== -->
<meta charset="utf-8">
<title>Nutridock</title>
<meta name="description" content="">
<meta name="author" content="">

<!-- mobile specific metas
   ================================================== -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- CSS
   ================================================== -->
<link rel="stylesheet" href="{{url('')}}/public/landing/css/base.css">
<link rel="stylesheet" href="{{url('')}}/public/landing/css/vendor.css">
<link rel="stylesheet" href="{{url('')}}/public/landing/css/main.css">


<!-- Favicons -->
<link href="{{url('')}}/public/landing/assets/img/favicon.png" rel="icon">
<link href="{{url('')}}/public/landing/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '787474255350064');
fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=787474255350064&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-177525089-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-177525089-1');
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-M4D4D79');</script>
<!-- End Google Tag Manager -->
    <style>
body { margin-top: 0; }

#container {
  max-width: 1000px;
  margin: 0 auto;
  background: #EEE;
}


#fvpp-blackout {
  display: none;
  z-index: 499;
  position: fixed;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background: #000;
  opacity: 0.5;
}

#my-welcome-message {
  display: none;
  z-index: 500;
  position: fixed;
  width: 36%;
  left: 30%;
  top: 20%;
  padding: 20px 2%;
  font-family: Calibri, Arial, sans-serif;
  background: #FFF;
}

#fvpp-close {
  position: absolute;
  top: 10px;
  right: 20px;
  cursor: pointer;
}

#fvpp-dialog h2 {
  font-size: 2em;
  margin: 0;
}

#fvpp-dialog p { margin: 0; }
</style>
    </head>

    <body id="top">

      <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-M4D4D79"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<!-- header 
   ================================================== -->

   <header id="header">
  <div class="row" style="position: relative;">
    <div class="header-logo"> <a href="{{url('/')}}">Nutridock</a> </div>
    <nav id="header-nav-wrap">
      <ul class="header-main-nav">
        <li class="current"><a class="smoothscroll"  href="#home" title="Home">Home</a></li>
        <li><a class="smoothscroll"  href="#about" title="About Us">About Us</a></li>
        <li><a class="smoothscroll"  href="#webinar" title="Webinar">Webinar</a></li>
        <li><a class="smoothscroll"  href="#survey" title="Survey Questions">Survey Questions</a></li>
        <li><a class="smoothscroll"  href="#download" title="Contact Us">Contact Us</a></li>
      </ul>
      <!-- <a href="#" title="sign-up" class="button button-primary cta">Sign Up</a> --> 
    </nav>
    <a class="header-menu-toggle" href="#"><span>Menu</span></a> </div>
</header>
<!-- /header --> 


<!-- home
   ================================================== -->

<section id="home" data-parallax="scroll" data-image-src="{{url('')}}/public/landing/images/hero-bg.jpg" data-natural-width=3000 data-natural-height=2000>
  <div class="overlay"></div>
  <div class="home-content">
    <div class="row contents">
      <div class="home-content-left">
        <h3 data-aos="fade-up">Coming Soon</h3>
        <h1 data-aos="fade-up"> Welcome on <br>
          the journey to mindful <br>
          eating & living. </h1>
        <div class="buttons" data-aos="fade-up" style="margin-bottom: 2rem;"> <a href="#webinar" class="smoothscroll button stroke" style="text-transform: uppercase;"> <span class="icon-circle-down" aria-hidden="true"></span> Register For Webinar </a> 
        </div>
      </div>
      <div class="home-image-right"> 
      <img src="{{url('')}}/public/landing/images/iphone-app-470.png" srcset="{{url('')}}/public/landing/images/iphone-app-470.png 1x, {{url('')}}/public/landing/images/iphone-app-470.png 2x"><!-- data-aos="fade-up" --> 
      </div>
    </div>
  </div>
  <!-- end home-content -->
  
  <ul class="home-social-list">
    <li> <a href="https://www.facebook.com/nutridock0/"><i class="fa fa-facebook-square"></i></a> </li>
    <li> <a href="https://instagram.com/nutri_dock?igshid=1iz93rjouag24"><i class="fa fa-instagram"></i></a> </li>
  </ul>
  <!-- end home-social-list -->
  
  <div class="home-scrolldown"> <a href="#about" class="scroll-icon smoothscroll"> <span>Scroll Down</span> <i class="icon-arrow-right" aria-hidden="true"></i> </a> </div>
</section>
<!-- end home --> 

<!-- about  ================================================== -->
<section id="about">
  <div class="row about-intro">
    <div class="col-four">
      <h1 class="intro-header" data-aos="fade-up">About Our App</h1>
    </div>
    <div class="col-eight">
      <p class="lead" data-aos="fade-up"> It’s not about dieting. It’s about eating right. Get personalised meal plans, recipes & immunity tips tailor-made for your lifestyle, on the Nutridock app </p>
    </div>
  </div>
  <div class="row about-features">
    <div class="features-list block-1-3 block-m-1-2 block-mob-full group">
      <div class="bgrid feature" data-aos="fade-up"> <span class="icon"> <img src="{{url('')}}/public/landing/images/mission.svg"> </span>
        <div class="service-content">
          <h3>Our Mission</h3>
          <p>To impart knowledge about the importance of good nutrition in the journey to physical, mental and emotional well-being. </p>
        </div>
      </div>
      <!-- /bgrid -->
      
      <div class="bgrid feature" data-aos="fade-up"> <span class="icon"><img src="{{url('')}}/public/landing/images/goal.svg"></span>
        <div class="service-content">
          <h3>Our Vision</h3>
          <p>To be the go-to source of information about food and nutrition, and educate people so that healthy living comes naturally. </p>
        </div>
      </div>
      <!-- /bgrid -->
      
      <div class="bgrid feature" data-aos="fade-up"> <span class="icon"><img src="{{url('')}}/public/landing/images/target.svg"></span>
        <div class="service-content">
          <h3>Our Approach</h3>
          <p>Log your daily meals, get personalised nutrition advice and grow fitter while eating all the foods you love! </p>
        </div>
      </div>
      <!-- /bgrid --> 
      
    </div>
    <!-- end features-list --> 
    
  </div>
  <!-- end about-features --> 
  
</section>
<!-- end about -->


<section id="webinar">
  <div class="row pricing-content">
    <div class="col-four pricing-intro"> 
      <img src="{{url('')}}/public/landing/images/webinar.jpg"> 
    </div>
    <div class="col-eight pricing-table">
      <h1 class="intro-header aos-init aos-animate" data-aos="fade-up">Our Webinar</h1>
      <div class="">
        <p class="lead" style="font-size: 18px;margin-bottom: 10px;">
          Understand the impact of daily food and nutrition intake on your mental health and well-being with our experienced coaches.    
        </p>
        <ul class="topics-covered-1">
         <h2>Topics covered in the entirety of the webinar</h2>
          <li>
              <span>1</span> Depression and its domination of the modern world 
            </li>
            <li>
              <span>2</span> The Deafening Claws Of Stress
            </li>
            <li>
              <span>3</span> How to overcome emotional/stress eating 
            </li>
            <li>
              <span>4</span> Learn about ingredients that target particular low moods 
            </li>
            <li>
              <span>5</span> Link between diet and resilience 
            </li>
            <li>
              <span>6</span> Simple and Easy Diets and Daily Habits 
            </li>
            <li>
              <span>7</span> Strategies to sleep better
            </li>
            <li>
              <span>8</span> Busting myths with factual data across nutrition and mental health
            </li>
            <li style="margin: 0px;min-height: auto;"><a  href="#our-webinar">Read More</a></li>

            <li style="margin: 0px;min-height: auto;">Registtation Close</li>
        </ul>
      </div>
       
       <!--  <ul class="row p-0 mb-0">
          <li class="col-twelve mt-2" style="list-style: none;">
            <div class="ginput_container ginput_container_email">
              <a href="http://localhost/rushabh/nutridock_register">
              <div class="left"></div>
              Register Now
              <div class="right"></div>
              </a>
            </div>
          </li>
        </ul> -->
    </div>
  </div>
</section>

<section id="survey">
  <div class="row about-how">
    <h1 class="intro-header" data-aos="fade-up">Help Us Serve You Better</h1>
    <script>
         @if (session('success'))
        //Swal.fire( 'You clicked the button!','success')
         Swal.fire("{{ session('success') }}");
         @endif
    
         @if (session('payment_success'))
        //Swal.fire( 'You clicked the button!','success')
         Swal.fire("{{ session('payment_success') }}");
         @endif  
         
         @if (session('subscription_success'))
         Swal.fire("{{ session('subscription_success') }}");
         @endif
      </script>
    <form action="{{url('/')}}/survey" method="post">
      {{csrf_field()}}
      <div class="about-how-content" data-aos="fade-up">
        <div class="about-how-steps block-1-2 block-tab-full group">
          <div class="col-twelve step">
            <h3>Would you want to download a nutrition app to help you keep a check on your nutritional needs?</h3>
            <div class="custom-control custom-radio custom-control-inline">
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="customRadio" name="download_app" value="Yes" required onchange="show(this.value)" checked="checked" >
                <label class="custom-control-label" for="customRadio" id="btnShowHide"> Yes </label>
              </div>
              <div class="custom-control custom-radio custom-control-inline">
                <input type="radio" class="custom-control-input" id="customRadio2" name="download_app" value="No" onchange="show2()">
                <label class="custom-control-label" for="customRadio2" id="close"> No </label>
              </div>
            </div>
          </div>
          <div class="col-twelve step" id="divShowHide">
            <h3>The most important feature you look in a nutrition app?</h3>
            <p>
              <textarea name="comments" class="w-100 form-control-answer" placeholder="Please enter your comment"></textarea>
            </p>
          </div>
          <div class="col-twelve step" id="divShowHide1" style="display: none;">
            <h3>What refrains you from using a nutrition app?</h3>
            <p>
              <textarea name="refrains" class="w-100 form-control-answer" placeholder="Please enter your comment"></textarea>
            </p>
          </div>
          <div class="question-body">
            <button type="submit" class="btn btn-success" > <!-- style="--content: 'Submit Your Answer';" -->
            <div class="left"></div>
            Submit Your Answer
            <div class="right"></div>
            </button>
          </div>
        </div>
      </div>
    </form>
    <!-- end about-how-content --> 
    
  </div>
</section>

<!-- download
    ================================================== -->
<section id="download">
  <div class="row">
    <div class="col-full">
      <h1 class="intro-header"  data-aos="fade-up">Subscribe to get the free guide to easy and enjoyable nutrition!</h1>
      <form action="{{url('/')}}/subscription" method="post" id="mc-form">
        {{csrf_field()}}
        <div class="subscribe-form" data-aos="fade-up">
          <input type="email" name="email" placeholder="Enter your email" required>
          <input type="submit" value="Subscribe">
        </div>
        <!-- <div class="mt-2">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your notification request was sent. Thank you!</div>
          </div> -->
      </form>
    </div>
  </div>
</section>
<!-- end download --> 


<!-- footer
    ================================================== -->
<section class="page-section" id="contact" data-aos="fade-up">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-twelve mx-auto text-center">
        <h2 class="mt-0">Let's Get In Touch!</h2>
        <hr class="divider my-4">
        <p class="text-muted mb-5" style="max-width: 600px;margin: 0px auto 3rem;"> Give us a call or send us an email and we will get back to you as soon as possible!</p>
      </div>
    </div>
    <div class="row" style="max-width: 700px;">
      <div class="col-six ml-auto text-center mb-5 mb-lg-0"> <i class="fa fa-phone fa-3x mb-3 text-muted"></i>
        <div>+91 9130090666</div>
      </div>
      <div class="col-six mr-auto text-center"> <i class="fa fa-envelope fa-3x mb-3 text-muted"></i> <br/>
        <!-- Make sure to change the email address in BOTH the anchor text and the link target below!--> 
        <a class="d-block" href="mailto:marketing@nutridock.com ">marketing@nutridock.com </a> </div>
    </div>
  </div>
</section>


<div id="our-webinar" class="overlay-1">
  <div class="popup-1">
    <h2>Webinar Details</h2>
    <a class="close" href="#webinar">&times;</a>
    <div class="content">
          <p> 
      Are you someone who’s suffering from some mental health issues? Do you know the food and nutrition you intake make the foundation of your 
            happiness? Well, don’t you agree that good food brings the good mood? 
          </p>
          <p>  
            Think about it. Your brain is always “on.” It takes care of your thoughts and movements, your breathing, your senses — it works hard 24/7, 
            .even while you’re asleep. This means your brain requires a constant supply of fuel. That “fuel” comes from the foods you eat — and what’s in 
            that fuel makes all the difference.
      </p>
          <h3 class="title-web-pop">Topics covered in the entirety of the webinar</h3>
          <ul class="topics-covered">
            <li>
              Depression and its domination of the modern world 
            </li>
            <li>
              The Deafening Claws Of Stress  
            </li>
            <li>
              How to overcome emotional/stress eating
            </li>
            <li>
              Learn about ingredients that target particular low moods
            </li>
            <li>
              Link between diet and resilience
            </li>
            <li>Simple and Easy Diets and Daily Habits</li>
            <li>Strategies to sleep better</li>
            <li>Busting myths with factual data across nutrition and mental health</li>
          </ul>
          
          <p>
            If you’re someone who is fighting a war against mental trauma and want to start feeling better, this webinar is for you. 
            We can make a difference in such a simple way. 
          </p>
          <p>
            Join us for a talk show to harness the power of nutrition to stay calm and well, which will last about 45 mins with a 15 min live
            Q&A session. Only limited seats available!!
          </p>
          
          <h3 class="title-web-pop">Event Details</h3>  
          <ul class="event-detail">
            <li>
              <span class="event-topic">Topic </span> : &nbsp; “Role of Nutrition on Mental Well Being”
            </li>
            <li>
              <span class="event-topic"> Date </span> : &nbsp; 19th Sept’20
            </li>
            <li>
              <span class="event-topic"> Time </span> : &nbsp; 5 pm - 6 pm
            </li>
            <li>
              <span class="event-topic"> Venue  </span> : &nbsp; Zoom
            </li>
            <li><span class="event-topic"> Fee </span> : &nbsp; Rs 150 </li>
          </ul>
          
          <div class="ginput_container ginput_container_email" style="
    margin: 3rem auto;">
              <a href="http://localhost/rushabh/nutridock_register">
              <div class="left"></div>
              1Register Now
              <div class="right"></div>
              </a>
            </div>
          
          <div class="alert alert-info">
            Take a walk with us in this journey of the mind and we promise to guide you through every step of the way.  
          </div>
    </div>
  </div>
</div>
<!-- Java Script
    ================================================== --> 


<!-- The Modal -->


<div id="container">
          <h1>jQuery First Visit Popup Demo</h1>
          <p><a id="show-message">Show mesage again</a></p>
        </div>


<div id="my-welcome-message" class="modal">
          <div class="modal-content">
    <h3>Upcoming Webinar!</h3>
    <span class="close close_window">&times;</span>
    <p class="lead-1">Do you know the impact of daily food and nutrition intake on your mental health?  If you’re someone who is fighting a war against mental trauma and want to start feeling better, this webinar is for you.</p>
     <span class="modal-date">Date: 19th Sept’20, 5 pm </span>
     <p class="btn-modal">
     <a href="#webinar" class="btn btn-dark close_window">Read more</a>
     </p>
  </div>
        </div>


<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>  -->
<script src="http://localhost/nutridock/public/landing/js/jquery-2.1.3.min.js"></script> 

<script src="http://localhost/nutridock/public/landing/jquery.firstVisitPopup.js"></script> 

<script src="{{url('')}}/public/landing/js/plugins.js"></script> 
<script src="{{url('')}}/public/landing/js/main.js"></script> 
<script src="{{url('')}}/public/landing/assets/vendor/jquery.easing/jquery.easing.min.js"></script> 
<script src="{{url('')}}/public/landing/assets/vendor/php-email-form/validate.js"></script> 


<script type="text/javascript"> 
   jQuery(document).ready(function(){
   /* jQuery('#btnShowHide').on('click', function(event) {    
   
        jQuery('#divShowHide').toggle('show');
        jQuery('#divShowHide1').toggle('hide');
      });*/

      jQuery('#close').on('click', function(event) {    
      //console.log(2);    
          jQuery('#divShowHide').toggle('hide');
          jQuery('#divShowHide1').toggle('hide');
      });
      
      
      jQuery('.close_window').on('click', function(event) { 
          jQuery('#myModal').toggle('hide');
      });
      
     
  });
  
</script>

<script type="text/javascript">
    function show(str){
        document.getElementById('divShowHide1').style.display = 'none';
        document.getElementById('divShowHide').style.display = 'block';
    }
    function show2(sign){
        document.getElementById('divShowHide1').style.display = 'block';
        document.getElementById('divShowHide').style.display = 'none';
    }
</script>


<script>
      $(function () {
        $('#my-welcome-message').firstVisitPopup({
          cookieName : 'homepage28',
          showAgainSelector: '#show-message'
        });
      });
    </script>
</body>
</html>
