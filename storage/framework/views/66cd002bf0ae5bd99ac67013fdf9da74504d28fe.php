 
<?php $__env->startSection('content'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>

    <?php
      $date= date('d/m/yy');
      $seva_total_online_bookings = \DB::table('booking')->where('status','=','Paid')->count();
      $seva_todays_online_bookings = \DB::table('booking')->where('status','=','Paid')->where('created_at','LIKE','%'.strtolower($date).'%')->count();

      $nexa_total_online_bookings = \DB::table('nexa_booking')->where('status','=','Paid')->count();
      $nexa_todays_online_bookings = \DB::table('nexa_booking')->where('status','=','Paid')->where('created_at','LIKE','%'.strtolower($date).'%')->count();

      $commercial_total_online_bookings = \DB::table('commercial_booking')->where('status','=','Paid')->count();
      $commercial_todays_online_bookings = \DB::table('commercial_booking')->where('status','=','Paid')->where('created_at','LIKE','%'.strtolower($date).'%')->count();

      $total_online_bookings=$seva_total_online_bookings+$nexa_total_online_bookings+$commercial_total_online_bookings;
      $todays_online_bookings=$seva_todays_online_bookings+$nexa_todays_online_bookings+$commercial_todays_online_bookings;





      $seva_total_service_bookings = \DB::table('book_your_service')->count();
      $seva_todays_service_bookings = \DB::table('book_your_service')->where('service_date','=',date('yy-m-d'))->count();

       $nexa_total_service_bookings = \DB::table('book_your_service')->count();
       $nexa_todays_service_bookings = \DB::table('book_your_service')->where('service_date','=',date('yy-m-d'))->count();

       $commercial_total_service_bookings = \DB::table('book_your_service')->count();
       $commercial_todays_service_bookings = \DB::table('book_your_service')->where('service_date','=',date('yy-m-d'))->count();

       $total_service_bookings=$seva_total_service_bookings+$nexa_total_service_bookings+$commercial_total_service_bookings;
       $todays_service_bookings=$seva_todays_service_bookings+$nexa_todays_service_bookings+$commercial_todays_service_bookings;

      ?>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua-active">
            <div class="inner">
              <h3><?php echo e($total_online_bookings); ?></h3>

              <p>Total online Bookings</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-phone"></i>
            </div>
<!--             <a href="<?php echo e(url('/')); ?>/dashboard_manage_student" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
 -->          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green-active">
            <div class="inner">
              <h3><?php echo e($total_service_bookings); ?></h3>

              <p>Total service Bookings</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-wrench"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange-active">
            <div class="inner">
              <h3>0</h3>

              <p>Total Appointments </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>


         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple-active">
            <div class="inner">
              <h3>0</h3>

              <p>Total Enquiries</p>
            </div>
            <div class="icon">
              <i class="fa fa-phone-square"></i>
            </div>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo e($todays_online_bookings); ?></h3>

              <p>Today's online Bookings</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-phone"></i>
            </div>
          </div>
        </div>

         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php echo e($todays_service_bookings); ?></h3>

              <p>Today's service Bookings</p>
            </div>
            <div class="icon">
              <i class="glyphicon glyphicon-wrench"></i>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-orange">
            <div class="inner">
              <h3>0</h3>

              <p>Today's Appointments </p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3>0</h3>

              <p>Today's Enquiries</p>
            </div>
            <div class="icon">
              <i class="fa fa-phone-square"></i>
            </div>
          </div>
        </div>
        </div>
      <!-- /.row -->
      <!-- Main row -->
        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/demo/admin/resources/views/admin/dashbord.blade.php ENDPATH**/ ?>