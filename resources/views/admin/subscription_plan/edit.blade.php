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
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['sub_plan_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Subscription Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="sub_name" name="sub_name" placeholder="Subscription Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the subscription name." value="{{$data['sub_name']}}">
                        <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div> 
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Meal Plan<span style="color:red;" >*</span></label>
                        <select class="form-control select2" name="plan_id" id="plan_id" required="true" data-parsley-errors-container="#plan_error" data-parsley-error-message="Please select meal plan.">
                          <option value=" ">-Select Plan-</option>
                          @foreach($plan as $pvalue)
                          @php $selected =""; @endphp
                          @if($data['plan_id'] == $pvalue->plan_id)
                          @php $selected = "selected"; @endphp  
                          @endif
                          <option value="{{$pvalue->plan_id}}" {{$selected}}>{{$pvalue->plan_name}}</option>
                          @endforeach
                        </select>
                        <div id="plan_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div> 
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="nutritionsit_name">City<span style="color:red;" >*</span></label>
                         <select class="form-control select2 " name="city" id="city" required="true" data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." onchange="get_area();">
                          <option value="">-Select City-</option>
                          @foreach($city as $cvalue)
                          @php $selected =""; @endphp
                          @if($data['city'] == $cvalue->id)
                          @php $selected = "selected"; @endphp  
                          @endif
                          <option value="{{$cvalue->id}}" {{$selected}}>{{$cvalue->city_name}}</option>
                          @endforeach
                        </select>
                         <div id="city_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="box-body">
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
              </div> 

              <div class="row">
                <div class="col-md-12">
                  <div class="box-body">
                    <table class="table table-bordered" id="myTable">
                      <thead style="background-color: #00cc445c;">
                        <tr>
                          <th width="30%">Duration</th>
                          <th>Meal Type</th>
                          <th>Price</th>
                          <th class="text-center"><a href="javascript:void(0);" class="btn btn-info addRow" onclick="addDurationRow()"><i class="fa fa-plus"></i></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody id="duration_body">
                          
                          @foreach($duration as $key => $durvalue)
                          
                          <tr class="tr_row_duration{{$key+1}}">
                            <td><div class="input-group">
                                <input type="text" class="form-control" placeholder="Enter Duration Days" id="duration{{$key+1}}" name="duration{{$key+1}}" required="true" data-parsley-errors-container="#duration_msg{{$key+1}}" data-parsley-error-message="Enter Duration Days" value="{{$durvalue->duration}}">
                                 <div class="input-group-addon btn-default">
                                    Days
                                  </div>
                                <span id="duration_msg{{$key+1}}" style="color:red;"></span>
                              </div>
                            </td>
                            <td>
                                @php $meal_checked="";$pack_checked=""   @endphp
                                @if(!empty($durvalue->price_per_meal))
                                @php $meal_checked = "checked"; @endphp
                                @endif
                                @if(!empty($durvalue->price_per_pack))
                                @php $pack_checked ="checked"; @endphp
                                @endif

                                 <input type="radio" id="price_type1" name="price_type{{$key+1}}" required="true" value="meal" data-parsley-errors-container="#meal_type{{$key+1}}" data-parsley-error-message="Select Meal Type" {{  $meal_checked }}> <b>Price Per Meal</b>
                                 <input type="radio" id="price_type1" name="price_type{{$key+1}}" required="true" value="pack" data-parsley-errors-container="#meal_type{{$key+1}}" data-parsley-error-message="Select Meal Type" {{  $pack_checked }}> <b>Price Per Pack</b>
                                 <span id="meal_type{{$key+1}}" style="color:red;"></span>
                            </td>
                            </td>
                            <td>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-rupee"></i>
                                  </div>
                                  @php $price=""; @endphp
                                  @if(!empty($durvalue->price_per_meal))
                                  @php $price = $durvalue->price_per_meal; @endphp
                                  @endif
                                  @if(!empty($durvalue->price_per_pack))
                                  @php $price = $durvalue->price_per_pack; @endphp
                                  @endif
                                  <input type="text" class="form-control pull-left" placeholder="Enter Price" id="price{{$key+1}}" name="price{{$key+1}}" required="true" data-parsley-errors-container="#meal_price{{$key+1}}" value="
                                  {{$price}}" data-parsley-error-message="Please enter price.">
                                </div>
                                <span id="meal_price{{$key+1}}" style="color:red;"></span>
                            </td>
                             <td style="text-align: center;"  width="10%">
                               <a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removedurationRow_ajax(<?php echo $key+1;?>)"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>

                          @endforeach

                          <input type="hidden" id="duration_flag" name="duration_flag" value="{{$key+1}}">

                      </tbody>
                    </table>
                  </div>                  
                </div>
              </div>
              <!-- /.box-body -->
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
  //load area drop down script 



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
       var tr = '<tr class="tr_row_duration' + duration_flag + '"><td><div class="input-group"><input type="text" class="form-control" placeholder="Enter Duration Days" id="duration' + duration_flag + '" name="duration' + duration_flag + '" required="true" data-parsley-errors-container="#duration_msg'+duration_flag +'" data-parsley-error-message="Enter Duration Days"> <span id="duration_msg'+duration_flag +'" style="color:red;"></span> <div class="input-group-addon btn-default"> Days</div></td><td><input type="radio" id="price_type' + duration_flag + '" name="price_type' + duration_flag + '" required="true" value="meal" data-parsley-errors-container="#meal_type' + duration_flag + '" data-parsley-error-message="Select Meal Type"> <b>Price Per Meal</b><input type="radio" id="price_type' + duration_flag + '" name="price_type' + duration_flag + '" required="true" value="pack" data-parsley-errors-container="#meal_type' + duration_flag + '"data-parsley-error-message="Select Meal Type"> <b>Price Per Pack</b><span id="meal_type' + duration_flag + '" style="color:red;"></span></td><td><div class="input-group"><div class="input-group-addon"><i class="fa fa-rupee"></i></div><input type="text" class="form-control" placeholder="Enter Price" id="price' + duration_flag + '" name="price' + duration_flag + '" required="true" data-parsley-errors-container="#meal_price' + duration_flag + '" data-parsley-error-message="Please enter price."></div><span id="meal_price' + duration_flag + '" style="color:red;"></span></td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removedurationRow_ajax(' + duration_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
        $('#duration_body').append(tr);
        $("#webinar_date"+duration_flag).datepicker({ format: "yyyy-mm-dd",autoclose: true}).val();
  }
  function removedurationRow_ajax(div_id)
  {
      var duration_flag = $('#duration_flag').val();
      if(duration_flag!=1)
      {
        $('.tr_row_duration'+div_id).remove();
      }
  }
  
  getArea(); 
  
  function getArea() 
  {        
      var city_id = <?php echo  $data['city'];?>;   
      var area_id = <?php echo  $data['area'];?>;
      $.ajax({
          url: "{{url('/admin')}}/getArea",
          type: 'post',
          data: {city: city_id,area:area_id},
          success: function (data) 
          {
            $("#area").html(data);
          }
      });
  };


</script>
@endsection