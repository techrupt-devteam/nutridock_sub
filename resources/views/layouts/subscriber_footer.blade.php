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
<link href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css" rel="stylesheet" />



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
});


$('#signIn').on('click',function(){
   $('#signinModal').modal('show');
});
</script>