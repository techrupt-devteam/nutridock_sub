<?php $__env->startSection('content'); ?>
 <section class="breadcrumbs-custom">
   <div class="parallax-container"data-parallax-img="<?php echo e(url('')); ?>/public/front/img/faq-bg.jpg">
      <div class="material-parallax parallax"><img alt=""src="<?php echo e(url('')); ?>/public/front/img/faq-bg.jpg"style="display:block;transform:translate3d(-50%,149px,0)"></div>
      <div class="breadcrumbs-custom-body context-dark parallax-content">
         <div class="container">
            <h2 class="breadcrumbs-custom-title">Dashboard</h2>
         </div>
      </div>
   </div>
   <div class="breadcrumbs-custom-footer">
      <div class="container">
         <ul class="breadcrumbs-custom-path">
            <li><a href="<?php echo e(url('')); ?>">Home</a></li>
            <li class="active">Dashboard</li>
         </ul>
      </div>
   </div>
</section>
<main>
   <section class="mt-4 bg-default section section-xl text-md-left">
      <div class="container">

      </div>
   </section>
</main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\nutridock_sub\resources\views/dashboard.blade.php ENDPATH**/ ?>