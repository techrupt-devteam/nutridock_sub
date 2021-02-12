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
                  <div class="col-md-4">
                    <div class="">
                      <div class="form-group">
                        <label for="role_name">Subscription Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="sub_name" name="sub_name" placeholder="Subscription Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the subscription name.">
                        <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div> 
                 
                  <div class="col-md-4">
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
                  <div class="col-md-4">
                    <div class="">
                      <div class="form-group">
                        <label for="nutritionsit_area">Area<span style="color:red;" >*</span></label>
                         <select class="form-control select2" name="area" id="area" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area.">
                          <option value="">-Select Area-</option>
                          <option value=""></option>
                        </select>
                        <div id="area_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
              </div> 

              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped table-dark" id="myTable">
                      <thead>
                        <tr class="text-uppercase text-center">
                          <th width="30%" >Duration</th>
                          <th>Meal Type</th>
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
                                <input type="text" class="form-control" placeholder="Enter Duration Days" id="duration1" name="duration1" required="true" data-parsley-errors-container="#duration_msg1" data-parsley-error-message="Enter Duration Days">
                                <div class="input-group-addon btn-default">
                                    Days
                                  </div></div>
                                <span id="duration_msg1" style="color:red;"></span>
                            </td>
                            <td>
                                 <input type="radio" id="price_type1" name="price_type1" required="true" value="meal" data-parsley-errors-container="#meal_type1" data-parsley-error-message="Select Meal Type"> <b>Price Per Meal&nbsp;</b>
                                 <input type="radio" id="price_type1" name="price_type1" required="true" value="pack" data-parsley-errors-container="#meal_type1" data-parsley-error-message="Select Meal Type"> <b>Price Per Pack</b>
                                 <span id="meal_type1" style="color:red;"></span>
                            </td>
                            </td>
                            <td>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-rupee"></i>
                                  </div>
                                  <input type="text" class="form-control" placeholder="Enter Price" id="price1" name="price1" required="true" data-parsley-errors-container="#meal_price1" data-parsley-error-message="Please enter price.">
                                </div>
                                <span id="meal_price1" style="color:red;"></span>
                            </td>
                            <td>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-rupee"></i>
                                  </div>
                                  <input type="text" class="form-control" placeholder="Enter Discounted Price" id="discount_price1" name="discount_price1" required="true" data-parsley-errors-container="#dis_price1" data-parsley-error-message="Please enter discounted price.">
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
  <script type="text/javascript"> 
  //load area drop down script 
   CKEDITOR.replace('plan_description');

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
       var tr = '<tr class="tr_row_duration' + duration_flag + '"><td><div class="input-group"><input type="text" class="form-control" placeholder="Enter Duration Days" id="duration' + duration_flag + '" name="duration' + duration_flag + '" required="true" data-parsley-errors-container="#duration_msg'+duration_flag +'" data-parsley-error-message="Enter Duration Days">  <div class="input-group-addon btn-default"> Days</div></div><span id="duration_msg'+duration_flag +'" style="color:red;"></span></td><td><input type="radio" id="price_type' + duration_flag + '" name="price_type' + duration_flag + '" required="true" value="meal" data-parsley-errors-container="#meal_type' + duration_flag + '" data-parsley-error-message="Select Meal Type"> <b>Price Per Meal&nbsp;</b><input type="radio" id="price_type' + duration_flag + '" name="price_type' + duration_flag + '" required="true" value="pack" data-parsley-errors-container="#meal_type' + duration_flag + '"data-parsley-error-message="Select Meal Type"> <b>Price Per Pack</b><span id="meal_type' + duration_flag + '" style="color:red;"></span></td><td><div class="input-group"><div class="input-group-addon"><i class="fa fa-rupee"></i></div><input type="text" class="form-control" placeholder="Enter Price" id="price' + duration_flag + '" name="price' + duration_flag + '" required="true" data-parsley-errors-container="#meal_price' + duration_flag + '" data-parsley-error-message="Please enter price."></div><span id="meal_price'+ duration_flag + '" style="color:red;"></span></td><td><div class="input-group"><div class="input-group-addon"><i class="fa fa-rupee"></i></div><input type="text" class="form-control" placeholder="Enter Discounted Price" id="discount_price'+duration_flag+ '" name="discount_price'+duration_flag+'" required="true" data-parsley-errors-container="#dis_price' + duration_flag + '" data-parsley-error-message="Please enter discount price."></div><span id="dis_price'+ duration_flag + '" style="color:red;"></span></td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removedurationRow_ajax(' + duration_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
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




</script>
@endsection