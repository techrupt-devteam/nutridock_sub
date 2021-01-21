 
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
        <li><a href="<?php echo e(url('/admin')); ?>/nexa_home_banner">Manage <?php echo e($title); ?></a></li>
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
            <form action="<?php echo e(url('/admin')); ?>/update_offer/<?php echo e($data->id); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php echo csrf_field(); ?>

              
              <div class="box-body">

                
                 <div class="form-group">
                  <img id="output_image1" height="200px" width="220" src="https://www.marutiseva.com/<?php echo e($data->banner); ?>"/>
                      <span class='error help-block'><?php echo e($errors->first('image_video')); ?></span>
                      <label for="oldpassword">Image<span style="color:red;" >*</span></label>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="<?php echo e(url('/admin')); ?>/nexa_home_banner" type="submit" class="btn btn-primary pull-right">Back</a>
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
  <script type="text/javascript">
    function function_car()
  {
       var selectValue = $("#car_maker").val();           
        $.ajax({
            url: 'https://www.marutiseva.com/admin/admin/getvarient',
            type: 'post',
            data: {id: selectValue},
            success: function (data) 
            {
              $("#varient").html(data);
            }
        });
  }

  function function_varient()
  {
       var selectValue = $("#varient").val();            
       var car = $("#car_maker").val();  
       $.ajax({
            url: 'https://www.marutiseva.com/admin/admin/getcolor',
            type: 'post',
            data: {varient: selectValue,car: car},
            success: function (data) 
            {
              $("#color").html(data);
            }
        });
        //$("#city_id_").empty();
        
        
  }
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/view_nexa_home_banner.blade.php ENDPATH**/ ?>