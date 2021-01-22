<!-- ======= Footer ======= -->
<style>
    .whatsapp-link {
		width: 55px;
		height: 55px;
		position: fixed;
		bottom: 20px;
		left: 20px;
		z-index: 99;
		display: block;
	}
.whatsapp-link img {
    max-width: 100%;
}
</style>
<div id="footer-wrapper"> 
  <!-- #footer start -->
  <footer id="footer"> 
    <!-- .container start -->
    <div class="container"> 
      <!-- .row start -->
      <div class="row mb-60"> 
        <!-- .col-md-4 start -->
        <div class="col-md-12 col-lg-4 text-md-left text-center">
          <a href="index.php"> 
            <img src="{{url('')}}/public/front/img/logo-white.svg" alt="Nutridock Restaurant &amp; Catering" style="max-width: 100px;"> 
          </a>
          <p class="text-center text-md-left" style="color: #959595;font-size: 14px;">
            We are here to help you make the shift from restrictive dieting to mindful eating, in a way that is easy and enjoyable.</p>
          <ul class="contact-info-list pl-0 text-left">
            <li class="media media.inline-block mb-10">
              <div class="media-left">
                  <i class="icofont-location-pin color-main2"></i>
              </div>
              <div class="media-body darklinks mt-0">
                <!--B-17 Ambad MIDC Near COCA-COLA Company, Nasik - 422010-->
                Nutridock, Store B-17,MIDC Ambad, Nashik, Next To Seva Nexa Service Center, Maharashtra 422010
              </div>
            </li>

            <li class="media media.inline-block mb-10">
              <div class="media-left">
                  <i class="icofont-envelope color-main2"></i>
              </div>
              <div class="media-body darklinks mt-0">
                customercare@nutridock.com         
              </div>
            </li>

            <li class="media media.inline-block mb-10">
              <div class="media-left">
                  <i class="icofont-ui-dial-phone color-main2"></i>
              </div>
              <div class="media-body darklinks mt-0">
                +91 7447725922
              </div>
            </li>

            <li class="media media.inline-block mb-10">
              <div class="media-left">
                  <i class="icofont-clock-time color-main2"></i>
              </div>
              <div class="media-body darklinks mt-0">
                MON- SUN: 10:00 AM - 10:00 PM <br/>
                <!--SAT - SUN: 10:00 AM - 11:00 PM-->
              </div>
            </li>
           </ul>
        </div>
        <!-- .col-md-4 end--> 
        
        <!-- .col-md-4 start -->
        <div class="col-md-6 col-lg-4"> 
          <div class="widget-theme-wrapper">
            <div id="mwt_recent-2" class="widget">
              <h3 class="widget-title">Recent Posts</h3>  
              <ul class="list-unstyled links-darkgrey">
                
            <?php foreach($recent_data as $row): ?>
              <li class="media post type-post">
                  <a class="media-left">
                    <img src="{{url('')}}/uploads/images/{{$row->image}}" class="attachment-thumbnail size-thumbnail wp-post-image" alt="">          
                  </a>
                <div class="media-body">
                  <h4><a href="{{url('')}}/blog_detail/{{base64_encode($row->id)}}">{!!  substr(strip_tags($row->blog_title), 0, 35) !!}</a></h4>
                  <div class="item-meta">
                      <span class="widget-post-date">
                        <i class="icofont-calendar color-main"></i>
                        <!-- 20 Dec, 18 -->
                        {{ date('F d, Y', strtotime($row->created_at)) }}
                    </span>
                  </div>
              </div>
            </li>
          <?php endforeach; ?>
          
             
            
            
          </ul>
      </div>
    </div>
        </div>
        <!-- .col-md-4 end --> 
        
        <!-- .col-md-4 start -->
       <div class="col-sm-6 col-md-5 col-lg-4 col-xl-3 wow fadeInRight">
           <div class="widget-theme-wrapper" style="overflow: hidden;">
            <div id="mwt_recent-2" class="widget">
              <h3 class="widget-title">Newsletter</h3>  
              <p style="color: #ddd;" class="mb-3">
                Enter Email here to be updated. We promise not to send you spam! 
              </p>
               <!-- .newsletter start -->
               <form action="{{url('/')}}/subscribe" method="post" class="form-inline newsletter" onsubmit="return submitUserForm1();">
                {{csrf_field()}}
                  <input class="email" type="email" name="email" placeholder="Subscribe to our newsletter" required="required">
                  <br><br>
                  
                <!--<div class="g-recaptcha" data-sitekey="6LeUQvcZAAAAADPLG3rEpvKuzN8eIOdy1zrLdXoP" data-callback="verifyCaptcha1"></div>
              <div id="g-recaptcha-error1"></div><br>-->
              
              <input type="submit" class="submit" value="Submit">
                </form>
                <!-- .newsletter end --> 
            </div>
          </div>
          <!-- .social-links start -->
          <ul class="social-links mt-5 p-0">
            <li><a href="https://www.facebook.com/nutridock0/" target="_blank"><i class="icofont-facebook"></i></a></li>
            <li><a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24" target="_blank"><i class="icofont-instagram"></i></a></li>
          </ul>
          <!-- .social-links end --> 
        </div>
      </div>
        <!-- .col-md-4 end--> 
      </div>
      <!-- .row end --> 
      
   
    </div>
    <!-- .container end --> 
  </footer>
  <!-- #footer end --> 
