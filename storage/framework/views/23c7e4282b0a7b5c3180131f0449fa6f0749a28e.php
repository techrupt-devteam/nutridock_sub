<?php if(Session::has('error')): ?>
  <div class="alert alert-danger">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo e(Session::get('error')); ?>

  </div>
<?php endif; ?>
<?php if(Session::has('success')): ?>
  <div class="alert alert-success">
  	<button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo e(Session::get('success')); ?>

  </div>
<?php endif; ?><?php /**PATH /home/marutiseva/public_html/demo/admin/resources/views/admin/layout/_status_msg.blade.php ENDPATH**/ ?>