 
<?php $__env->startSection('content'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo e($page_name." ".$title); ?>

       
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/admin')); ?>/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Manage <?php echo e($title); ?></a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <div class="box">
            <div class="box-header" style="display: none;">
              <h3 class="box-title"><?php echo e($page_name." ".$title); ?></h3>
              <a href="<?php echo e(url('/admin')); ?>/add_user" class="btn btn-primary btn-xs" style="float: right;">Add Vendor</a>
            </div>
            
            <div class="box-header">
                  <div class="box-body">
                    <div class="form-group">
                       <a class="btn bg-navy btn-xs" href="<?php echo e(url('/admin')); ?>/nexa_download_bookings" style="float: right;" >Download Excel</a>
                    </div>
                  </div>
              </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Full Name</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Booking Date</th>
                  <th>Status</th>
                  <th>Action</th>
                 
                </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td>
                        <?php echo e($key+1); ?>

                      </td>
                      <td>
                        <?php echo e($value->name); ?>

                      </td>
                      <td>
                        <?php echo e($value->email); ?>

                      </td>
                      <td>
                        <?php echo e($value->mobile); ?>

                      </td>
                       <td>
                        <?php echo e($value->date); ?>

                      </td>
                      <td>
                        <?php echo e($value->status); ?>

                      </td>
                      <td>
                        
                       <a href="<?php echo e(url('/admin')); ?>/view_nexa_booking/<?php echo e($value->id); ?>" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        
                      </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/nexa_booking.blade.php ENDPATH**/ ?>