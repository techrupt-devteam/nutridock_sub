 
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
              <a href="<?php echo e(url('/admin')); ?>/add_nexa_location" class="btn btn-primary btn-xs" style="float: right;">Add location</a>
            </div>
            
            
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>City</th>
                  <th>Area</th>
                  <th>Active/Inactive</th>
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
                        <?php echo e($value->city); ?>

                      </td>
                      <td>
                        <?php echo e($value->area); ?>

                      </td>
                      <td>
                        <?php if($value->is_active==1): ?>
                          <a class="btn btn-success btn-xs" href="<?php echo e(url('/admin')); ?>/change_nexa_location_status/<?php echo e(base64_encode($value->id)); ?>">Active</a>
                        <?php else: ?>
                          <a class="btn btn-danger btn-xs" href="<?php echo e(url('/admin')); ?>/change_nexa_location_status/<?php echo e(base64_encode($value->id)); ?>">Inactive</a>
                        <?php endif; ?>
                      </td> 
                      <td>
                        <a href="<?php echo e(url('/admin')); ?>/edit_nexa_location/<?php echo e($value->id); ?>" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="<?php echo e(url('/admin')); ?>/view_nexa_location/<?php echo e($value->id); ?>" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        <a href="<?php echo e(url('/admin')); ?>/delete_nexa_location/<?php echo e($value->id); ?>" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
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
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/nexa_locations.blade.php ENDPATH**/ ?>