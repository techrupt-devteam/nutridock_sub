 
<?php $__env->startSection('content'); ?>
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo e($page_name." ".$title); ?>

        
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo e(url('/')); ?>/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo e(url('/')); ?>/manage_<?php echo e($url_slug); ?>">Manage <?php echo e($title); ?></a></li>
        <li class="active"><?php echo e($page_name." ".$title); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo e($page_name." ".$title); ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="<?php echo e(url('/admin')); ?>/update_location/<?php echo e($data->id); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php echo csrf_field(); ?>

              
              <div class="box-body">
                <div class="form-group">
                  <label for="oldpassword">City<span style="color:red;" >*</span></label>
                  <select class="form-control" id="city" name="city" required="true">
                  <option value="">Select City</option>
                  <option value="Nagpur" <?php if($data->city=='Nagpur'): ?> selected="" <?php endif; ?>>Nagpur</option>
                  <option value="Wardha" <?php if($data->city=='Wardha'): ?> selected="" <?php endif; ?>>Wardha</option>
                  <option value="Nanded" <?php if($data->city=='Nanded'): ?> selected="" <?php endif; ?>>Nanded</option>
                  <option value="Dhule" <?php if($data->city=='Dhule'): ?> selected="" <?php endif; ?>>Dhule</option>
                  <option value="Nandurbar" <?php if($data->city=='Nandurbar'): ?> selected="" <?php endif; ?>>Nandurbar</option>
                  <option value="Nashik" <?php if($data->city=='Nashik'): ?> selected="" <?php endif; ?>>Nashik</option>
                  <option value="Hinganghat" <?php if($data->city=='Hinganghat'): ?> selected="" <?php endif; ?>>Hinganghat</option>
                </select>
                </div>
                <div class="form-group">
                  <label for="oldpassword">Area<span style="color:red;" >*</span></label>
                  <input type="text" class="form-control" id="area" name="area" placeholder="Area" required="true" value="<?php echo e($data->area); ?>">
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/edit_location.blade.php ENDPATH**/ ?>