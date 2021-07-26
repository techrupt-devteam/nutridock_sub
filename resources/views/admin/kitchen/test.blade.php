@extends('admin.layout.master')
@section('content') 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) --> 
<!-- Main content -->
<section class="content">
<div class="row"> 
  <!-- left column -->
  <div class="col-md-12"> 
    <!-- general form elements --> 
    @include('admin.layout._status_msg')
    <div class="box">
      <div class="box-header">

      </div>
      <div class="box-body"> 
        <!-- form start -->
        <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
          {!! csrf_field() !!}
          <div class="row">
            <div class="col-md-6">
              <div class="box-body">
                <div class="form-group">
                  <label for="Kitchen_name">Enter Pincode<span style="color:red;" >*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="pincode" name="pincode" data-parsley-errors-container="#Kitchen_names" data-parsley-error-message="Please enter pincode."  placeholder="Enter Pincode" required >
                  <div id="Kitchen_names" style="color:red;"></div>
                  <div class="row">
                    <div class="col-md-12" id="data_display">
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
         
          <div class="box-footer">
            <div class="row">
              <div class="col-md-12">
                <button type="button" class="btn btn-primary" onclick="getlatlong();">Submit</button>
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a> </div>
            </div>
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
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net/js/jquery.dataTables.min.js"></script> 
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/datatables.net-bs/js/dataTables.bootstrap.min.js"></script> 
<script type="text/javascript">
  //load lat long script
  function  getlatlong(){
      var pcode = $("#pincode").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/nearKitchen",
        data: {
          pincode: pcode
        }
      }).done(function(data) {
           $("#data_display").html(data);
      });
  }  
</script> 
@endsection