 
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
        <li><a href="<?php echo e(url('/')); ?>/admin/value_add_services">Manage <?php echo e($title); ?></a></li>
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
            <form action="<?php echo e(url('/admin')); ?>/store_value_add_services" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php echo csrf_field(); ?>

              
              <div class="box-body">

                <div class="form-group">
                  <label for="oldpassword">Service Name<span style="color:red;" >*</span></label>
                 
                 <input class="form-control" type="text" name="service_name" id="service_name" required="">
                </div>
                <div class="form-group">
                  <label for="oldpassword">Service Type<span style="color:red;" >*</span></label>
                   <input class="form-control" type="text" name="service_type" id="service_type" required="">
                </div>
                <div class="form-group">
                  <label for="oldpassword">Price<span style="color:red;" >*</span></label>
                    <input class="form-control" type="text" name="price" id="price" required="">
                </div>
                 <div class="form-group">
                  <label for="oldpassword">Description<span style="color:red;" >*</span></label>
                    <textarea class="form-control" type="text" name="description" id="description" required=""></textarea>
                </div>
                <div class="form-group">
                  <label for="oldpassword">Video Image<span style="color:red;" >*</span></label>
                  
                     <img id="output_image1" height="100px" width="100px" src="<?php echo e(url('/')); ?>/css_and_js/top.png" />
                  
                  <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="preview_image(event,1)" required="true">
                </div>
                <div class="form-group">
                  <label for="oldpassword">Video Link<span style="color:red;" >*</span></label>
                    <input class="form-control" type="text" name="video_link" id="video_link" required="">
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
  function preview_image(event,id) 
        {   
            var input_id = event.target.id
            var fileInput = document.getElementById(input_id);
            //var filePath = event.path[0].files[0].name;
            var filePath = fileInput.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i;
            if(!allowedExtensions.exec(filePath))
            {
                fileInput.value = '';
                $("#error_imagepath"+id).text('Please upload file having extensions .jpeg/.jpg/.png/.gif only.');
                
                $('#output_image'+id).attr("src",'');
                return false;
            }
            else
            {
                //Image preview
                var reader = new FileReader();
                reader.onload = function()
                {
                    var output = document.getElementById('output_image'+id);
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }

  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/marutiseva/public_html/admin/resources/views/admin/booking/add_value_add_services.blade.php ENDPATH**/ ?>