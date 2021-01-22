@extends('layouts.master')
@section('content')
<section class="breadcrumbs-custom">
    <div class="parallax-container" data-parallax-img="{{url('')}}/public/front/img/faq-bg.jpg">
    	<div class="material-parallax parallax">
    		<img src="{{url('')}}/public/front/img/faq-bg.jpg" alt="" style="display: block; transform: translate3d(-50%, 149px, 0px);">
    	</div>
      <div class="breadcrumbs-custom-body parallax-content context-dark">
        <div class="container">
          <h2 class="breadcrumbs-custom-title">Frequently Asked Questions </h2>
        </div>
      </div>
    </div>
    <div class="breadcrumbs-custom-footer">
      <div class="container">
        <ul class="breadcrumbs-custom-path">
          <li><a href="index.html">Home</a></li>
          <li><a href="grid-blog.html">Blog</a></li>
          <li class="active">Faq</li>
        </ul>
      </div>
    </div>
</section>
 <!-- ======= Frequently Asked Questions Section ======= -->
    <section id="faq" class="faq section-bg">
        <div class="w-100 mb-3"> 
          <ul class="nav nav-pills Categories-portfolio" role="tablist">
             <li class="nav-item"> 
              <a class="nav-link" data-toggle="pill" href="#tab1" id="tabv1"> 
                Faq 
              </a> 
             </li>
             <li class="nav-item"> 
              <a class="nav-link" data-toggle="pill" href="#tab2" id="tabv2"> 
                Subscribe Plan 
              </a> 
             </li>
            </ul>
        </div>
        
        <div class="w-100 d-flex justify-content-center mt-2">
            <div class="tab-content w-100">
                <div class="tab-pane filter-active " id="tab1">
                    <div class="container" data-aos="fade-up">
                        <ul class="faq-list" data-aos="fade-up" data-aos-delay="100">
                          @foreach($arr_data as $row)
                          <li>
                            <a data-toggle="collapse" class="text-darkness" href="#faq{{$row['id']}}"> 
                              <span class="text-success"> {{ $no++ }}. </span> 
                              {{$row['title']}}
                                <i class="fa fa-angle-down"></i></a>
                            <div id="faq{{$row['id']}}" @if($row['id']==1) class="collapse show" @endif class="collapse" data-parent=".faq-list">
                              <p ><?php echo stripslashes($row['description']); ?></p>
                                
                            </div>
                          </li>
                          @endforeach
                        </ul>

                      </div>
                </div>
                <div class="tab-pane" id="tab2">
                    <div class="container" data-aos="fade-up">
                        <p><b><span class="text-success">01.</span>How will the subscription plan help me maintain a healthy weight?</b><br>
                            Our subscription plans are created by nutritionists based on your health profile. The
                            meals are customized to address your health issues and help you achieve your
                            fitness goals and maintain them.<br><br>
                            <b><span class="text-success">02.</span>I don’t like following a diet, how different will be your subscription plan?</b><br>
                            Our nutritionists take care to design a meal plan in a way that it brings a lot of variety
                            to your plate every day.<br><br>
                            <b><span class="text-success">03.</span>Can I be assured of the meals being tasty along with nutritious?</b><br>
                            Absolutely! We never cook meals that taste bland. Our meals are packed with
                            ingredients that are flavoursome along with being healthy.<br><br>
                            <b><span class="text-success">04.</span>I am a vegetarian; can I get the required number of proteins from your diet
                            plan?</b><br>
                            We prepare your meals using ingredients rich in plant-based protein such as tofu,
                            chickpeas, quinoa, oats, chia seeds, etc.<br><br>
                            <b><span class="text-success">05.</span>How do I know if this meal plan will work for me?</b><br>
                            We prepare meals after calculating the protein, carbs and other nutrients your body
                            requires based on your health profile. Our meal plans are, therefore, customized to
                            suit and benefit you. And you can also consult your assigned nutritionist about your
                            doubts.<br><br>
                            <b><span class="text-success">06.</span>What if my medical condition worsens after having the meals?</b><br>
                            That is unlikely to happen because of our food. After the subscription plan starts,
                            your assigned nutritionist will continue to monitor your health and take follow-ups
                            every week.<br><br>
                            <b><span class="text-success">07.</span>Can I make changes to my ongoing subscription plan?</b><br>
                            Yes. You can make any changes to your ongoing subscription plan, like change the
                            delivery date of your meals or change the item in your menu by contacting us 24
                            hours before the delivery date<br><br>
                            <b><span class="text-success">08.</span>How many meals do you provide in a day?</b><br>
                            Our standard number of meals a day are 4 which include breakfast, lunch, snacks
                            and dinner. You can opt for all 4 or go for 2 to 3 meals a day as per your
                            convenience. But we strongly recommend that you opt for at least 3 meals a day to
                            see any substantial results.<br><br>
                            <b><span class="text-success">09.</span>Can I cancel my subscription mid-way? Will there be a cancellation fee?</b><br>
                            Right now, we do not support cancellation of the subscription. You can, however,
                            reschedule the delivery of your meals.<br><br>
                            <b><span class="text-success">10.</span>What time will the meals be delivered to me?</b><br>
                            We deliver according to the meal timings every day. You will receive your breakfast
                            at 8 o’clock in the morning. Lunch and snacks at 1pm and dinner will be delivered at
                            7 o’clock in the evening.<br>Connect with us on call/WhatsApp at 74477 25922 or email us at 
                            <a href="mailto:customercare@nutridock.com">customercare@nutridock.com</a>
                             .<br>Looking forward to give you a Wholesome and Wonderful experience! :)
                            
                        </p>
                    </div>
                </div>
            </div>
        </div>
       
      
    </section>

    <script type="text/javascript">
      $(document).ready(function() {
      $('#tabv1').addClass('active');
            $('#tab1').addClass('active');
     var url = window.location;
     if(url == 'http://localhost/nutridock_live/faq#tab2'){
      $('#tabv1').removeClass('active');
      $('#tabv2').addClass('active');
      $('#tab1').removeClass('active');
      $('#tab2').addClass('active');
     }
          
    });
      
    </script>
@endsection