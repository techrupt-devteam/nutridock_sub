@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_user">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>
    <style type="text/css">
      .parsley-custom-error-message{
        color: red;
      }
      .parsley-minlength{
        color: red;
      }
      .parsley-maxlength{
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
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">First Name</label>
                      <input type="text" class="form-control" id="first_name" name="first_name" data-parsley-error-message="Please enter valid name." data-parsley-pattern="^[a-zA-Z]+$" placeholder="First Name" value="{{Session::get('first_name')}}" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Last Name</label>
                      <input type="text" class="form-control" id="last_name" name="last_name" value="{{Session::get('last_name')}}" data-parsley-error-message="Please enter valid name."  data-parsley-pattern="^[a-zA-Z]+$"  placeholder="Last Name" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Mobile No.</label>
                      <input type="number" class="form-control" id="mobile_no" name="mobile_no" value="{{Session::get('mobile_no')}}" data-parsley-minlength="10" data-parsley-maxlength="10" data-parsley-minlength-message="Mobile No. should be 10 digit." data-parsley-maxlength-message="Mobile No. should be 10 digit." placeholder="Mobile No." required="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Email</label>
                      <input type="text" class="form-control" id="email" name="email" value="{{Session::get('email')}}" data-parsley-error-message="Please enter valid email." data-parsley-pattern="^([\w\-\.]+)@((\[([0-9]{1,3}\.){3}[0-9]{1,3}\])|(([\w\-]+\.)+)([a-zA-Z]{2,4}))$"  placeholder="Email" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Password</label>
                      <input type="password" class="form-control" id="password" name="password" value="{{Session::get('password')}}" placeholder="Password" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Company Name</label>
                      <input type="text" class="form-control" id="company_name" name="company_name" value="{{Session::get('company_name')}}" placeholder="Company Name" required="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Company Address</label>
                      <input type="text" class="form-control" id="company_address" name="company_address" value="{{Session::get('company_address')}}" placeholder="Company Address" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">State</label>
                      <select class="form-control" id="state" name="state" onchange="change_state()" required="true">
                        <option value="">Select State</option>
                        @foreach($state as $value)
                        <option value="{{$value->state}}">{{$value->state}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">City</label>
                      <select class="form-control" id="city" name="city" onchange="change_city()" required="true">
                        <option value="">Select City</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Pincode</label>
                      <select class="form-control" id="pincode" name="pincode" required="true">
                        <option value="">Select Pincode</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Pan Number</label>
                      <input type="text" class="form-control" id="pan_number" name="pan_number" data-parsley-error-message="Please enter valid PAN Number" data-parsley-pattern="^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$" value="{{Session::get('id_number')}}" placeholder="Pan Number" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">PAN Document</label>
                      <input type="file" class="form-control" id="upload_pan" name="upload_pan" placeholder="KYC Document" required="true">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">GST No.</label>
                      <input type="text" class="form-control" id="gst_no" name="gst_no" value="{{Session::get('gst_no')}}" placeholder="GST No." data-parsley-error-message="Please enter valid GST No." data-parsley-pattern="\d{2}[A-Z]{5}\d{4}[A-Z]{1}[A-Z\d]{1}[Z]{1}[A-Z\d]{1}" required="true">
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">ID Proof 2</label>
                      <select class="form-control" id="kyc_document_type" name="kyc_document_type" required="true">
                        <option value="">Select ID Proof</option>
                        <option value="Aadhar Card">Aadhar Card</option>
                        <option value="Driver's License">Driver's License</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">KYC Document</label>
                      <input type="file" class="form-control" id="kyc_document" name="kyc_document" placeholder="KYC Document" required="true">
                    </div>
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Vendor Category</label>
                      <select id="vendor_category_id" name="vendor_category_id" class="form-control" required="">
                        <option value="">Select Vendor Category</option>
                        @foreach($vendor_category as $value)
                        <option value="{{$value->id}}">{{$value->vendor_category}}</option>
                        @endforeach
                      </select>
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