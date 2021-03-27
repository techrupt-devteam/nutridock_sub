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
              <h3 class="box-title"> {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}</h3>
                <ol class="breadcrumb">
                  <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
                  <li class="active">{{ $page_name." ".$title }}</li>
                </ol>   
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- form start --> 
             @include('admin.layout._status_msg')
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-3">
                    <div>
                      <div class="form-group">
                        <label for="nutritionsit_name">Name<span style="color:red;" >*</span></label>
                        <input type="text" autocomplete="off" class="form-control"  data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter nutritionsit name." id="nutritionsit_name" name="nutritionsit_name" placeholder="Nutritionsit Name"  value="{{$data['name']}}"required="true">
                            <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div>
                      <div class="form-group">
                        <label for="nutritionsit_email">Email<span style="color:red;" >*</span></label>
                        <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-envelope"></i>
                            </div>
                        <input type="text" autocomplete="off" class="form-control" data-parsley-type="email" id="nutritionsit_email" name="nutritionsit_email" placeholder="Nutritionsit Email" required="true" value="{{$data['email']}}" data-parsley-errors-container="#email_error" data-parsley-error-message="Please enter email.">
                      </div>
                        <div id="email_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div>
                      <div class="form-group">
                        <label for="nutritionsit_name">Mobile No<span style="color:red;" >*</span></label>
                         <div class="input-group">
                            <div class="input-group-addon">
                              <i class="fa fa-phone"></i>
                            </div>
                             <input type="text" autocomplete="off"  class="form-control" data-parsley-type="integer"  maxlength="10" id="nutritionsit_mobile" name="nutritionsit_mobile" placeholder="Nutritionsit Mobile" required="true"  value="{{$data['mobile']}}" data-parsley-errors-container="#mobile_error" data-parsley-error-message="Please enter mobile no.">
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
                             <a data-fancybox="gallery" href="{{ url('/')}}/uploads/user_pic/{{$data['profile_image']}}"><i class="fa fa-eye"></i></a>
                          </div>
                            <input type="file" class="form-control"  id="profile_image" name="profile_image">
                      
                       <input type="hidden" name="old_profile_image" value="{{$data['profile_image']}}">     
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
                        <label for="nutritionsit_name" class="label-control">State<span style="color:red;" >*</span></label>

                         <select class="form-control select2" name="nutritionsit_state" id="nutritionsit_state" required="true" onchange="getCity()" data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state.">
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
                         <div id="state_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div><div class="col-md-4">
                    <div>
                      <div class="form-group">
                        <label for="nutritionsit_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="nutritionsit_city" id="nutritionsit_city" required="true" onchange="getArea()" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city.">
                          <option value="">-Select City-</option>t
                          <option value=""></option>t
                        </select>
                          <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div>
                      <div class="form-group">
                        <label for="nutritionsit_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="nutritionsit_area" id="nutritionsit_area" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area.">
                          <option value="">-Select Area-</option>t
                          <option value=""></option>t
                        </select>
                        <div id="area_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>
                 <input type="hidden" name="nutritionsit_role" value="1">
                <div class="row">
                   <div class="col-md-12">
                      <div class="alert alert-info">
                        Do You want to change nutrionsit password please check checkbox on update password
                      </div>
                        <div class="">
                          <div class="form-group" style="max-width: 320px;">
                              <label><input type="checkbox" id="chkPassword" name="chkPassword">
                                <label for="nutritionsit_update">&nbsp;  Update Passsword</label></label>
                              <input type="text" autocomplete="off" class="form-control"  id="nutritionsit_password_new" name="nutritionsit_password_new" placeholder="New Password" style="display: none !important;">
                              <input type="hidden" class="form-control"  id="password" name="password" value="{{$data['password']}}">        
                          </div>
                        </div>
                   </div>  
                </div>
              <!-- /.box-footer-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary"> Update </button>
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default"> Back </a>
                
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" />
  <script type="text/javascript">
    $(document).ready(function() {
       get_City(); 
       get_Area();   
    });

    function get_City() 
    {        
        var state_id = $('#nutritionsit_state').val()                   
        var city_id  = <?php echo  $data['city'];?>;            
        $.ajax({
            url: "{{url('/admin')}}/getCity",
            type: 'post',
            data: { state: state_id ,city:city_id},
            success: function (data) 
            {
              $("#nutritionsit_city").html(data);
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
              $("#nutritionsit_area").html(data);
            }
        });
    };

  //load city drop down script 
  //$("#nutritionsit_state").change(function() {
    function getCity(){
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
   // });
 
  //load area drop down script 
 // $("#nutritionsit_city").change(function() {
     function getArea(){
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
    //});

   //checkbox show hide
   $(function () {
        $("#chkPassword").click(function () {
            if ($(this).is(":checked")) {
                $("#nutritionsit_password_new").show();
                $("#nutritionsit_password_new").attr("required","true");
            } else {
                $("#nutritionsit_password_new").hide();
                $("#nutritionsit_password_new").removeAttr("required");
                $(".parsley-required").hide();
            }
        });
    });

</script>
@endsection
