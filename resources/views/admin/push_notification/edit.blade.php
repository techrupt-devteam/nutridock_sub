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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>

            <!-- /.box-header -->
            <!-- form start -->
            <form action="{{url('/admin')}}/update_{{$url_slug}}/{{$data['push_notification_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
              <div class="box-body">
                 <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label for="oldpassword">Notification Name<span style="color:red;" >*</span></label>
                      <input type="text" class="form-control" name="notification_name" data-parsley-error-message="Please enter notification name." value="{{$data['notification_name']}}">                    
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">Kitchen<span style="color:red;" >*</span></label>
                      <select class="form-control select2" id="kitchen_id" name="kitchen_id" required="true"  data-parsley-errors-container="#kitchen_error" data-parsley-error-message="Please select kitchen.">
                        <option value="">Select kitchen</option>
                         @php 
                            $selected1 = "";
                            if($data['kitchen_id'] == 0){
                             $selected1 ="selected";
                            }
                          @endphp
                        <option value="0" {{$selected1}}>All</option>
                        @foreach($kitchen as $kvalue)
                         @php 
                            $selected = "";
                            if($data['kitchen_id'] == $kvalue->kitchen_id){
                             $selected ="selected";
                            }
                          @endphp
                        <option value="{{$kvalue->kitchen_id}}"  {{$selected}}>{{$kvalue->kitchen_name}}</option>
                        @endforeach
                      </select>
                        <div id="kitchen_error" style="color:red;"></div>                     
                    </div>
                  </div>
                </div>
<!--                 <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">State<span style="color:red;" >*</span></label>
                      <select class="form-control select2" id="state_id" name="state_id" required="true" onchange="get_city();" data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state.">
                        <option value="">Select State</option>
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
                         <div id="state_error" style="color:red;"></div> 
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">City<span style="color:red;" >*</span></label>
                       <select class="form-control select2" id="city_id" name="city_id" required="true" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." onchange="getArea();">

                        <option value="">Select City</option>
                         @foreach($city as $cvalue)
                           @php 
                              $selected = "";
                              if($data['city_id'] == $cvalue->id){
                               $selected ="selected";
                              }
                            @endphp
                          <option value="{{$cvalue->id}}" {{$selected}}>{{$cvalue->city_name}}</option>
                          @endforeach
                      </select>
                        <div id="city_error" style="color:red;"></div>   
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label for="oldpassword">Area<span style="color:red;" >*</span></label>
                      <select class="form-control select2" id="area_id" name="area_id" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select city.">
                        <option value="">Select Area</option>
                      </select>
                        <div id="area_error" style="color:red;"></div>         
                    </div>
                  </div> 
                </div> -->
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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
    $(document).ready(function() {
       getCity(); 
      get_Area() 
    });

    function getCity() 
    {        
        var state_id = $("#state").val();               
        var city_id  = <?php echo $data['city_id']?>;    
       // alert(city_id);        
        $.ajax({
            url: "{{url('/admin')}}/getCity",
            type: 'post',
            data: { state: state_id ,city:city_id},
            success: function (data) 
            {
              $("#city").html(data);
            }
        });
    };

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

     function  getArea(){
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
</script>
@endsection