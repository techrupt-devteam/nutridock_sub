<!DOCTYPE html>
<html class="no-js" lang="en">

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

<!-- script
   ================================================== -->
<script src="{{url('')}}/public/landing/js/modernizr.js"></script>
<script src="{{url('')}}/public/landing/js/pace.min.js"></script>

<!-- Favicons -->
<link href="{{url('')}}/public/landing/assets/img/favicon.png" rel="icon">
<link href="{{url('')}}/public/landing/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script> 
</head>

<!-- <div id="preloader">
  <div id="loader"></div>
</div> -->

<body id="top">
<!-- header 
   ================================================== -->
<header id="header">
 <div class="row" style="position: relative;">  
  <div class="header-logo"> 
    <a href="{{url('/')}}">Nutridock</a> 
  </div>
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
  <a class="header-menu-toggle" href="#"><span>Menu</span></a> 
 </div> 
</header>
<!-- /header --> 

<!-- home
   ================================================== -->
<section id="webinar">
  <div class="row pricing-content">
    <div class="col-four pricing-intro">
            <img src="{{url('')}}/public/landing/images/webinar.jpg">
        </div>
        <div class="col-eight pricing-table">
          <h1 class="intro-header aos-init aos-animate" data-aos="fade-up">Our Webinar</h1>
           <form id="web_order_summery_form" action="{{url('/')}}/capture_payment" method="post">
            {{csrf_field()}}
            <small id="err_details" style="color:red;"></small>
          <ul class="row p-0 mb-0">
              
                <li class="col-six mt-2" style="list-style: none;">
                    
                  <label class="gfield_label">Full Name <span class="gfield_required" style="color: red;">*</span></label>
                  <div class="ginput_container ginput_container_text">
                    <input type="text" id="name" autocomplete="off" name="name" value="<?php echo $status['name']; ?>" readonly="readonly">
                    <input type="hidden" id="token_id" name="token_id" value="<?php echo $status['id']; ?>">
                  </div>
                </li>
                
                <li class="col-six mt-2" style="list-style: none;">
                  <label class="gfield_label">Email Id <span class="gfield_required" style="color: red;">*</span></label>
                  <div class="ginput_container ginput_container_email">
                    <input type="email" id="email" name="email" value="<?php echo $status['email']; ?>" autocomplete="off" readonly="readonly">
                  </div>
                </li>
                <li class="col-six col-lg-3 mt-2" style="list-style: none;">
                  <label class="gfield_label"> Phone <span class="gfield_required" style="color: red;">*</span></label>
                  <div class="ginput_container ginput_container_email">
                    <input type="text" id="mobile" name="mobile" value="<?php echo $status['mobile']; ?>" maxlength="10" autocomplete="off" readonly="readonly">
                  </div>
                </li>
                <li class="col-six col-lg-3 mt-2" style="list-style: none;">
                  <label class="gfield_label"> Age <span class="gfield_required" style="color: red;">*</span></label>
                  <div class="ginput_container">
                    <input type="text" id="age" name="age" value="<?php echo $status['age']; ?>" readonly="readonly">
                  </div>
                </li>
                <li class="col-six mt-2" style="list-style: none;">
                  <label class="gfield_label">City</label>
                  <div class="ginput_container">
                    <input type="text" id="city" name="city" value="<?php echo $status['city']; ?>" autocomplete="off" readonly="readonly"> 
                  </div>
                </li>
                <li class="col-twelve mt-2" style="list-style: none;">
                  <div class="ginput_container ginput_container_email text-center">
                    <button type="button" id="rzp-button" style="--content:">
                      <div class="left"></div>
                        Pay Now
                      <div class="right"></div>  
                    </button>
                  </div>
                </li>
                <li class="col-12 mt-4" style="list-style: none;">
                <div class="ginput_container ginput_container_email text-center">
                  <input type="hidden" id="razorpay_payment_id" name="razorpay_payment_id">
                </div>
              </li>
              </ul>
            </form>  
        </div>
   </div>
