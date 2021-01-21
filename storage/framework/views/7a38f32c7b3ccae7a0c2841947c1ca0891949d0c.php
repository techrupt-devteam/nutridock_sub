 
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
            <div class="box-header">
              <h3 class="box-title"><?php echo e($page_name." ".$title); ?></h3>
              <a href="<?php echo e(url('/admin')); ?>/add_nexa_home_banner" class="btn btn-primary btn-xs" style="float: right;">Add Banner</a>
            </div>
            
            <div class="box-header" style="display: none;">
                  <div class="box-body">
                    <div class="form-group">
                       <a class="btn bg-navy btn-xs" href="<?php echo e(url('/admin')); ?>/download_bookings" style="float: right;" >Download Excel</a>
                    </div>
                  </div>
              </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Image</th>
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
                        <img src="https://www.marutiseva.com/<?php echo e($value->banner); ?>" height="50px" width="60px">
                      </td>
                      <td>
                         <a href="<?php echo e(url('/admin')); ?>/edit_home_banner/<?php echo e($value->id); ?>" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a> 
                        <a href="<?php echo e(url('/admin')); ?>/view_nexa_home_banner/<?php echo e($value->id); ?>" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?php echo e(url('/admin')); ?>/delete_nexa_home_banner/<?php echo e($value->id); ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
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
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/nexa_home_banner.blade.php ENDPATH**/ ?>