<!-- The Modal -->
<div class="modal" id="signinModal" data-keyboard="false" data-backdrop="static">
   <div class="modal-dialog modal-lg modal-dialog-centered">
     <div class="modal-content">
       <!-- Modal Header -->
       <button type="button" class="close position-absolute close-btn" data-dismiss="modal">&times;</button>
       <!-- Modal body -->
       <div class="modal-body p-0 login-5">
         <div class="row login-box no-gutters">
            <div class="col-md-5 col-pad-0 bg-img none-992 d-none d-md-block"> 
              <a href="javascript:void(0)"> 
                <img src="{{url('')}}/public/front/img/logo.png" class="login-logo">
            </a>
              <h4>Welcome Back</h4>
              <p>To Keep connected with us please login with your personal info.</p>
               <ul class="social-login">
                  <li>
                     <a href="https://www.facebook.com/nutridock0/" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                  </li>
               </ul>
            </div>
            <div class="col-xs-12 col-md-7 align-self-center">
              <div class="login-inner-form">
                <div class="details">
                  <h3 class="text-center d-none d-md-block">Sign into your account</h3>
                  <div class="login-logo d-none-md d-lg-none text-center"> <a href="javascript:void(0)"> 
                     <img src="{{url('')}}/public/front/img/logo.png" class="login-logo" style="max-width: 75px;"> 
                     </a> 
                  </div>
                  <div class="">
                    <div class="login-box-body">
                      <form method="POST" class="digit-group" data-group-name="digits" data-autosubmit="false" autocomplete="off" id="frmSignIn">
                      {!! csrf_field() !!}
                        <div class="title-login">
                           <label class="">Register phone</label>
                           <span>Enter your mobile number to enable 2-step verfication</span>
                        </div>
                        <div class="form-group mx-auto" style="max-width: 258px;">
                          <input type="text" id="mobile" name="mobile" class="form-control" placeholder="xxx-xxx-4560 " autocomplete="off" maxlength="10" 
                          style="padding-left: 42px;">
                          
                        <span class="form-control-feedback">+91</span>
                     </div>
                        <div class="form-group otp-textbox">
                           <div class="title-login">
                              <label class="">Phone verfication</label>
                              <span>Enter your OTP code</span>
                           </div>
                           <input type="text" id="digit-1" name="digit-1" data-next="digit-2" />
                           <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" />
                           <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" />
                           <span class="splitter">&ndash;</span>
                           <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" />
                           <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" />
                           <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" />
                        </div>
                        <!-- <div class="form-group">
                        <div class="time-set">
                           <label>Please enter otp</label>
                           1:56
                        </div>
                        <div class="resend-otp">
                           <a href="#">Resend OTP</a>
                        </div> -->
                     </div>
                        <div class="row ">
                          <div class="col-sm-6 mx-auto">
                            <div class="position-relative width-120 mr-15">
                               <button type="button" name="btnSignIn" id="btnSignIn" class="btn btn-dark btn-block">Login</button>

                               <button type="button" name="btnVerify" id="btnVerify" class="btn btn-dark btn-block">Verify</button>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
       </div>
       </div>         
    </div>
</div>

<script>
$(document).ready(function(){
    $("#btnVerify").hide();
});


$('.otp-textbox').find('input').each(function() {
	$(this).attr('maxlength', 1);

	$(this).on('keyup', function(e) {
		var parent = $($(this).parent());		
		if(e.keyCode === 8 || e.keyCode === 37) {
			var prev = parent.find('input#' + $(this).data('previous'));
			
			if(prev.length) {
				$(prev).select();
			}
		} 
        else if((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
			var next = parent.find('input#' + $(this).data('next'));

			if(next.length) {
				$(next).select();
			} else {
				if(parent.data('autosubmit')) {
					//parent.submit();
				}
			}
		}
	});
});

$("#btnSignIn").click(function() {
   $("#btnSignIn").hide();
    $.ajax({
        type: "POST",
        url: "{{ URL::to('/') }}/check-login",
        data: $("#frmSignIn").serialize(),
        success: function (data) {   
           if(data == 'success') {
               $("#btnSignIn").hide();
               $("#btnVerify").show();
               
           }
        },
        error: function (data) {        
            return false;
        },
    });
});



$("#btnVerify").click(function() {
   $("#btnVerify").show();
   $("#btnSignIn").hide();
    $.ajax({
        type: "POST",
        url: "{{ URL::to('/') }}/check-otp",
        data: $("#frmSignIn").serialize(),
        success: function (data) {   
           if(data) {
            window.location.href = "{{ URL::to('/') }}/dashboard";
           } else {
              alert("Invalid otp");
           }
        },
        error: function (data) {        
            return false;
        },
    });
});
</script>