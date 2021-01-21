<?php 
  $login_user_details  = \Sentinel::check();
  $session_user = Session::get('user');

?>
 <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/dist/img/user2-160x160.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p></p>
          <h4><a href="#"><?php echo e($session_user->name); ?></a></h4>
         <!--  <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li <?php if(Request::segment(2)=='dashbord'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/dashbord">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
      
      <li class="treeview ">
            <a href="#">
              <i class="fa fa-television"></i> <span>CMS</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li >
                <a href="<?php echo e(url('/admin')); ?>/manage_module">
                  <i class="fa fa-circle-o"></i> <span>Nutritionsit</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li >
                <a href="<?php echo e(url('/admin')); ?>/manage_role">
                  <i class="fa fa-circle-o"></i> <span>Operation Manager </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
               <li >
                <a href="<?php echo e(url('/admin')); ?>/manage_permission">
                  <i class="fa fa-circle-o"></i> <span> Subscription Plan </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li>
                <a href="<?php echo e(url('/admin')); ?>/manage_permission">
                  <i class="fa fa-circle-o"></i> <span> Location </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
            </ul>
        </li> 

        <li class="treeview  <?php if(Request::segment(2)=='manage_nutritionsit' || Request::segment(2)=='add_nutritionsit' || Request::segment(2)=='edit_nutritionsit'||Request::segment(2)=='manage_operation_manager' || Request::segment(2)=='add_operation_manager' || Request::segment(2)=='edit_operation_manager'||Request::segment(2)=='manage_subscription_plan' || Request::segment(2)=='add_subscription_plan' || Request::segment(2)=='edit_subscription_plan'||Request::segment(2)=='manage_location' || Request::segment(2)=='add_location' || Request::segment(2)=='edit_location'): ?> active <?php endif; ?> ">
            <a href="#">
              <i class="fa fa-television"></i> <span>Master</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li <?php if(Request::segment(2)=='manage_nutritionsit' || Request::segment(2)=='add_nutritionsit' || Request::segment(2)=='edit_nutritionsit'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_nutritionsit">
                  <i class="fa fa-circle-o"></i> <span>Nutritionsit</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li <?php if(Request::segment(2)=='manage_operation_manager' || Request::segment(2)=='add_operation_manager' || Request::segment(2)=='edit_operation_manager'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_role">
                  <i class="fa fa-circle-o"></i> <span>Operation Manager </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
               <li <?php if(Request::segment(2)=='manage_subscription_plan' || Request::segment(2)=='add_subscription_plan' || Request::segment(2)=='edit_subscription_plan'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_permission">
                  <i class="fa fa-circle-o"></i> <span> Subscription Plan </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li <?php if(Request::segment(2)=='manage_location' || Request::segment(2)=='add_location' || Request::segment(2)=='edit_location'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_permission">
                  <i class="fa fa-circle-o"></i> <span> Location </span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
            </ul>
        </li>  
 
         <li class="treeview  <?php if(Request::segment(2)=='manage_module' || Request::segment(2)=='add_module' || Request::segment(2)=='edit_module' ||Request::segment(2)=='manage_role' || Request::segment(2)=='add_role' || Request::segment(2)=='edit_role'||Request::segment(2)=='manage_permission' || Request::segment(2)=='add_permission' || Request::segment(2)=='edit_permission'): ?> active <?php endif; ?> ">
            <a href="#">
              <i class="fa fa-television"></i> <span>Role Setting</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li <?php if(Request::segment(2)=='manage_module' || Request::segment(2)=='add_module' || Request::segment(2)=='edit_module'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_module">
                  <i class="fa fa-circle-o"></i> <span>Module Master</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
              <li <?php if(Request::segment(2)=='manage_role' || Request::segment(2)=='add_role' || Request::segment(2)=='edit_role'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_role">
                  <i class="fa fa-circle-o"></i> <span>Role Master</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
               <li <?php if(Request::segment(2)=='manage_permission' || Request::segment(2)=='add_permission' || Request::segment(2)=='edit_permission'): ?> class="active" <?php endif; ?>>
                <a href="<?php echo e(url('/admin')); ?>/manage_permission">
                  <i class="fa fa-circle-o"></i> <span>Role Permission</span>
                  <span class="pull-right-container">
                  </span>
                </a>
              </li>
            </ul>
        </li>
        <li <?php if(Request::segment(2)=='manage_users' || Request::segment(2)=='add_user'|| Request::segment(2)=='edi_usert'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/manage_users">
            <i class="fa fa-users"></i> <span>Users</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="treeview <?php if(Request::segment(2)=='change_password'): ?> active <?php endif; ?>">
          <a href="#">
            <i class="fa fa-gear"></i> <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(Request::segment(2)=='change_password'): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('/admin')); ?>/change_password"><i class="fa fa-circle-o"></i> Change Password</a></li>
          </ul>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside><?php /**PATH D:\xampp\htdocs\nutridock_sub\resources\views/admin/layout/sidebar.blade.php ENDPATH**/ ?>