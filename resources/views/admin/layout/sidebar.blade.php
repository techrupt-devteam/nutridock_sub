<?php 
  $login_user_details  = \Sentinel::check();
  $session_user = Session::get('user');
  if($session_user->roles!='admin'){

    $session_module = Session::get('module_data');
    $session_permissions = Session::get('permissions');

    $session_parent_menu = Session::get('parent_menu');
    $session_sub_menu = Session::get('sub_menu');

  }
?>
 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if(!IS_NULL($session_user->profile_image))

           <img src="{{ url('/')}}/uploads/user_pic//thumb/{{$session_user->profile_image}}" class="img-circle" alt="User Image">
           @else
          <img src="{{url('/admin_css_js')}}/css_and_js/admin/dist/img/user2-160x160.png" class="img-circle" alt="User Image">
          @endif
        </div>
        <div class="pull-left info">
          <h4 style="margin-bottom: 2px;">{{ucfirst($session_user->name)}}</h4>
           @if($session_user->roles=='admin')
          <small style="color:#8bc34a;">Adminstrator</small>
          @elseif($session_user->roles==1)
          <small style="color:#8bc34a;">Nutritionist</small>
          @elseif($session_user->roles==2)
          <small style="color:#8bc34a;">Operation Manager</small>
          @endif
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->

      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
      @if($session_user->roles=='admin')
        <li @if(Request::segment(2)=='dashbord') class="active" @endif>
          <a href="{{url('/admin')}}/dashbord">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li @if(Request::segment(2)=='manage_notification'|| Request::segment(2)=='notification') class="active" @endif>
          <a href="{{url('/admin')}}/manage_notification">
            <i class="fa fa-bell"></i> <span>Notification</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red notif-count">0</small>
            </span>
          </a>
        </li>
      
      <!-- <li class="treeview ">
            <a href="#">
              <i class="fa fa-television"></i> <span>CMS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li >
                <a href="#">
                  <i class="fa fa-circle-o"></i> <span>Blog</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li >
                <a href="#">
                  <i class="fa fa-circle-o"></i> <span>Testimonial </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
               <li >
                <a href="#">
                  <i class="fa fa-circle-o"></i> <span>Faq</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="#">
                  <i class="fa fa-circle-o"></i> <span> About US </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li> 
            </ul>
        </li> 
      -->

      <li class="treeview  @if(Request::segment(2)=='manage_subscriber' || Request::segment(2)=='add_subscriber' || Request::segment(2)=='edit_subscriber'||Request::segment(2)=='manage_assign_nutritionist' || Request::segment(2)=='add_assign_nutritionist' || Request::segment(2)=='edit_assign_nutritionist'||Request::segment(2)=='manage_subscriber_calender'||Request::segment(2)=='manage_new_subscriber'||Request::segment(2)=='manage_expire_subscriber' || Request::segment(2)=='add_calender' || Request::segment(2)=='edit_calender') active @endif ">
            <a href="#">
              <i class="fa fa-television"></i><span>Subscriber</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              
              <li @if(Request::segment(2)=='manage_subscriber' || Request::segment(2)=='add_subscriber' || Request::segment(2)=='edit_subscriber') class="active" @endif>
                  <a href="{{url('/admin')}}/manage_subscriber">
                     <i class="fa fa-users"></i><span>Subscribers</span>
                  </a>
              </li>
              <li @if(Request::segment(2)=='manage_assign_nutritionist' || Request::segment(2)=='add_assign_nutritionist' || Request::segment(2)=='edit_assign_nutritionist') class="active" @endif>
                  <a href="{{url('/admin')}}/manage_assign_nutritionist">
                     <i class="fa fa-user-plus"></i><span>Assign Nutritionist</span>
                  </a>
              </li>
              <li @if(Request::segment(2)=='manage_subscriber_calender' || Request::segment(2)=='add_calender' || Request::segment(2)=='edit_calender') class="active" @endif>
                  <a href="{{url('/admin')}}/manage_subscriber_calender">
                     <i class="fa fa-calendar"></i><span>Subscriber Calender</span>
                  </a>
              </li>
            </ul>
      </li>
      <li @if(Request::segment(2)=='manage_assign_sub_plan_menu' || Request::segment(2)=='add_assign_sub_plan_menu' || Request::segment(2)=='edit_assign_sub_plan_menu') class="active"@endif>
        <a href="{{url('/admin')}}/manage_assign_sub_plan_menu">
          <i class="fa fa-check-square-o" aria-hidden="true"></i><span>Assign Menu Subscription Plan</span>
          <span class="pull-right-container">
          </span>
        </a>
      </li>
        <li @if(Request::segment(2)=='manage_kitchen' || Request::segment(2)=='add_kitchen' || Request::segment(2)=='edit_kitchen') class="active"@endif>
          <a href="{{url('/admin')}}/manage_kitchen">
          <i class="fa fa-location-arrow"></i><span>Cloud Kitchen</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
       <li class="treeview  @if(Request::segment(2)=='manage_menucategory' || Request::segment(2)=='add_menucategory' || Request::segment(2)=='edit_menucategory'||Request::segment(2)=='manage_menu_specification' || Request::segment(2)=='add_menu_specification' || Request::segment(2)=='edit_menu_specification'||Request::segment(2)=='manage_menu' || Request::segment(2)=='add_menu' || Request::segment(2)=='edit_menu'|| Request::segment(2)=='add_location' || Request::segment(2)=='edit_location'||Request::segment(2)=='manage_plan' || Request::segment(2)=='add_plan' || Request::segment(2)=='edit_plan'|| Request::segment(2)=='manage_assign_location_menu' || Request::segment(2)=='add_assign_location_menu' || Request::segment(2)=='edit_assign_location_menu'||Request::segment(2)=='manage_kitchen1' || Request::segment(2)=='add_kitchen1' || Request::segment(2)=='edit_kitchen1'||Request::segment(2)=='manage_assign_sub_plan_menu1' || Request::segment(2)=='add_assign_sub_plan_menu1' || Request::segment(2)=='edit_assign_sub_plan_menu1') active @endif ">
            <a href="#">
              <i class="fa fa-cutlery"></i> <span>Menu</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span> 
            </a>
            <ul class="treeview-menu">
              <li @if(Request::segment(2)=='manage_menucategory' || Request::segment(2)=='add_menucategory' || Request::segment(2)=='edit_menucategory') class="active" @endif>
                <a href="{{url('/admin')}}/manage_menucategory">
                  <i class="fa fa-circle-o"></i> <span>Menu Category</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li @if(Request::segment(2)=='manage_menu_specification' || Request::segment(2)=='add_menu_specification' || Request::segment(2)=='edit_menu_specification') class="active" @endif>
                <a href="{{url('/admin')}}/manage_menu_specification">
                  <i class="fa fa-circle-o"></i> <span>Menu Specification</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
               <li @if(Request::segment(2)=='manage_menu' || Request::segment(2)=='add_menu' || Request::segment(2)=='edit_menu') class="active" @endif>
                <a href="{{url('/admin')}}/manage_menu">
                  <i class="fa fa-circle-o"></i> <span>Menu</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              
             
             
              <!-- <li @if(Request::segment(2)=='manage_assign_location_menu' || Request::segment(2)=='add_assign_location_menu' || Request::segment(2)=='edit_assign_location_menu') class="active" @endif>
                <a href="{{url('/admin')}}/manage_assign_location_menu">
                  <i class="fa fa-circle-o"></i> <span>Assign Location To Menu</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li> -->
            </ul>
        </li>  

       
        <li class="treeview  @if(Request::segment(2)=='manage_nutritionsit' || Request::segment(2)=='add_nutritionsit' || Request::segment(2)=='edit_nutritionsit'||Request::segment(2)=='manage_operation_manager' || Request::segment(2)=='add_operation_manager' || Request::segment(2)=='edit_operation_manager'||Request::segment(2)=='manage_subscription_plan' || Request::segment(2)=='add_subscription_plan' || Request::segment(2)=='edit_subscription_plan'||Request::segment(2)=='manage_location' || Request::segment(2)=='add_location' || Request::segment(2)=='edit_location'||Request::segment(2)=='manage_plan' || Request::segment(2)=='add_plan' || Request::segment(2)=='edit_plan'||Request::segment(2)=='manage_user_manager' || Request::segment(2)=='add_user_manager' || Request::segment(2)=='edit_user_manager') active @endif ">
            <a href="#">
              <i class="fa fa-cubes"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li @if(Request::segment(2)=='manage_nutritionsit' || Request::segment(2)=='add_nutritionsit' || Request::segment(2)=='edit_nutritionsit') class="active" @endif>
                <a href="{{url('/admin')}}/manage_nutritionsit">
                  <i class="fa fa-circle-o"></i> <span>Nutritionsit</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li @if(Request::segment(2)=='manage_user_manager' || Request::segment(2)=='add_user_manager' || Request::segment(2)=='edit_user_manager') class="active" @endif>
                <a href="{{url('/admin')}}/manage_user_manager">
                  <i class="fa fa-circle-o"></i> <span>User Manager</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li @if(Request::segment(2)=='manage_subscription_plan' || Request::segment(2)=='add_subscription_plan' || Request::segment(2)=='edit_subscription_plan') class="active" @endif>
                <a href="{{url('/admin')}}/manage_subscription_plan">
                  <i class="fa fa-circle-o"></i> <span>Subscription Plan</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              
              <!-- <li @if(Request::segment(2)=='manage_plan' || Request::segment(2)=='add_plan' || Request::segment(2)=='edit_plan') class="active" @endif>
                <a href="{{url('/admin')}}/manage_plan">
                  <i class="fa fa-circle-o"></i> <span> Plan </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li> -->
              <li @if(Request::segment(2)=='manage_location' || Request::segment(2)=='add_location' || Request::segment(2)=='edit_location') class="active" @endif>
                <a href="{{url('/admin')}}/manage_location">
                  <i class="fa fa-circle-o"></i> <span> Location </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
            </ul>
        </li>  
 
         <li class="treeview  @if(Request::segment(2)=='manage_module' || Request::segment(2)=='add_module' || Request::segment(2)=='edit_module' ||Request::segment(2)=='manage_role' || Request::segment(2)=='add_role' || Request::segment(2)=='edit_role'||Request::segment(2)=='manage_permission' || Request::segment(2)=='add_permission' || Request::segment(2)=='edit_permission') active @endif ">
            <a href="#">
              <i class="fa fa-sitemap"></i> <span>Role Setting</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li @if(Request::segment(2)=='manage_module' || Request::segment(2)=='add_module' || Request::segment(2)=='edit_module') class="active" @endif>
                <a href="{{url('/admin')}}/manage_module">
                  <i class="fa fa-circle-o"></i> <span>Module Master</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li @if(Request::segment(2)=='manage_role' || Request::segment(2)=='add_role' || Request::segment(2)=='edit_role') class="active" @endif>
                <a href="{{url('/admin')}}/manage_role">
                  <i class="fa fa-circle-o"></i> <span>Role Master</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li @if(Request::segment(2)=='manage_permission' || Request::segment(2)=='add_permission' || Request::segment(2)=='edit_permission') class="active" @endif>
                <a href="{{url('/admin')}}/manage_permission">
                  <i class="fa fa-circle-o"></i> <span>Role Permission</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
            </ul>
        </li>
        <li class="treeview @if(Request::segment(2)=='manage_gst' || Request::segment(2)=='add_gst' || Request::segment(2)=='edit_gst' ) active @endif">
          <a href="#">
            <i class="fa fa-percent"></i> <span>GST Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(2)=='manage_gst' || Request::segment(2)=='add_gst' || Request::segment(2)=='edit_gst' ) class="active" @endif><a href="{{url('/admin')}}/manage_gst"><i class="fa fa-circle-o"></i>GST Master</a></li>
          </ul>
        </li>
       <!--  <li>
          <a href="{{url('/public')}}/chatify" target="_blank">
            <i class="glyphicon glyphicon-comment"></i><span>Messager</span>
          </a>
        </li> -->

    @else
