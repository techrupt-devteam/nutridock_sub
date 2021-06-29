@extends('admin.layout.master')
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   <style type="text/css">
    .select2-container--default .select2-selection--multiple {
    background-color: white !important;
    border-radius: 0px !important;
    border: 1px solid #d2d6de !important;
    cursor: text;
  }
</style>
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
                <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
            <!-- form start -->
            <div class="box-body">
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
             
              {!! csrf_field() !!}
              <div class="row">
                  <div class="col-md-3 col-lg-3">
                    <div class="">
                      <div class="form-group">
                        <label for="role_name">Subscription Name<span style="color:red;" >*</span></label>
                        <input type="text" autocomplete="off" class="form-control" id="sub_name" name="sub_name" placeholder="Subscription Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the subscription name.">
                        <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div> 
                 
                  <div class="col-md-3 col-lg-3">
                    <div class="">
                      <div class="form-group">
                        <label for="nutritionsit_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2 " name="city" id="city" required="true" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." onchange="get_area();">
                          <option value="">-Select City-</option>
                          @foreach($city as $cvalue)
                          <option value="{{$cvalue->id}}">{{$cvalue->city_name}}</option>
                          @endforeach
                        </select>
                         <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3">
                    <div class="">
                      <div class="form-group">
                        <label for="nutritionsit_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="area[]" id="area" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area." multiple="">
                          <option value="">-Select Area-</option>
                          <option value=""></option>
                        </select>
                        <div id="area_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 col-lg-3">
                  <div class="">
                    <label for="name">Icon Image <span style="color:red;" >*</span></label>
                    <div class="input-group">
                          <div class="input-group-addon btn-default">
                            <i class="fa fa-image"></i>
                          </div>
                            <input type="file" class="form-control"  id="icon_image" name="icon_image" required="true" data-parsley-errors-container="#img_msg" data-parsley-error-message="Please upload icon image">
                           
                      </div>
                       <span id="img_msg" style="color:red;"></span>
                  </div>
                </div>
              </div> 
          <!-- <div class="row">
            <div class="col-md-12">
              <div class="alert alert-warning col-md-12 mt-4 text-left" style="margin-top: 13px;color:#000000!important;background-color: #f39c1229 !important;">
                  <strong ><i class="glyphicon glyphicon-warning"></i> Note!</strong>
                  <strong> If No of meal (additonal meal) </strong> facility not availalble for a day then please enter <strong>0</strong> on that perticular filed.
              </div>
            </div>
          </div> -->
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped table-dark" id="myTable">
                      <thead>
                        <tr class="text-uppercase text-center">
                          <th >Duration</th>
                          <th >No of additional meal</th>
                          <th >Meal Type</th>
                          <th>Price</th>
                          <th>Discounted Price</th>
                          <th class="text-center"><a href="javascript:void(0);" class="btn btn-sm btn-primary btn-create addRow p-0 m-0" onclick="addDurationRow()"><i class="fa fa-plus"></i></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody id="duration_body">
                        <input type="hidden" id="duration_flag" name="duration_flag" value="1">
                          <tr class="tr_row_duration1">
                            <td><div class="input-group">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Enter Duration Days" id="duration1" name="duration1" required="true" data-parsley-errors-container="#duration_msg1" data-parsley-error-message="Enter Duration Days">
                                <div class="input-group-addon btn-default">
                                    Days
                                  </div></div>
                                <span id="duration_msg1" style="color:red;"></span>
                            </td>
                            <td>
                                <input type="text" autocomplete="off" class="form-control" placeholder="No of additional meal" id="no_of_additional_meal1" name="no_of_additional_meal1" data-parsley-errors-container="#no_of_additional_meal_error1" data-parsley-error-message="Enter no of meal">
                               
                                <span id="no_of_additional_meal_error1" style="color:red;"></span>
                            </td>
                            <td width="15%">
                                 <input type="radio" id="price_type1" name="price_type1" required="true" value="meal" data-parsley-errors-container="#meal_type1" data-parsley-error-message="Select Meal Type"> <b>Price Per Meal&nbsp;</b><br/>
                                 <input type="radio" id="price_type1" name="price_type1" required="true" value="pack" data-parsley-errors-container="#meal_type1" data-parsley-error-message="Select Meal Type"> <b>Price Per Pack</b>
                                 <span id="meal_type1" style="color:red;"></span>
                            </td>
                            </td>
                            <td>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-rupee"></i>
                                  </div>
                                  <input type="text" autocomplete="off" class="form-control" placeholder="Enter Price" id="price1" name="price1" required="true" data-parsley-errors-container="#meal_price1" data-parsley-error-message="Please enter price.">
                                </div>
                                <span id="meal_price1" style="color:red;"></span>
                            </td>
                            <td>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-rupee"></i>
                                  </div>
                                  <input type="text" autocomplete="off" class="form-control" placeholder="Enter Discounted Price" id="discount_price1" name="discount_price1" required="true" data-parsley-errors-container="#dis_price1" data-parsley-error-message="Please enter discounted price." onchange="get_compair_price(1)">
                                </div>
                                <span id="dis_price1" style="color:red;"></span>
                            </td>
                             <td style="text-align: center;"  width="10%">
                               <a href="javascript:void(0);" class="btn-sm btn btn-danger remove p-0 m-0"   onclick="removedurationRow_ajax(1)"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                  </div>                  
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                       <label for="name">Short Description</label>
                       <textarea name="plan_description" id="plan_description"></textarea>
                    </div>
                </div>
              </div> 
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
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" />
  <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  
  <script type="text/javascript"> 
  //load area drop down script 
  CKEDITOR.replace('plan_description');

  function get_compair_price(i){
    var $price_value    = parseInt($('#price'+i).val());
    var $discount_value = parseInt($('#discount_price'+i).val());
    if($discount_value > $price_value)
    {
       $('#discount_price'+i).val(0.00);
       $('#discount_price'+i).focus();
       swal("Not Valid Discount Amount", "Discount amount should be less on meal price amount!", "warning")
       return false;
    }
  } 
  

  function get_area()
  {
   
      var city_id = $("#city").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getArea",
        data: {
          city: city_id
        }
      }).done(function(data) {
           $("#area").html(data);
      });
  }

  function addDurationRow()
  {
      var duration_flag = $('#duration_flag').val();
      duration_flag = parseInt(duration_flag)+parseInt(1); 
      $('#duration_flag').val(duration_flag);
       var tr = '<tr class="tr_row_duration' + duration_flag + '"><td><div class="input-group"><input type="text" autocomplete="off" class="form-control" placeholder="Enter Duration Days" id="duration' + duration_flag + '" name="duration' + duration_flag + '" required="true" data-parsley-errors-container="#duration_msg'+duration_flag +'" data-parsley-error-message="Enter Duration Days">  <div class="input-group-addon btn-default"> Days</div></div><span id="duration_msg'+duration_flag +'" style="color:red;"></span></td><td><input type="text" autocomplete="off" class="form-control" placeholder="No of additional meal" id="no_of_additional_meal'+duration_flag+'" name="no_of_additional_meal'+duration_flag+'"data-parsley-errors-container="#no_of_additional_meal_error'+duration_flag+'" data-parsley-error-message="Enter no of meal"><span id="no_of_additional_meal_error'+duration_flag+'" style="color:red;"></span></td><td><input type="radio" id="price_type' +  duration_flag + '" name="price_type' + duration_flag + '" required="true" value="meal" data-parsley-errors-container="#meal_type' + duration_flag + '" data-parsley-error-message="Select Meal Type"> <b>Price Per Meal&nbsp;</b><br/><input type="radio" id="price_type' + duration_flag + '" name="price_type' + duration_flag + '" required="true" value="pack" data-parsley-errors-container="#meal_type' + duration_flag + '"data-parsley-error-message="Select Meal Type"> <b>Price Per Pack</b><span id="meal_type' + duration_flag + '" style="color:red;"></span></td><td><div class="input-group"><div class="input-group-addon"><i class="fa fa-rupee"></i></div><input type="text" autocomplete="off" class="form-control" placeholder="Enter Price" id="price' + duration_flag + '" name="price' + duration_flag + '" required="true" data-parsley-errors-container="#meal_price' + duration_flag + '" data-parsley-error-message="Please enter price."></div><span id="meal_price'+ duration_flag + '" style="color:red;"></span></td><td><div class="input-group"><div class="input-group-addon"><i class="fa fa-rupee"></i></div><input type="text" autocomplete="off" class="form-control" placeholder="Enter Discounted Price" id="discount_price'+duration_flag+ '" name="discount_price'+duration_flag+'" required="true" data-parsley-errors-container="#dis_price' + duration_flag + '" data-parsley-error-message="Please enter discount price." onchange="get_compair_price('+duration_flag+');"></div><span id="dis_price'+ duration_flag + '" style="color:red;"></span></td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removedurationRow_ajax(' + duration_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
        $('#duration_body').append(tr);
     
  }


  function removedurationRow_ajax(div_id)
  {
      var duration_flag = $('#duration_flag').val();
      if(duration_flag!=1)
      {
        $('.tr_row_duration'+div_id).remove();
      }
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

   $("#icon_image").change(function() {
   readURL(this);
  });


</script>
@endsection