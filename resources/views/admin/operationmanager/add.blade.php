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
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_user_manager">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
           @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
                {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}
              </h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_user_manager">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
            <div class="box-body">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}_manager" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
             
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" autocomplete="off" class="form-control" id="operation_manager_name" name="operation_manager_name" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter name."  placeholder="Name" required="true">
                         <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_email">Email<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                        <input type="text" autocomplete="off" class="form-control" data-parsley-type="email" id="operation_manager_email" name="operation_manager_email" placeholder="Email" required="true" data-parsley-errors-container="#email_error" data-parsley-error-message="Please enter email.">
                      </div>
                        <div id="email_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_name">Mobile No<span style="color:red;" >*</span></label>
                         <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                             <input type="text" autocomplete="off"  class="form-control" data-parsley-type="integer"  maxlength="10" id="operation_manager_mobile" name="operation_manager_mobile" placeholder="Mobile No" required="true" data-parsley-errors-container="#mobile_error" data-parsley-error-message="Please enter mobile no.">
                          </div>
                           <div id="mobile_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3">
                  <div class="">
                    <label for="name">Profile Pic</label>
                    <div class="input-group">
                          <div class="input-group-addon btn-default">
                            <i class="fa fa-user"></i>
                          </div>
                            <input type="file" class="form-control"  id="profile_image" name="profile_image"data-parsley-errors-container="#img_msg" >
                           
                      </div>
                       <span id="img_msg" style="color:red;"></span>
                  </div>
                </div>
                </div>
                <div class="row">  

                </select>
                  <div class="col-md-4">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_state" id="operation_manager_state" required="true" data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." onchange="getCity();">
                          <option value="">-Select State-</option>
                          @foreach($state as $svalue)
                          <option value="{{$svalue->id}}">{{$svalue->name}}</option>
                          @endforeach
                        </select>
                         <div id="state_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2"  name="operation_manager_city" id="operation_manager_city"  data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." required="true" onchange="getArea();">
                          <option value="">-Select City-</option>
                          <option value=""></option>
                        </select>
                        <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2"  name="operation_manager_area" id="operation_manager_area" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area.">
                          <option value="">-Select Area-</option>
                          <option value=""></option>
                        </select>
                        <div id="area_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="row">  
                  <div class="col-md-4">
                    <div>
                      <div class="form-group">
                        <label for="operation_manager_name">Role<span style="color:red;" >*</span></label>
                        <select class="form-control" name="operation_manager_role" id="operation_manager_role" required="true" data-parsley-errors-container="#role_error" data-parsley-error-message="Please select role.">
                          <option value="">-Select Role-</option>
                          @foreach($role as $rvalue)
                          @if($rvalue->role_id !=1)               
                           <option value="{{$rvalue->role_id}}" >{{$rvalue->role_name}}</option>
                          @endif
                          @endforeach
                        </select>
                        <div id="role_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>   
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                 <a href="{{url('/admin')}}/manage_user_manager"  class="btn btn-default">Back</a>
              </div>
            </form>
           </div>
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
  //$("select#operation_manager_state").change(function() {
    function  getCity(){
      var state_id = $("#operation_manager_state").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#operation_manager_city").html(data);
      });
    }  


   // });
 
  //load area drop down script 
  //$("select#operation_manager_city").change(function() {
      function  getArea(){
      var city_id = $("#operation_manager_city").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#operation_manager_area").html(data);
      });
    }
   // });

</script>
@endsection