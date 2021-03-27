@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{url('/admin')}}/store_location" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
              <div class="box-body">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">State<span style="color:red;" >*</span></label>
                      <select class="form-control select2" id="state" name="state" required="true" onchange="get_city();"  data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state.">
                        <option value="">Select State</option>
                        @foreach($state as $svalue)
                        <option value="{{$svalue->id}}">{{$svalue->name}}</option>
                        @endforeach
                      </select>
                        <div id="state_error" style="color:red;"></div>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">City<span style="color:red;" >*</span></label>
                      <select class="form-control select2" id="city" name="city" required="true" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city.">
                        <option value="">Select City</option>
                      </select>
                        <div id="city_error" style="color:red;"></div>                     
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">Area<span style="color:red;" >*</span></label>
                      <input type="text" autocomplete="off" class="form-control " id="area" name="area" placeholder="Area" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please enter area.">
                        <div id="area_error" style="color:red;"></div>                     
                    </div>
                  </div>
                </div><div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">Pincode<span style="color:red;" >*</span></label>
                      <input type="text" autocomplete="off" class="form-control " id="pincode" name="pincode" placeholder="Pinocde" data-parsley-type="number" required="true" data-parsley-errors-container="#pincode_error" >
                        <div id="pincode_error" style="color:red;"></div>                     
                    </div>
                  </div>  
               </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
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
  //load city drop down script 
   function get_city(){
      var state_id = $("#state").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#city").html(data);
      });
    }
</script>
@endsection