 
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
        <li><a href="#">Manage <?php echo e($title); ?></a></li>
        
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <?php echo $__env->make('admin.layout._status_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><!-- <?php echo e($page_name." ".$title); ?> --></h3>
              <a href="<?php echo e(url('/admin')); ?>/add_<?php echo e($url_slug); ?>" class="btn btn-primary btn-sm" style="float: right;">Add Subscription Plan</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Subscription Plan Name</th>
                  <th>Plan Name</th>
                  <th>City</th>
                  <th>Area</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
               
                  <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                      <td><?php echo e($key+1); ?></td>
                      <td><?php echo e(ucfirst($value->sub_name)); ?></td>
                      <td><?php echo e(ucfirst($value->plan_name)); ?></td>
                      <td><?php echo e(ucfirst($value->city_name)); ?></td>
                      <td><?php echo e(ucfirst($value->area_name)); ?></td>
                   
                      <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->sub_plan_id;?>);">
                           <i class="fa fa-info-circle"></i> Plan Details</button>
                         <?php if($value->is_active==1): ?>
                           <?php $checked="checked"; $style="success"; ?> 
                        <?php else: ?>
                           <?php $checked=""; $style="danger";?> 
                        <?php endif; ?>
                        <input type="checkbox" <?php echo e($checked); ?> data-toggle="toggle" data-onstyle="success" title="status" onchange="change_Status(<?php echo $key+1; ?>,<?php echo $value->sub_plan_id; ?>);" data-offstyle="danger" id="<?php echo e($key+1); ?>_is_active" data-size="small" data-style="slow" >
                      
                        <a href="<?php echo e(url('/admin')); ?>/edit_<?php echo e($url_slug); ?>/<?php echo e($value->sub_plan_id); ?>" class="btn btn-primary btn-sm"  title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                       
                        <a href="<?php echo e(url('/admin')); ?>/delete_<?php echo e($url_slug); ?>/<?php echo e($value->sub_plan_id); ?>" class="btn btn-default btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i> 
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

<div class="modal fade" id="modal-details">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="content">
          
        </div>
      </div>
    </div>
  </div>

  <!-- /.content-wrapper -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
 <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  
<script type="text/javascript">


    function change_Status(id,plan_id) 
    {  

      swal({
        title: "Subscription Plan status",
        text: "Are You sure to change plan status",
        icon: "warning",
      
        dangerMode: true,
        }).then(function(isConfirm) {
        if (isConfirm) { 
        var status = $("#"+id+"_is_active").prop('checked');
        var plan_ids = plan_id;
        //alert(status);
         $.ajax({
              url: "<?php echo e(url('/admin')); ?>/status_subscription_plan",
              type: 'post',
              data: {status:status,plan_ids:plan_id},
              success: function (data) 
              {
                swal("Good job!", "plan status successfully changed !", "success");
              }
          });
        }
      });
     }

    function viewDetails(plan_id) 
    { 

      var sub_plan_id = plan_id;
      //alert(status);
       $.ajax({
            url: "<?php echo e(url('/admin')); ?>/subscription_plan_details",
            type: 'post',
            data: {plan_id:sub_plan_id},
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }
 </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nutridock_sub\resources\views/admin/subscription_plan/index.blade.php ENDPATH**/ ?>