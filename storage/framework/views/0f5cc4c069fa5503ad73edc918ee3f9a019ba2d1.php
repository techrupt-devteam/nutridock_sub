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
        <li><a href="<?php echo e(url('/admin')); ?>/manage_category">Manage <?php echo e($title); ?></a></li>
        <li class="active"><?php echo e($page_name." ".$title); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
           <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <div class="box box-primary">
            <!-- form start -->
            <form action="<?php echo e(url('/admin')); ?>/store_<?php echo e($url_slug); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
             
              <?php echo csrf_field(); ?>

              <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="nutritionsit_name" data-parsley-type="string" name="nutritionsit_name" placeholder="Nutritionsit Name" required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_email">Email<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                        <input type="text" class="form-control" data-parsley-type="email" id="nutritionsit_email" name="nutritionsit_email" placeholder="Nutritionsit Email" required="true">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Mobile<span style="color:red;" >*</span></label>
                         <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                             <input  type="text"  class="form-control" data-parsley-type="integer" id="nutritionsit_mobile" name="nutritionsit_mobile" placeholder="Nutritionsit Mobile" required="true">
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">  

                </select>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control" name="nutritionsit_state" id="nutritionsit_state" required="true">
                          <option value="">-Select State-</option>t
                          <option value=""></option>t
                        </select>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control" name="nutritionsit_city" id="nutritionsit_city" required="true">
                          <option value="">-Select City-</option>t
                          <option value=""></option>t
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control" name="nutritionsit_area" id="nutritionsit_area" required="true">
                          <option value="">-Select Area-</option>t
                          <option value=""></option>t
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Role<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="nutritionsit_name" name="nutritionsit_name" placeholder="Role Name" required="true">
                      </div>
                    </div>
                  </div>
                </div>   
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
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nutridock_sub\resources\views/admin/nutritionsit/add.blade.php ENDPATH**/ ?>