</section>
<!-- Java Script
    ================================================== --> 
  <?php
  $amt       = 150;
  $amt_value = $amt.'00';
?>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script src="{{url('')}}/public/landing/js/jquery-2.1.3.min.js"></script> 
<script src="{{url('')}}/public/landing/js/plugins.js"></script> 
<script src="{{url('')}}/public/landing/js/main.js"></script>
<script src="{{url('')}}/public/landing/assets/vendor/jquery.easing/jquery.easing.min.js"></script> 
<script src="{{url('')}}/public/landing/assets/vendor/php-email-form/validate.js"></script> 
<!--<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>-->
  <!--<script type="text/javascript">
    Swal.fire({
      title: '<strong>Thanks for connecting with us.</strong>',
      icon: 'success',
      html:
        'We will get back to you soon. ' +
        '<a href="">Nutridock</a> ' +
        'Thank You',
      showCloseButton: true,
      showCancelButton: true,
      focusConfirm: false,
      confirmButtonText:
        '<i class="fa fa-thumbs-up"></i> Ok',
      confirmButtonAriaLabel: 'Thumbs up, great!',
      
    })
  </script>-->
  <!-- Template Main JS File -->
  <script type="text/javascript"> 
   jQuery(document).ready(function(){
    jQuery('#btnShowHide').on('click', function(event) {    
    //console.log(1);    
        jQuery('#divShowHide').toggle('show');
        jQuery('#divShowHide1').toggle('hide');
      });

      jQuery('#close').on('click', function(event) {    
      //console.log(2);    
          jQuery('#divShowHide').toggle('hide');
          jQuery('#divShowHide1').toggle('hide');
      });
  });
</script>
<script type="text/javascript">
    $('#datepicker').datepicker({
        weekStart: 1,
        daysOfWeekHighlighted: "6,0",
        autoclose: true,
        todayHighlight: true,
    });
    $('#datepicker').datepicker("setDate", new Date());
</script>

 <script type="text/javascript">
    var url = "{{url('')}}";
    var name = $('#name').val();
    var email = $('#email').val();
    var age = $('#age').val();
    var mobile = $('#mobile').val();
    var city = $('#city').val();
    var options = {
    "key": "rzp_test_P1IkeYutI76ExB", 
    //"key": "rzp_test_EDuPsXnNFa3Atn", 
    //"amount": 100, 
    "amount": "15000", 
    "currency": "INR",
    "name": "Nutridock -",
    "description": "",
    "image": "http://localhost/nutridock/public/landing/assets/img/nutridock.svg",

    "handler": function (response){
      console.log(response);
      $('#razorpay_payment_id').val(response.razorpay_payment_id);
      document.getElementById("web_order_summery_form").submit();
    },
    "prefill": {
        "name": name,
        "email": email,
        "contact": mobile,
        "age": age,
    },
    "notes": {
        "address": city
    },
    "theme": {
        "color": "#000"
    }
};
var rzp1 = new Razorpay(options);
document.getElementById('rzp-button').onclick = function(e){
var name_value = $('#name').val();
var email_value = $('#email').val();
var mobile_value = $('#mobile').val();
var age_value = $('#age').val();
var city_value = $('#city').val();
var token = $('#_token').val();

  if(name_value!='' && email_value!='' && mobile_value!='' && age_value!=''){
  rzp1.open();
  e.preventDefault();


   $.ajax({
    url:"{{url('/')}}/capture_payment",
    type:"POST",
    data:{
      name_value:name_value,email_value:email_value,mobile_value:mobile_value,age_value:age_value,city_value:city_value,_token: token
    },

    success:function(data){
      console.log(data);
      //var result1=JSON.parse(data);
      /*var result =  result1.toFixed(1);
      console.log(result);
      $('#show_result').html(result);
      jQuery('#divShowHide').addClass('show');*/
    }
  });



  }else{
    $('#err_details').html('* Please enter all mandatory details');
  }

}
    </script>
</body>
</html>