</div>
<div id="copyright-container"> 
  <!-- .container start -->
  <div class="container"> 
    <!-- .row start -->
    <div class="row"> 
      <!-- .col-md-6 start -->
      <div class="col-md-6 text-center text-md-left">
        <p>© Nutridock 2020. All rights reserved.</p>
      </div>
      <!-- .col-md-6 end --> 
      
      <!-- .col-md-6 start -->
      <div class="col-md-6">
        <ul class="breadcrumb">
          <li><a href="{{url('')}}">Home</a></li>
          <li><a href="{{url('')}}/about">About</a></li>
          <li><a href="{{url('')}}/menu">Menu</a></li>
          <li><a href="{{url('')}}/blog">Blog</a></li>
          <li><a href="{{url('')}}/faq">Faq</a></li>
          <li><a href="{{url('')}}/contact">Contact</a></li>
        </ul>
      </div>
      <!-- .col-md-6 end --> 
    </div>
    <!-- .row end --> 
  </div>
  <!-- .container end --> 
  
<!--<a href="#" class="scroll-up show-scroll"><i class="fa fa-angle-double-up"></i></a> -->
</div>
<!-- <div id="preloader"></div> -->
<a href="https://wa.link/3o9k29" target="_blank" class="whatsapp-link">
	<img src="{{url('')}}/public/front/img/whatsapp-icon.svg" />
</a>
<!--<div id="preloader" class="preloader default-preloader">
     <h1>
        Nutridock
    </h1> 
        <div id="cooking">
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div class="bubble"></div>
            <div id="area">
                <div id="sides">
                    <div id="pan"></div>
                    <div id="handle"></div>
                </div>
                <div id="pancake">
                    <div id="pastry"></div>
                </div>
            </div>
        </div>
    </div>-->
    
<div class="sticky-container">
    <ul class="sticky">
        <li class="hover-item">
          <a href="http://order.nutridock.com/" class="hvr-icon-wobble-horizontal">
             <img src="{{url('')}}/public/front/img/order-cart.svg"/>    
             <b class="footer-sticky1">Order Now</b>
          </a>
        </li>
    </ul>
</div>


<!-- <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>  -->
<!--<a href="#" class="back-to-top" style="display: inline;"><span id="toTopHover" style="opacity: 0;"></span> Top </a>-->

<!-- Vendor JS Files --> 
<script src="{{url('')}}/public/front/vendor/jquery/jquery.min.js"></script> 
<script src="{{url('')}}/public/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> 
<script src="{{url('')}}/public/front/vendor/jquery.easing/jquery.easing.min.js"></script> 
<!-- <script src="{{url('')}}/public/front/vendor/php-email-form/validate.js"></script> --> 
<script src="{{url('')}}/public/front/vendor/waypoints/jquery.waypoints.min.js"></script> 
<!-- <script src="{{url('')}}/public/front/vendor/counterup/counterup.min.js"></script> --> 
<script src="{{url('')}}/public/front/vendor/owl.carousel/owl.carousel.min.js"></script> 
<!-- <script src="{{url('')}}/public/front/vendor/isotope-layout/isotope.pkgd.min.js"></script> --> 
<script src="{{url('')}}/public/front/vendor/venobox/venobox.min.js"></script> 
<!-- <script src="{{url('')}}/public/front/vendor/aos/aos.js"></script> -->


<script src="https://www.google.com/recaptcha/api.js"></script>


<!-- Template Main JS File --> 
<script src="{{url('')}}/public/front/js/main.js"></script>
  <script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
  setNavigation();
});

function setNavigation(){
      var url = '{{url('')}}';
      var path = window.location.href;
      var parts = url.split("/");
      var last_part = parts[parts.length-2];
      $(".nav a").each(function() {
        var href = $(this).attr('href');
        //console.log(href);
        if(path === href){
          //console.log(1);
          $(this).closest('li').addClass('active');
          $('#home').removeClass('active');
        }else if(url === href){
          $('#home').addClass('active');
        }
      });
    }
</script> 
<script type="text/javascript">
    $(document).ready(function(){
            var submitIcon = $('.searchbox-icon');
            var inputBox = $('.searchbox-input');
            var searchBox = $('.searchbox');
            var isOpen = false;
            submitIcon.click(function(){
                if(isOpen == false){
                    searchBox.addClass('searchbox-open');
                    inputBox.focus();
                    isOpen = true;
                } else {
                    searchBox.removeClass('searchbox-open');
                    inputBox.focusout();
                    isOpen = false;
                }
            });  
             submitIcon.mouseup(function(){
                    return false;
                });
            searchBox.mouseup(function(){
                    return false;
                });
            $(document).mouseup(function(){
                    if(isOpen == true){
                        $('.searchbox-icon').css('display','block');
                        submitIcon.click();
                    }
                });
        });
            function buttonUp(){
                var inputVal = $('.searchbox-input').val();
                inputVal = $.trim(inputVal).length;
                if( inputVal !== 0){
                    $('.searchbox-icon').css('display','none');
                } else {
                    $('.searchbox-input').val('');
                    $('.searchbox-icon').css('display','block');
                }
            }

 $(".reply").click(function(){
    var value = $(this).attr('data-val');
    //console.log(value);    
   $(".divReply"+value).show();
   $('.blog_id').val(value);

  });
 

    
    function submitUserForm() {
        return 0 != grecaptcha.getResponse().length || (document.getElementById("g-recaptcha-error").innerHTML = '<span style="color:red;">This field is required.</span>', !1)
    }

    function verifyCaptcha() {
        document.getElementById("g-recaptcha-error").innerHTML = ""
    }
  </script>
  
  
  



</body>
</html>