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
          <p><?php echo e($session_user->store_name); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
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
        <?php if($session_user->role=='admin'): ?>
       <li class="treeview">
          <a href="#">
            <i class="fa fa-television"></i> <span>Seva</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(Request::segment(2)=='manage_booking' || Request::segment(2)=='view_booking'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/manage_booking">
            <i class="fa fa-circle-o"></i> <span>Manage Booking</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='book_you_service' || Request::segment(2)=='book_you_service'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/book_you_service">
            <i class="fa fa-circle-o"></i> <span>Book Your service</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
         <li <?php if(Request::segment(2)=='test_drive' || Request::segment(2)=='test_drive'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/test_drive">
            <i class="fa fa-circle-o"></i> <span>Test Drive Requests</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='quotations' || Request::segment(2)=='quotations'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/quotations">
            <i class="fa fa-circle-o"></i> <span>Quotations</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='insurance' || Request::segment(2)=='insurance'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/insurance">
            <i class="fa fa-circle-o"></i> <span>Insurance</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='finance' || Request::segment(2)=='finance'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/finance">
            <i class="fa fa-circle-o"></i> <span>Finance</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='enquiry' || Request::segment(2)=='enquiry'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/enquiry">
            <i class="fa fa-circle-o"></i> <span>Enquiry</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='offer_enquiry' || Request::segment(2)=='offer_enquiry'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/offer_enquiry">
            <i class="fa fa-circle-o"></i> <span>Offer Enquiries</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='locations' || Request::segment(2)=='locations'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/locations">
            <i class="fa fa-circle-o"></i> <span>Locations</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='offers' || Request::segment(2)=='offers'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/offers">
            <i class="fa fa-circle-o"></i> <span>Offers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='value_add_services' || Request::segment(2)=='value_add_services'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/value_add_services">
            <i class="fa fa-circle-o"></i> <span>Value Add Services</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='booked_value_added_services' || Request::segment(2)=='booked_value_added_services'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/booked_value_added_services">
            <i class="fa fa-circle-o"></i> <span>Booked Value Added service</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
          </ul>
        </li>
         <li class="treeview">
          <a href="#">
            <i class="fa fa-television"></i> <span>Nexa</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(Request::segment(2)=='manage_nexa_booking' || Request::segment(2)=='view_nexa_booking'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/manage_nexa_booking">
            <i class="fa fa-circle-o"></i> <span>Manage Booking</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_book_you_service' || Request::segment(2)=='nexa_book_you_service'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_book_you_service">
            <i class="fa fa-circle-o"></i> <span>Book Your service</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
         <li <?php if(Request::segment(2)=='nexa_showroom_visits' || Request::segment(2)=='nexa_showroom_visits'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_showroom_visits">
            <i class="fa fa-circle-o"></i> <span>Showroom visits</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
         <li <?php if(Request::segment(2)=='nexa_test_drive' || Request::segment(2)=='nexa_test_drive'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_test_drive">
            <i class="fa fa-circle-o"></i> <span>Test Drive Requests</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_quotations' || Request::segment(2)=='nexa_quotations'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_quotations">
            <i class="fa fa-circle-o"></i> <span>Quotations</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_insurance' || Request::segment(2)=='nexa_insuranc'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_insurance">
            <i class="fa fa-circle-o"></i> <span>Insurance</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_finance' || Request::segment(2)=='nexa_finance'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_finance">
            <i class="fa fa-circle-o"></i> <span>Finance</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_feedback' || Request::segment(2)=='nexa_feedback'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_feedback">
            <i class="fa fa-circle-o"></i> <span>Feedback</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_enquiry' || Request::segment(2)=='nexa_enquiry'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_enquiry">
            <i class="fa fa-circle-o"></i> <span>Enquiry</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_offer_enquiry' || Request::segment(2)=='nexa_offer_enquiry'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_offer_enquiry">
            <i class="fa fa-circle-o"></i> <span>Offer Enquiries</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_locations' || Request::segment(2)=='nexa_locations'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_locations">
            <i class="fa fa-circle-o"></i> <span>Locations</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_offers' || Request::segment(2)=='nexa_offers'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_offers">
            <i class="fa fa-circle-o"></i> <span>Offers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_home_banner' || Request::segment(2)=='nexa_home_banner'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_home_banner">
            <i class="fa fa-circle-o"></i> <span>Home Screen Banner</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_value_add_services' || Request::segment(2)=='nexa_value_add_services'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_value_add_services">
            <i class="fa fa-circle-o"></i> <span>Nexa Value Add Services</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='nexa_booked_value_added_services' || Request::segment(2)=='nexa_booked_value_added_services'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/nexa_booked_value_added_services">
            <i class="fa fa-circle-o"></i> <span>Booked Value Added service</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-television"></i> <span>Commercial</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li <?php if(Request::segment(2)=='manage_commercial_booking' || Request::segment(2)=='view_booking'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/manage_commercial_booking">
            <i class="fa fa-circle-o"></i> <span>Manage Booking</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='commercial_book_you_service' || Request::segment(2)=='commercial_book_you_service'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_book_you_service">
            <i class="fa fa-circle-o"></i> <span>Book Your service</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
         <li <?php if(Request::segment(2)=='commercial_showroom_visits' || Request::segment(2)=='commercial_showroom_visits'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_showroom_visits">
            <i class="fa fa-circle-o"></i> <span>Booked Appointments</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='commercial_feedback' || Request::segment(2)=='commercial_feedback'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_feedback">
            <i class="fa fa-circle-o"></i> <span>Feedback</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='commercial_enquiry' || Request::segment(2)=='commercial_enquiry'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_enquiry">
            <i class="fa fa-circle-o"></i> <span>Enquiry</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='commercial_offer_enquiry' || Request::segment(2)=='commercial_offer_enquiry'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_offer_enquiry">
            <i class="fa fa-circle-o"></i> <span>Offer Enquiries</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='commercial_locations' || Request::segment(2)=='commercial_locations'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_locations">
            <i class="fa fa-circle-o"></i> <span>Locations</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='commercial_offers' || Request::segment(2)=='commercial_offers'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/commercial_offers">
            <i class="fa fa-circle-o"></i> <span>Offers</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li <?php if(Request::segment(2)=='comm_home_banner' || Request::segment(2)=='comm_home_banner'): ?> class="active" <?php endif; ?>>
          <a href="<?php echo e(url('/admin')); ?>/comm_home_banner">
            <i class="fa fa-circle-o"></i> <span>Home Screen Banner</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
          </ul>
        </li>
    <?php endif; ?>
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
  </aside><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/layout/sidebar.blade.php ENDPATH**/ ?>