<?php $session_message_counter = Session::get('message_counter'); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{(!empty($title))? $page_name." ".$title : "Admin | Dashboard" }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{url('/admin_css_js')}}/css_and_js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]--> 
  
  <!-- Google Font -->
 <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
  <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script> 
  <!---------------Toster------------->
  <link rel="stylesheet" type="text/css" href="{{ url('/admin_css_js')}}/css_and_js/admin/toastr/toastr.min.css">
  <script src="{{ url('/admin_css_js')}}/css_and_js/admin/toastr/toastr.min.js"></script>
  <!---------------------------------->
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
  .parsley-equalto{
    color: red; 
  }
  .inr_font_size_12{
    font-size: 12px;
  }
    .alert_msg{
    max-width: 374px;
    margin-left: auto;
    border-radius: 0px;
  }
 .swal-button--confirm {
    background-color: #f44336 !important;
    color: #fff;
    border: none;
    box-shadow: none;
    border-radius: 5px;
    font-weight: 600;
    font-size: 14px;
    padding: 10px 24px;
    margin: 0;
    cursor: pointer;
}
  </style>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{url('/admin')}}/dashbord" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <!-- <span class="logo-mini" style="color: black"><img src="{{url('/admin_css_js')}}/css_and_js/logo-mini.svg" style="width: 60%;"><h3>Nutridock</h3></span>
      logo for regular state and mobile devices
      <span class="logo-lg" style="color: black"><img src="{{url('/admin_css_js')}}/css_and_js/logo-mini.svg" style="width:13%"></span> -->
      <img src="{{url('/admin_css_js')}}/css_and_js/logo-mini.svg" style="width:32px"> 
       <span style="display: inline-block;transform: translate(0px, 2px);"><b>Nutridock</b></span>   
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
      
<!-- <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">{{ (!empty($session_message_counter))?$session_message_counter:0}}</span>
            </a>
          </li> -->


          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu ">
            <a href="#" class="dropdown-toggle dropdown-notifications" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <input type="hidden" id="notification_count" value="0">
              <span class="label label-warning" id="notification_count_span">0</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have <span class="notif-count">0</span> notifications</li>
              <li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                
                </ul>
              </li>
              <li class="footer"><a href="{{url('/admin')}}/manage_notification">View Notification</a></li>
            </ul>
          </li> 
         
          <!-- User Account: style can be found in dropdown.less -->
          <li>
            <a href="{{ url('/admin')}}/logout" class="" >
              {{-- <img src="{{url('/admin_css_js')}}/css_and_js/admin/dist/img/user2-160x160.png" class="user-image" alt="User Image"> --}}
              <span class="hidden-xs">Logout <i class="fa fa-sign-out"></i></span>
            </a>
          </li>
          <!-- Control Sidebar Toggle Button -->
          {{-- <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li> --}}
        </ul>
      </div>
    </nav>
    
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script type="text/javascript">

      /*var notificationsWrapper      = $('.dropdown-notifications');
      var notificationsToggle       = notificationsWrapper.find('a[data-toggle]');
      var notificationsCountElemVal = $('#notification_count').val();
      var notificationsCountElem    = $('#notification_count_span').html(notificationsCountElemVal);
      var notificationsCount        = parseInt(notificationsCountElemVal);
      var notificationsWrapperdrp   = $('.dropdown-menu');
      var notifications             = notificationsWrapperdrp.find('ul.menu');
      var pusher                    = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
      cluster                       : '{{env("PUSHER_APP_CLUSTER")}}',
      encrypted                     : true
      });
      var channel = pusher.subscribe('notify-channel');
      channel.bind('App\\Events\\Notify', function(data) {
        var existingNotifications = notifications.html();
        var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
        var newNotificationHtml = 
        `<li>
          <a href="#">
            <i class="fa fa-users text-aqua"></i> `+data.message+`
          </a>
        </li>
        `;
        notifications.html(newNotificationHtml + existingNotifications);
        notificationsCount += 1;

        $('#notification_count_span').html(notificationsCount);
        //notificationsCountElem.attr('data-count', notificationsCount);
        $('.notif-count').html(notificationsCount);
        $('#notification_count').val(notificationsCount);
        notificationsWrapper.show();
      });*/

     /* var notificationsWrapper=$(".dropdown-notifications"),notificationsToggle=notificationsWrapper.find("a[data-toggle]"),notificationsCountElemVal=$("#notification_count").val(),notificationsCountElem=$("#notification_count_span").html(notificationsCountElemVal),notificationsCount=parseInt(notificationsCountElemVal),notificationsWrapperdrp=$(".dropdown-menu"),notifications=notificationsWrapperdrp.find("ul.menu"),pusher=new Pusher('{{env("MIX_PUSHER_APP_KEY")}}',{cluster:'{{env("PUSHER_APP_CLUSTER")}}',encrypted:!0}),channel=pusher.subscribe("notify-channel");channel.bind("App\\Events\\Notify",function(n){var i=notifications.html(),t=(Math.floor(52*Math.random()),'<li>\n          <a href="#">\n            <i class="fa fa-users text-aqua"></i> '+n.message+"\n          </a>\n        </li>\n        ");notifications.html(t+i),notificationsCount+=1,$("#notification_count_span").html(notificationsCount),$(".notif-count").html(notificationsCount),notificationsWrapper.show()});*/

      function notification() 
      { 
        
         $.ajax({
              url: "{{url('/admin')}}/notification_data",
              type: 'post',
             success: function (data) 
              {
                  var  result =  data.split("#");
                //  var old_notification = parseInt($('#notification_count').val()) + parseInt(result[1]);
                  var old_notification = result[1];
                   $('#notification_count').val(old_notification);
                   $('#notification_count_span').html(old_notification);
                   $('.notif-count').html(old_notification);
                   $('.menu').html(result[0]);
              }
          });
      }
        notification();   
      var timerID = setInterval(function() {
        notification(); 
      }, 3000);
    </script>
  </header>
