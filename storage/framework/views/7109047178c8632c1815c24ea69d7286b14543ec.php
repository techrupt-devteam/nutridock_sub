 
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
        <li><a href="<?php echo e(url('/')); ?>/admin/nexa_value_add_services">Manage <?php echo e($title); ?></a></li>
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
            <form action="<?php echo e(url('/admin')); ?>/nexa_update_value_add_services/<?php echo e($data->id); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php echo csrf_field(); ?>

              
              <div class="box-body">

                <div class="form-group">
                  <label for="oldpassword">Service Name<span style="color:red;" >*</span></label>
                 
                 <input class="form-control" type="text" name="service_name" id="service_name" required="" value="<?php echo e($data->service_name); ?>">
                </div>
                <div class="form-group">
                  <label for="oldpassword">Service Type<span style="color:red;" >*</span></label>
                   <input class="form-control" type="text" name="service_type" id="service_type" required="" value="<?php echo e($data->service_type); ?>">
                </div>
                <div class="form-group">
                  <label for="oldpassword">Price<span style="color:red;" >*</span></label>
                    <input class="form-control" type="text" name="price" id="price" required="" value="<?php echo e($data->price); ?>">
                </div>
                 <div class="form-group">
                  <label for="oldpassword">Description<span style="color:red;" >*</span></label>
                    <textarea class="form-control" type="text" name="description" id="description" required="" ><?php echo e($data->description); ?></textarea>
                </div>
                <div class="form-group">
                  <label for="oldpassword">Video Image<span style="color:red;" >*</span></label>
                  
                     <img id="output_image1" height="100px" width="100px" src="https://www.marutiseva.com/<?php echo e($data->video_banner); ?>"/>
                  
                  <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="preview_image(event,1)" required="true">
                </div>
                <div class="form-group">
                  <label for="oldpassword">Video Link<span style="color:red;" >*</span></label>
                    <input class="form-control" type="text" name="video_link" id="video_link" required="" value="<?php echo e($data->video_link); ?>">
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
  <script type="text/javascript">
    function function_car()
  {
       var selectValue = $("#car_maker").val();           
        $.ajax({
            url: 'https://www.marutiseva.com/admin/admin/getvarientnexa',
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
            url: 'https://www.marutiseva.com/admin/admin/getcolornexa',
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
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/nexa_edit_value_add_services.blade.php ENDPATH**/ ?>