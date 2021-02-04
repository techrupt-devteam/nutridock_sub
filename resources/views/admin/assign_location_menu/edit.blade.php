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

              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['assign_menu_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
                <div class="row">  
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">State<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="state_id" id="state_id" required="true" onchange="getCity();">
                          <option value="">-Select State-</option>
                          @foreach($state as $svalue)
                          @php 
                            $selected = "";
                            if($data['state_id'] == $svalue->id){
                             $selected ="selected";
                            }
                          @endphp
                          <option value="{{$svalue->id}}" {{$selected}}>{{$svalue->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div><div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="city_id" id="city_id" required="true" onchange="getArea();">
                          <option value="">-Select City-</option>
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="area_id">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="area_id" id="area_id" required="true">
                          <option value="">-Select Area-</option>
                          <option value=""></option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="operation_manager_name">Menu<span style="color:red;" >*</span></label>
                        <select class="form-control select2" name="menu_id" id="menu_id" required="true" data-parsley-errors-container="#menu_error" data-parsley-error-message="Please select menu.">
                          <option value="">-Select Menu-</option>
                          @foreach($menu as $mvalue)
                            @php 
                            $selected = "";
                            if($data['menu_id'] == $mvalue->id){
                             $selected ="selected";
                            }
                          @endphp
                          <option value="{{$mvalue->id}}" {{$selected}}>{{$mvalue->menu_title}}</option>
                          @endforeach
                        </select>
                        <div id="menu_error" style="color:red;"></div>
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
        var state_id = $('#state_id').val()                   
        var city_id  = <?php echo  $data['city_id'];?>;            
        $.ajax({
            url: "{{url('/admin')}}/getCity",
            type: 'post',
            data: { state: state_id ,city:city_id},
            success: function (data) 
            {
              $("#city_id").html(data);
            }
        });
    };

    function get_Area() 
    {        
        var city_id = <?php echo  $data['city_id'];?>;   
        var area_id = <?php echo  $data['area_id'];?>;
        $.ajax({
            url: "{{url('/admin')}}/getArea",
            type: 'post',
            data: {city: city_id,area:area_id},
            success: function (data) 
            {
              $("#area_id").html(data);
            }
        });
    };

  //load city drop down script 
 
    function getCity(){
      var state_id = $("#state_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getCity",
        data: {
          state: state_id
        }
      }).done(function(data) {
           $("#city_id").html(data);
      });
   }
 
  //load area drop down script 
    function getArea(){
      var city_id = $("#city_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#area_id").html(data);
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
