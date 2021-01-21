 
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
          <div class="box box-primary">
           <!--  <div class="box-header with-border">
              <h3 class="box-title"><?php echo e($page_name." ".$title); ?></h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start --> 
             <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <form action="<?php echo e(url('/admin')); ?>/update_<?php echo e($url_slug); ?>/<?php echo e($data['per_id']); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>

              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Select Role<span style="color:red;" >*</span></label>
                         <select name="role_id" id="role_id" class="form-control" required="true">
                         <option value="">-Select-</option>  
                           <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php $seleced = ($data['role_id']==$rvalue->role_id)? 'selected':'';?>
                             <option value="<?php echo e($rvalue->role_id); ?>" <?php echo e($seleced); ?>><?php echo e($rvalue->role_name); ?></option>  
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Select Type<span style="color:red;" >*</span></label>
                         <select name="type_id" id="type_id" class="form-control type_id" required="true">
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
                <div class="row">
                  <div class="col-md-12" id="menudiv">
                       
                  </div>
                </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo e(url('/admin')); ?>/manage_<?php echo e($url_slug); ?>"  class="btn btn-default">Back</a>
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
    $(document).ready(function() {
       getmenulist();   
    });


    function getmenulist() 
    {        
        var type_id = $("#type_id").val();            
        var per_id =  <?php echo $data['per_id']; ?>;            
        //$("#city_id_").empty();

        $.ajax({
            url: "<?php echo e(url('/admin')); ?>/getmenulist",
            type: 'post',
            data: {type_id: type_id,per_id: per_id},
            success: function (data) 
            {
              $("#menudiv").html(data);
            }
        });
    };

   $("select.type_id").change(function() {
      var type_id = $(".type_id option:selected").val();
      var per_id =  <?php echo $data['per_id']; ?>;     
      $.ajax({
        type: "post",
        url: "<?php echo e(url('/admin')); ?>/getmenu",
        data: {
          type_id: type_id,per_id:per_id
        }
      }).done(function(data) {
           var result = data.split('|');
           $("#menudiv").html(result[0]);
      });
    });
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\marutiseva_live\admin\resources\views/admin/permission/edit.blade.php ENDPATH**/ ?>