 
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
              <form action="<?php echo e(url('/admin')); ?>/update_<?php echo e($url_slug); ?>/<?php echo e($data['id']); ?>" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              <?php echo csrf_field(); ?>

              <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="nutritionsit_name" name="nutritionsit_name" placeholder="Nutritionsit Name"  value="<?php echo e($data['name']); ?>"required="true">
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
                        <input type="text" class="form-control" data-parsley-type="email" id="nutritionsit_email" name="nutritionsit_email" placeholder="Nutritionsit Email" required="true" value="<?php echo e($data['email']); ?>">
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
                             <input  type="text"  class="form-control" data-parsley-type="integer"  maxlength="10" id="nutritionsit_mobile" name="nutritionsit_mobile" placeholder="Nutritionsit Mobile" required="true"  value="<?php echo e($data['mobile']); ?>">
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
                          <?php $__currentLoopData = $state; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $svalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php 
                            $selected = "";
                            if($data['state'] == $svalue->id){
                             $selected ="selected";
                            }
                          ?>
                          <option value="<?php echo e($svalue->id); ?>" <?php echo e($selected); ?>><?php echo e($svalue->name); ?></option>t
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                        <select class="form-control" name="nutritionsit_role" id="nutritionsit_role" required="true" readonly>
                          <option value="">-Select Role-</option>t
                          <?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                          <option value="<?php echo e($rvalue->role_id); ?>" <?php if($rvalue->role_id==1) echo "selected"; ?>><?php echo e($rvalue->role_name); ?></option>t
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                   <div class="col-md-12">
                      <div class="box-body"><span><b>Do You want to change nutrionsit password please check checkbox on update password</b></span> <hr/>
                        <div class="col-md-4">
                          <div class="form-group" >
                              <label><input type="checkbox" id="chkPassword" name="chkPassword"><label for="nutritionsit_update">  Update Passsword</label></label>
                              <input type="text" class="form-control"  id="nutritionsit_password_new" name="nutritionsit_password_new" placeholder="New Password" style="display: none !important;">
                              <input type="hidden" class="form-control"  id="password" name="password" value="<?php echo e($data['password']); ?>">        
                          </div>
                        </div>
                      </div>
                   </div>  
                </div>
              <!-- /.box-footer-body -->
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
       getCity(); 
       getArea();   
    });

    function getCity() 
    {        
        var state_id = $('#nutritionsit_state').val()                   
        var city_id  = <?php echo  $data['city'];?>;            
        $.ajax({
            url: "<?php echo e(url('/admin')); ?>/getCity",
            type: 'post',
            data: { state: state_id ,city:city_id},
            success: function (data) 
            {
              $("#nutritionsit_city").html(data);
            }
        });
    };

    function getArea() 
    {        
        var city_id = <?php echo  $data['city'];?>;   
        var area_id = <?php echo  $data['area'];?>;
        $.ajax({
            url: "<?php echo e(url('/admin')); ?>/getArea",
            type: 'post',
            data: {city: city_id,area:area_id},
            success: function (data) 
            {
              $("#nutritionsit_area").html(data);
            }
        });
    };

  //load city drop down script 
  $("#nutritionsit_state").change(function() {
    
      var state_id = $("#nutritionsit_state").val();
      $.ajax({
        type: "POST",
        url: "<?php echo e(url('/admin')); ?>/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#nutritionsit_city").html(data);
      });
    });
 
  //load area drop down script 
  $("#nutritionsit_city").change(function() {
      var city_id = $("#nutritionsit_city").val();
      $.ajax({
        type: "POST",
        url: "<?php echo e(url('/admin')); ?>/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#nutritionsit_area").html(data);
      });
    });

   //checkbox show hide
   $(function () {
        $("#chkPassword").click(function () {
            if ($(this).is(":checked")) {
                $("#nutritionsit_password_new").show();
                $("#nutritionsit_password_new").attr("required","true");
            } else {
                $("#nutritionsit_password_new").hide();
                $("#nutritionsit_password_new").removeAttr("required");
                $(".parsley-required").hide();
            }
        });
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nutridock_sub\resources\views/admin/nutritionsit/edit.blade.php ENDPATH**/ ?>