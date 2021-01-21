 
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
          <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <!-- general form elements -->
          <div class="box box-primary">
           <!--  <div class="box-header with-border">
              <h3 class="box-title"><?php echo e($page_name." ".$title); ?></h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start --> 
            
              <form action="<?php echo e(url('/admin')); ?>/update_<?php echo e($url_slug); ?>/<?php echo e($data['id']); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="first_name">First Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required="true" value="<?php echo e($data['first_name']); ?>">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="last_name">Last Name<span style="color:red;" >*</span></label>
                        <input type="text" value="<?php echo e($data['last_name']); ?>" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="email">Email<span style="color:red;" >*</span></label>
                        <input type="email" class="form-control" id="email" name="email"  value="<?php echo e($data['email']); ?>" placeholder="Email" required="true">
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
              <div class="row">
                <div class="col-md-12">
                  <!-- <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="oldpassword">Password<span style="color:red;" >*</span></label>
                        <input type="passsword" class="form-control" value="<?php echo e($data['password']); ?>" id="password" name="password" placeholder="Password" required="true">
                      </div>
                    </div>
                  </div> -->
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="city">City<span style="color:red;" >*</span></label>
                        <select name="city" id="city" class="form-control city" required="true">
                         <option value="">-Select-</option>  
                         <?php $__currentLoopData = $city; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php $selected="" ;?>
                           <?php if($data['city']==$cvalue->city): ?>  
                            <?php $selected="selected"; ?> 
                           <?php endif; ?>
                         <option value="<?php echo e($cvalue->city); ?>" <?php echo e($selected); ?>><?php echo e($cvalue->city); ?></option>  
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="area">Area<span style="color:red;" >*</span></label>
                         <select name="area" id="area" class="form-control" required="true">
                            <?php $__currentLoopData = $location; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                           <?php $selected="" ;?>
                           <?php if($data['area']==$lvalue->area): ?>  
                            <?php $selected="selected"; ?> 
                           <?php endif; ?>
                         <option value="<?php echo e($lvalue->area); ?>" <?php echo e($selected); ?>><?php echo e($lvalue->area); ?></option>  
                         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Select Role<span style="color:red;" >*</span></label>
                         <select name="role" id="role" class="form-control" required="true">
                         <option value="">-Select-</option>  
                           <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php $seleced = ($data['role']==$rvalue->role_id)? 'selected':'';?>
                             <option value="<?php echo e($rvalue->role_id); ?>" <?php echo e($seleced); ?>><?php echo e($rvalue->role_name); ?></option>  
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Select Type<span style="color:red;" >*</span></label>
                         <select name="type_id" id="type_id" class="form-control" required="true">
                         <option value="">-Select-</option>  
                           <?php $__currentLoopData = $type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php $seleced = ($data['type_id']==$tvalue->type_id)? 'selected':'';?>
                             <option value="<?php echo e($tvalue->type_id); ?>" <?php echo e($seleced); ?>><?php echo e($tvalue->type_name); ?></option>  
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                      </div>
                    </div>
                  </div>
                 </div>  
              </div>  

              <!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo e(url('/admin')); ?>/manage_<?php echo e($url_slug); ?>s"  class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary pull-right">Update</button>
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

    $("select.city").change(function() {
      var selectedCity = $(".city option:selected").val();
      $.ajax({
        type: "post",
        url: "<?php echo e(url('/admin')); ?>/getArea",
        data: {
          city: selectedCity
        }
      }).done(function(data) {
          var result = data.split('|');
          $("#area").html(result[0]);
      });
    });

 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\marutiseva_live\admin\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>