@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

      <h1>
       Address Edit
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_user">{{ $title }} Master</a></li>
        <li><a href="{{url('/admin')}}/view_user/{{$data->user_id}}">View User</a></li>
        <li class="active">Address Edit</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box box-primary">
             {{-- 
            <div class="box-header with-border">
              <h3 class="box-title">Address Edit</h3> 
            </div>
              --}}
            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{ url('/admin')}}/update_address/{{$data->id}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              <div class="row">               
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Address</label>
                      <input type="text" class="form-control" id="address" name="address" value="{{$data->address}}" placeholder="Company Address" required="true">
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
                        <option value="{{$value->state}}" @if($data->state==$value->state) selected="" @endif >{{$value->state}}</option>
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
                        @foreach($city as $value)
                        <option value="{{$value->district}}" @if($data->city==$value->district) selected="" @endif>{{$value->district}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="oldpassword">Pincode</label>
                      <select class="form-control" id="pincode" name="pincode" required="true">
                        <option value="">Select Pincode</option>
                        @foreach($pincode as $value)
                        <option value="{{$value->pincode}}" @if($data->pincode==$value->pincode) selected="" @endif>{{$value->pincode}}</option>
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