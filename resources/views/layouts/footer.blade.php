<style>
.whatsapp-link {
	width: 50px;
	height: 50px;
	position: fixed;
	bottom: 20px;
	right: 20px;
	z-index: 99;
	display: block
}
.whatsapp-link img {
	max-width: 100%
}
</style>
<div id="footer-wrapper">
	<footer id="footer">
		<div class="container">
			<div class="row mb-60">
				<div class="col-lg-4 col-md-12 text-center text-md-left">
					<a href="index.php"><img src="{{url('')}}/public/front/img/logo-white.svg" alt="Nutridock Restaurant & Catering" style="max-width:100px"></a>
					<p class="text-center text-md-left" style="color:#eee;font-size:14px;">We are here to help you make the shift from restrictive dieting to mindful eating, in a way that is easy and enjoyable.
					</p>
					<ul class="mt-3 p-0 social-links">
						<li><a href="https://www.facebook.com/nutridock0/" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li><a href="https://www.instagram.com/nutri_dock/?igshid=1iz93rjouag24" target="_blank"><i class="fa fa-instagram"></i></a></li>
					</ul>
					
				</div>
				<div class="col-lg-4 col-md-6">
					<div class="widget-theme-wrapper">
						<div class="widget" id="mwt_recent-2">
							<h3 class="widget-title">Contact Us</h3>
							<ul class="contact-info-list pl-0 text-left">
								<li class="media mb-10 media.inline-block">
									<div class="media-left"><i class="color-main2 fa fa-map-marker"></i></div>
									<div class="media-body darklinks mt-0">Nutridock, Store B-17,MIDC Ambad, Nashik, Next To Seva Nexa Service Center, Maharashtra 422010</div>
								</li>
								<li class="media mb-10 media.inline-block">
									<div class="media-left"><i class="color-main2 fa fa-envelope-o"></i></div>
									<div class="media-body darklinks mt-0">customercare@nutridock.com</div>
								</li>
								<li class="media mb-10 media.inline-block">
									<div class="media-left"><i class="color-main2 fa fa-phone"></i></div>
									<div class="media-body darklinks mt-0">+91 7447725922</div>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-5 col-sm-6 fadeInRight wow">
					<div class="widget-theme-wrapper" style="overflow:hidden">
						<div class="widget" id="mwt_recent-2">
							<h3 class="widget-title">Newsletter</h3>
							<p class="mb-3" style="color:#ddd">Enter Email here to be updated. We promise not to send you spam!</p>
							<form action="{{url('/')}}/subscribe" class="form-inline newsletter" method="post" onsubmit="return submitUserForm1()">{{csrf_field()}}
								<input class="email" type="email" name="email" placeholder="Subscribe to our newsletter" required>
								<br>
								<br>
								<input class="submit" type="submit" value="Submit">
							</form>
						</div>
					</div>
					
				</div>
			</div>
		</div>
</div>
<div id="copyright-container">
	<div class="container">
		<div class="row">
			<div class="col-md-6 text-center text-md-left">
				<p>© Nutridock 2020. All rights reserved.</p>
			</div>
			<div class="col-md-6 text-md-right pt-2 text-white text-center">
				Designed By : <a href="#">Techrupt</a>
			</div>
		</div>
	</div>
</div>
<a href="https://wa.link/3o9k29" target="_blank" class="whatsapp-link">
    <img src="{{url('')}}/public/front/img/whatsapp-icon.svg">
</a>


<div class="footer-fix-menu">
    <div class="row no-gutters">
        <div class="col-4 border-right">
            <a href="{{url('')}}/menu" class="footer-m-link">
                <i class="fa fa-cutlery"></i>
                 <!--<img class="d-block mx-auto" src="{{url('')}}/public/front/img/pizza.svg" style="width: 26px;" />-->
                Menu
            </a>
        </div>
        <div class="col-4 border-right">
            <a href="http://order.nutridock.com/" target="_blank" class="footer-m-link order">
                <i class="fa fa-shopping-basket"></i>
                <!--<img class="d-block mx-auto" src="{{url('')}}/public/front/img/food-serving.svg" style="width: 26px;" />-->
                Order
            </a>
        </div>
        <div class="col-4">
            <a href="{{url('')}}/subscribe_info" class="footer-m-link">
                <!-- <i class="fa fa-phone" aria-hidden="true"></i> -->
                <img class="d-block mx-auto" src="{{url('')}}/public/front/img/diat-plan.svg" style="width: 26px;" />
               Subscription
            </a>
        </div>
    </div>
</div>

<script src="{{url('')}}/public/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{url('')}}/public/front/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="{{url('')}}/public/front/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="{{url('')}}/public/front/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="{{url('')}}/public/front/vendor/venobox/venobox.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="{{url('')}}/public/front/js/main.js"></script>
<!-- Parsley -->
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>
<script>
$(document).ready(function() {
	$('[data-toggle="tooltip"]').tooltip();
	setNavigation();
});

function setNavigation() {
	var url = '{{url('')}}';
	var path = window.location.href;
	var parts = url.split("/");
	var last_part = parts[parts.length - 2];
	$(".nav a").each(function() {
		var href = $(this).attr('href');
		//console.log(href);
		if(path === href) {
			//console.log(1);
			$(this).closest('li').addClass('active');
			$('#home').removeClass('active');
		} else if(url === href) {
			$('#home').addClass('active');
		}
	});
}
</script>
<script type="text/javascript">
function buttonUp() {
	var e = $(".searchbox-input").val();
	0 !== (e = $.trim(e).length) ? $(".searchbox-icon").css("display", "none") : ($(".searchbox-input").val(""), $(".searchbox-icon").css("display", "block"))
}

function submitUserForm() {
	return 0 != grecaptcha.getResponse().length || !(document.getElementById("g-recaptcha-error").innerHTML = '<span style="color:red;">This field is required.</span>')
}

function verifyCaptcha() {
	document.getElementById("g-recaptcha-error").innerHTML = ""
}
$(document).ready(function() {
	var e = $(".searchbox-icon"),
		c = $(".searchbox-input"),
		n = $(".searchbox"),
		o = !1;
	e.click(function() {
		o = 0 == o ? (n.addClass("searchbox-open"), c.focus(), !0) : (n.removeClass("searchbox-open"), c.focusout(), !1)
	}), e.mouseup(function() {
		return !1
	}), n.mouseup(function() {
		return !1
	}), $(document).mouseup(function() {
		1 == o && ($(".searchbox-icon").css("display", "block"), e.click())
	})
}), $(".reply").click(function() {
	var e = $(this).attr("data-val");
	$(".divReply" + e).show(), $(".blog_id").val(e)
})
</script>