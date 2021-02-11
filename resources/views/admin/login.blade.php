<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Admin Panel </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/plugins/iCheck/square/blue.css">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ url('/admin_css_js')}}/css_and_js/logo-icon.svg">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css">
  .parsley-required{
    color: red;
  }
  .parsley-type{
    color: red;
  }
  .parsley-minlength{
    color: red; 
  }
  .parsley-errors-list{
    list-style: none;
      padding-left: 5px;
  }
  </style>
</head>
<body class="hold-transition background-img login-page"{{--  style="background-image: url(http://ba.kores.in/kores-sniper/img/section-03-bg-img.jpg)" --}}>
<div class="login-box ">
  <div class="login-logo">
    <img src="{{ url('/admin_css_js')}}/css_and_js/nutridock-logo.svg" style="max-width: 140px;">
    <a href="{{ url('/admin')}}"></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in your account</p>
    @if(Session::has('error'))
      <div class="alert alert-danger">
        {{ Session::get('error') }}
      </div>
    @endif
    @if(Session::has('success'))
      <div class="alert alert-success">
        {{ Session::get('success') }}
      </div>
    @endif

    <form action="{{ url('/admin')}}/login_process" method="post" data-parsley-validate="parsley">
      {!! csrf_field() !!}
      <div class="form-group has-feedback">
        <input type="text" name="email" id="email" class="form-control" placeholder="Username" {{-- value="{{$_COOKIE["adminemail"] or ''}}" --}} {{-- data-parsley-type="email" --}} required="true" style="height: 40px;" onchange="getcity_dropdown();">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control" placeholder="Password" {{-- value="{{$_COOKIE["adminpassword"] or ''}}"  --}}{{-- data-parsley-minlength="6" --}} required="true" style="height: 40px;">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback" id="city_select" style="display: none !important;">
        <select name="city" id="city" class="form-control Select2">
          <option value="">-Select City-</option>
        </select>
      </div>
      <div class="row">
        <div class="col-xs-12 text-center">
          <button type="submit" class="btn bg-dark h-40 btn-block btn-flat">Sign In</button>
          <a class="text-success btn-block" href="{{url('/admin')}}/forget_password">I Forgot My Password</a>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/plugins/iCheck/icheck.min.js"></script>
<!-- parsaly -->
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>


<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });
  });


function  getcity_dropdown(){
    var email = $("#email").val();
    $.ajax({
      type: "POST",
      url: "{{url('/')}}/get_city_list",
      data: {
        email: email
      }
    }).done(function(data) {
         if(data != "users"){
            $('#city').html(data);
            $('#city_select').show();
             $('#city').show();
         }else{
            $('#city').hide();
            $('#city_select').hide();
         }
    });


}


</script>
</body>
</html>
