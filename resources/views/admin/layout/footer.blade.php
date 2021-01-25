 <footer class="main-footer" >
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0
    </div>
    <strong>Copyright &copy; <?php echo date('Y')?> <a href="https://hohtechlabs.com/">TECHRUPT</a>.</strong> All rights
    reserved.
  </footer>


  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
//  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/raphael/raphael.min.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- ChartJS -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/chart.js/Chart.js"></script>
<!-- daterangepicker -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/moment/min/moment.min.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/dist/js/pages/dashboard.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/dist/js/pages/dashboard2.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/dist/js/demo.js"></script>
<!-- Parsley -->
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/css/select2.min.css">


  <script>

  
    $(function () {

      $('.select2').select2();
      
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