<!--------------------Dynamic Menu with permission---------------------->
      <li @if(Request::segment(2)=='dashbord') class="active" @endif>
        <a href="{{url('/admin')}}/dashbord">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li @if(Request::segment(2)=='manage_notification' || Request::segment(2)=='notification') class="active" @endif>
          <a href="{{url('/admin')}}/manage_notification">
            <i class="fa fa-bell"></i> <span>Notification</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-red notif-count">0</small>
            </span>
          </a>
        </li>
        @foreach($session_parent_menu as $parent_value)
          @if(!empty($parent_value[1]))
            @if(isset($session_permissions) && in_array($parent_value[2],$session_permissions) && !empty($session_permissions))
              <li @if(Request::segment(2)=='manage_'.$parent_value[3] || Request::segment(2)=='add_'.$parent_value[3] || Request::segment(2)=='edit_'.$parent_value[3]) class="active" @endif>
                <a href="{{url('/admin')}}/{{$parent_value[1]}}">
                  <i class="fa fa-television"></i> <span>{{$parent_value[0]}}</span>
                </a>
              </li>
             @endif
          @else
          <?php
            $active_menu = explode(",",$parent_value[3]);
          ?>
          <li class="treeview <?php foreach($active_menu as $acvalue){?>@if(Request::segment(2)=='manage_'.$acvalue || Request::segment(2)=='add_'.$acvalue || Request::segment(2)=='edit_'.$acvalue) active @endif<?php }?>">
              @if(isset($session_permissions) && in_array($parent_value[2],$session_permissions) && !empty($session_permissions) )
                <a href="#">
                  <i class="fa fa-folder"></i> <span>{{$parent_value[0]}}</span>
                  <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  </span>
                </a>
              @endif
              <ul class="treeview-menu">
                @foreach($session_sub_menu[$parent_value[0]] as $sub_value)
                  @foreach($sub_value as $sub_menu)

                    @if(isset($session_permissions) && in_array($sub_menu[0],$session_permissions) && !empty($session_permissions))
                    <li @if(Request::segment(2)=='manage_'.$sub_menu[3] || Request::segment(2)=='add_'.$sub_menu[3] || Request::segment(2)=='edit_'.$sub_menu[3] || Request::segment(2)=='add_subscriber_meal_program') class="active" @endif>
                    
                      <a href="{{url('/admin')}}/{{$sub_menu[2]}}">
                         <i class="fa fa-circle-o"></i> <span>{{$sub_menu[1]}}</span>
                        <span class="pull-right-container">
                        </span>
                      </a>
                    
                      
                    </li> 
                    @endif
                  @endforeach 
                @endforeach
               </ul>
            </li>
           @endif 
         @endforeach
    @endif
        <li>
          <a href="{{url('/admin')}}/chatify" target="_blank">
            <i class="glyphicon glyphicon-comment"></i><span>Messager</span>  <small class="label pull-right bg-yellow msg-count">0</small>
          </a>
        </li>

        <li class="treeview @if(Request::segment(2)=='change_password') active @endif">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li @if(Request::segment(2)=='change_password') class="active" @endif><a href="{{url('/admin')}}/change_password"><i class="fa fa-circle-o"></i> Change Password</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
 