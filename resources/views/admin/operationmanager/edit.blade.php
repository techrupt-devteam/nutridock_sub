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
          <div class="box box-primary">
           <!--  <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start --> 
             @include('admin.layout._status_msg')
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="operation_manager_name" name="operation_manager_name" placeholder="Operation Manager Name"  value="{{$data['name']}}"required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_email">Email<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                        <input type="text" class="form-control" data-parsley-type="email" id="operation_manager_email" name="operation_manager_email" placeholder="Operation Manager Email" required="true" value="{{$data['email']}}">
                      </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">Mobile<span style="color:red;" >*</span></label>
                         <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                             <input  type="text"  class="form-control" data-parsley-type="integer"  maxlength="10" id="operation_manager_mobile" name="operation_manager_mobile" placeholder="Operation Manager Mobile" required="true"  value="{{$data['mobile']}}">
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
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_state" id="operation_manager_state" required="true" onchange="getCity();">
                          <option value="">-Select State-</option>t
                          @foreach($state as $svalue)
                          @php 
                            $selected = "";
                            if($data['state'] == $svalue->id){
                             $selected ="selected";
                            }
                          @endphp
                          <option value="{{$svalue->id}}" {{$selected}}>{{$svalue->name}}</option>t
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_city" id="operation_manager_city" required="true" onchange="getArea();">
                          <option value="">-Select City-</option>t
                          <option value=""></option>t
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="operation_manager_area" id="operation_manager_area" required="true">
                          <option value="">-Select Area-</option>t
                          <option value=""></option>t
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                 <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">Role<span style="color:red;" >*</span></label>
                        <select class="form-control" name="operation_manager_role" id="operation_manager_role" required="true" readonly>
                          <option value="">-Select Role-</option>t
                          @foreach($role as $rvalue)

                          <option value="{{$rvalue->role_id}}" <?php if($rvalue->role_id==2) echo "selected"; ?>>{{$rvalue->role_name}}</option>t
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                   <div class="col-md-12">
                      <div class="box-body"><span><b>Do You want to change nutrionsit password please check checkbox on update password</b></span> <hr/>
                        <div class="col-md-4">
                          <div class="form-group" >
                              <label><input type="checkbox" id="chkPassword" name="chkPassword"><label for="operation_manager_update">  Update Passsword</label></label>
                              <input type="text" class="form-control"  id="operation_manager_password_new" name="operation_manager_password_new" placeholder="New Password" style="display: none !important;">
                              <input type="hidden" class="form-control"  id="password" name="password" value="{{$data['password']}}">        
                          </div>
                        </div>
                      </div>
                   </div>  
                </div>
              <!-- /.box-footer-body -->
              <div class="box-footer">
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary pull-right">Update</button>
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
    $(document).ready(function() {
       get_City(); 
       get_Area();   



    });

    function get_City() 
    {        
        var state_id = $('#operation_manager_state').val()                   
        var city_id  = <?php echo  $data['city'];?>;            
        $.ajax({
            url: "{{url('/admin')}}/getCity",
            type: 'post',
            data: { state: state_id ,city:city_id},
            success: function (data) 
            {
              $("#operation_manager_city").html(data);
            }
        });
    };

    function get_Area() 
    {        
        var city_id = <?php echo  $data['city'];?>;   
        var area_id = <?php echo  $data['area'];?>;
        $.ajax({
            url: "{{url('/admin')}}/getArea",
            type: 'post',
            data: {city: city_id,area:area_id},
            success: function (data) 
            {
              $("#operation_manager_area").html(data);
            }
        });
    };

  //load city drop down script 
 
    function getCity(){
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
 
  //load area drop down script 
    function getArea(){
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
   
   //checkbox show hide
   $(function () {
        $("#chkPassword").click(function () {
            if ($(this).is(":checked")) {
                $("#operation_manager_password_new").show();
                $("#operation_manager_password_new").attr("required","true");
            } else {
                $("#operation_manager_password_new").hide();
                $("#operation_manager_password_new").removeAttr("required");
                $(".parsley-required").hide();
            }
        });
    });

</script>
@endsection
