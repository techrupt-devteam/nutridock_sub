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
        <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
           @include('admin.layout._status_msg')
          <div class="box box-primary">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
             
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="nutritionsit_name" name="nutritionsit_name" placeholder="Nutritionsit Name" required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_email">Email<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                        <input type="text" class="form-control" data-parsley-type="email" id="nutritionsit_email" name="nutritionsit_email" placeholder="Nutritionsit Email" required="true">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Mobile<span style="color:red;" >*</span></label>
                         <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                             <input  type="text"  class="form-control" data-parsley-type="integer"  maxlength="10" id="nutritionsit_mobile" name="nutritionsit_mobile" placeholder="Nutritionsit Mobile" required="true">
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">  

                </select>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="nutritionsit_state" id="nutritionsit_state" required="true" onchange="getCity();">
                          <option value="">-Select State-</option>t
                          @foreach($state as $svalue)
                          <option value="{{$svalue->id}}">{{$svalue->name}}</option>t
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="nutritionsit_city" id="nutritionsit_city" required="true" onchange="getArea()">
                          <option value="">-Select City-</option>
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="nutritionsit_area" id="nutritionsit_area" required="true">
                          <option value="">-Select Area-</option>t
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">Role<span style="color:red;" >*</span></label>
                        <select class="form-control" name="nutritionsit_role" id="nutritionsit_role" required="true" readonly>
                          <option value="">-Select Role-</option>t
                          @foreach($role as $rvalue)
                          <option value="{{$rvalue->role_id}}" <?php if($rvalue->role_id==1) echo "selected"; ?>>{{$rvalue->role_name}}</option>t
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>   
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">

  //load city drop down script 
//  $("select#nutritionsit_state").change(function() {
   function  getCity(){
      var state_id = $("#nutritionsit_state").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#nutritionsit_city").html(data);
      });
    }
  //  });
 
  //load area drop down script 
  //$("select#nutritionsit_city").change(function() {
      function  getArea(){
      var city_id = $("#nutritionsit_city").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#nutritionsit_area").html(data);
      });
    }
  //  });

</script>
@endsection