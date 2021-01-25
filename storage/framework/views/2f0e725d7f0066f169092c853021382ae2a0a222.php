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
                        <label for="operation_manager_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="operation_manager_name" name="operation_manager_name" placeholder="Nutritionsit Name" required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_email">Email<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                        <input type="text" class="form-control" data-parsley-type="email" id="operation_manager_email" name="operation_manager_email" placeholder="Nutritionsit Email" required="true">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">Mobile<span style="color:red;" >*</span></label>
                         <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                             <input  type="text"  class="form-control" data-parsley-type="integer"  maxlength="10" id="operation_manager_mobile" name="operation_manager_mobile" placeholder="Nutritionsit Mobile" required="true">
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
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_state" id="operation_manager_state" required="true">
                          <option value="">-Select State-</option>t
                          <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($svalue->id); ?>"><?php echo e($svalue->name); ?></option>t
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_city" id="operation_manager_city" required="true">
                          <option value="">-Select City-</option>t
                          <option value=""></option>t
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_area" id="operation_manager_area" required="true">
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
                        <label for="operation_manager_name">Role<span style="color:red;" >*</span></label>
                        <select class="form-control" name="operation_manager_role" id="operation_manager_role" required="true" readonly>
                          <option value="">-Select Role-</option>t
                          <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                          <option value="<?php echo e($rvalue->role_id); ?>" <?php if($rvalue->role_id==1) echo "selected"; ?>><?php echo e($rvalue->role_name); ?></option>t
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">

  //load city drop down script 
  $("select#operation_manager_state").change(function() {
      var state_id = $("#operation_manager_state option:selected").val();
      $.ajax({
        type: "POST",
        url: "<?php echo e(url('/admin')); ?>/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#operation_manager_city").html(data);
      });
    });
 
  //load area drop down script 
  $("select#operation_manager_city").change(function() {
      var city_id = $("#operation_manager_city option:selected").val();
      $.ajax({
        type: "POST",
        url: "<?php echo e(url('/admin')); ?>/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#operation_manager_area").html(data);
      });
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nutridock_sub\resources\views/admin/operationmanager/add.blade.php ENDPATH**/ ?>