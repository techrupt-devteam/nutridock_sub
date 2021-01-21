 
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
        <li><a href="<?php echo e(url('/admin')); ?>/manage_booking">Manage <?php echo e($title); ?></a></li>
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
              <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
          <div class="row">  
            <div class="col-md-12">  
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Full Name:</label><span><?php echo e($data->name); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Email:</label><span><?php echo e($data->email); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Mobile No.:</label><span><?php echo e($data->mobile); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">City:</label><span><?php echo e($data->city); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Address:</label><span><?php echo e($data->address); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Car:</label><span><?php echo e($data->car); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Variant:</label><span><?php echo e($data->varient); ?></span>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Color:</label><span><?php echo e($data->color); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">On Road Cost:</label><span><?php echo e($data->road_cost); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Any Special Request:</label><span><?php echo e($data->special_request); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Do you Require Finance:</label><span><?php echo e($data->finance); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Booking Date:</label><span><?php echo e($data->date); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Transation:</label><span><?php echo e($data->transaction_id); ?></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Paid Amount:</label><span><?php echo e($data->amount); ?></span>
                  </div>
                </div>
              </div>
            </div>
            
            
           </div>
              <div class="box-header with-border box-footer">
                
              </div>

            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/demo/admin/resources/views/admin/booking/view_nexa_booking.blade.php ENDPATH**/ ?>