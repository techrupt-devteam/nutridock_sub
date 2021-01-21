@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." Delivery Boy" }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_delivery_boy">Manage Delivery Boy</a></li>
        <li class="active">{{ $page_name." Delivery Boy" }}</li>
      </ol>
    </section>
    <style type="text/css">
      .parsley-maxlength
      {
        color: red;
      }
      .parsley-custom-error-message
      {
        color: red;
      }
    </style>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." Delivery Boy" }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/admin')}}/update_deliverty_boy/{{$data['id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">First Name</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" data-parsley-error-message="Please enter valid name." data-parsley-pattern="^[a-zA-Z]+$"  value="{{$data['first_name']}}" placeholder="First Name" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" data-parsley-error-message="Please enter valid name." data-parsley-pattern="^[a-zA-Z]+$"  value="{{$data['last_name']}}" placeholder="Last Name" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Mobile No.</label>
                      <input type="number" class="form-control" id="mobile_no" name="mobile_no" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="Mobile No. should be 10 digit." data-parsley-maxlength-message="Mobile No. should be 10 digit." value="{{$data['mobile_no']}}" placeholder="Mobile No." required="true" readonly="">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Email</label>
                      <input type="text" class="form-control" id="email" name="email" data-parsley-error-message="Please enter valid email." data-parsley-pattern="^([\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$" value="{{$data['email']}}" placeholder="Email" required="true" readonly="">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Password</label>
                      <input type="password" class="form-control" id="password" name="password" value="{{$data['password']}}" placeholder="Password" required="true">
                    </div>
                  </div>
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
    function change_state() 
    {        
        var selectValue = $("#state").val();            
        //$("#city_id_").empty();

        $.ajax({
            url: '{{url('/admin')}}/getcity',
            type: 'post',
            data: {id: selectValue},
            success: function (data) 
            {
              $("#city").html(data);
            }
        });
    };

    function change_city() 
    {        
        var selectValue = $("#city").val();            
        //$("#pincode_id_").empty();

        $.ajax({
            url: '{{url('/admin')}}/getpincode',
            type: 'post',
            data: {id: selectValue},
            success: function (data) 
            {
              $("#pincode").html(data);
            }
        });
    };
  </script>
@endsection