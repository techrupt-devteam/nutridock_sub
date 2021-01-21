 <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y')?> <a href="https://hohtechlabs.com/">HOH TECH LABS</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
//  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/raphael/raphael.min.js"></script>
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- ChartJS -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/chart.js/Chart.js"></script>
<!-- daterangepicker -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/moment/min/moment.min.js"></script>
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/dist/js/pages/dashboard.js"></script>
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/dist/js/demo.js"></script>
<!-- Parsley -->
<script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/parsley.js"></script>

 <script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="<?php echo e(url('/admin_css_js')); ?>/css_and_js/admin/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script type="text/javascript">
   $(document).ready(function () {    
    /*$('#description_div').bind('cut copy paste', function (e) {
        e.preventDefault();
    });

    $('#product_fetures_div').bind('cut copy paste', function (e) {
        e.preventDefault();
    });*/
});
</script>

  <script>
    $(function () {
      //$("#datepicker").datepicker({ format: "dd/mm/yyyy" }).val();
      //$("#datepicker1").datepicker({ format: "dd/mm/yyyy" }).val();
      $('.my-colorpicker1').colorpicker()
      $("#datepicker_today").datepicker({ format: "yyyy-mm-dd",startDate:'today' }).val();
      $("#datepicker_today1").datepicker({ format: "yyyy-mm-dd",startDate:'today' }).val();

      $("#datepicker").datepicker({ format: "yyyy-mm-dd",autoclose: true}).val();
      $("#datepicker1").datepicker({ format: "yyyy-mm-dd",autoclose: true}).val();
   
      $('#example1').DataTable()
      $('#example2').DataTable({
        'paging'      : true,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false
      })
    })
  </script>
   <script type="text/javascript">
 $(document).ready(function(){
  $("#datepicker").change(function(){
      var startDate = new Date($('#datepicker').val());
      var endDate = new Date($('#datepicker1').val());

      if (startDate > endDate)
      {
        $('#datepicker1_error').text("End date can't be less than start date.");
        $('.parsley-required').text('');
        return false;
      }
      else
      {
        $('#datepicker1_error').text("");
        return true;
      }
  });
  $("#datepicker1").change(function(){
      var startDate = new Date($('#datepicker').val());
      var endDate = new Date($('#datepicker1').val());

      if (startDate > endDate)
      {
        $('.parsley-required').text('');
        $('#datepicker1_error').text("End date can't be less than start date.");
      }
      else
      {
        $('#datepicker1_error').text("");
      }
  });
});
 </script>
</body>
</html>
<?php /**PATH /home/marutiseva/public_html/demo/admin/resources/views/admin/layout/footer.blade.php ENDPATH**/ ?>