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
        <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section> -->
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
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
            <!-- /.box-header -->
            <!-- form start --> 
            <div class="box-body">
             @include('admin.layout._status_msg')
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['sub_plan_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="">
                  <div class="col-md-3">
                    <div>
                      <div class="form-group">
                        <label for="role_name">Subscription Name<span style="color:red;" >*</span></label>
                        <input type="text" autocomplete="off" class="form-control" id="sub_name" name="sub_name" placeholder="Subscription Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the subscription name." value="{{$data['sub_name']}}">
                        <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div> 
                 <div class="col-md-3">
                    <div>
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
                    <div>
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
                  <div class="col-md-3"> <div class="form-group">
                     <label for="nutritionsit_area">Icon Image<span style="color:red;" >*</span></label>   
                     
                    <div  class="input-group"> 
                      <input type="file" class="form-control"  id="icon_image" name="icon_image" >
                      <div class="input-group-addon">
                      <a data-fancybox="gallery" href="{{ url('/')}}/uploads/subscription_icon/{{$data['icon_image']}}"><i class="fa fa-eye"></i></a>
                    </div>
                    </div>
                  </div>
                  </div>


                   <input type="hidden" name="old_icon_image" value="{{$data['icon_image']}}">
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
                    <table class="table table-bordered" id="myTable">
                      <thead>
                        <tr>
                          <th width="20%">Duration</th>
                          <th width="20%">No of additional meal</th>
                          <th width="20%">Meal Type</th>
                          <th width="20%">Price</th>
                          <th width="20%">Discounted Price</th>
                          <th class="text-center"><a href="javascript:void(0);" class="btn btn-primary btn-sm addRow" onclick="addDurationRow()"><i class="fa fa-plus"></i></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody id="duration_body">
                          
                          @foreach($duration as $key => $durvalue)
                          
                          <tr class="tr_row_duration{{$key+1}}">
                            <td ><div class="input-group">
                                <input type="text" autocomplete="off" class="form-control" placeholder="Enter Duration Days" id="duration{{$key+1}}" name="duration{{$key+1}}" required="true" data-parsley-errors-container="#duration_msg{{$key+1}}" data-parsley-error-message="Enter Duration Days" value="{{$durvalue->duration}}" readonly>
                                 <div class="input-group-addon btn-default">
                                    Days
                                  </div>
                                <span id="duration_msg{{$key+1}}" style="color:red;"></span>
                              </div>
                            </td>
                             <td>
                                <input type="text" autocomplete="off" class="form-control" placeholder="No of additional meal" id="no_of_additional_meal{{$key+1}}" name="no_of_additional_meal{{$key+1}}" data-parsley-errors-container="#no_of_additional_meal_error{{$key+1}}" data-parsley-error-message="Enter no of meal" value="{{$durvalue->no_of_additional_meal}}">
                               
                                <span id="no_of_additional_meal_error{{$key+1}}" style="color:red;"></span>
                            </td>
                            <td>
                                @php $meal_checked="";$pack_checked=""   @endphp
                                @if(!empty($durvalue->price_per_meal))
                                @php $meal_checked = "checked"; @endphp
                                @endif
                                @if(!empty($durvalue->price_per_pack))
                                @php $pack_checked ="checked"; @endphp
                                @endif

                                 <input type="radio" id="price_type1" name="price_type{{$key+1}}" required="true" value="meal" data-parsley-errors-container="#meal_type{{$key+1}}" data-parsley-error-message="Select Meal Type" {{  $meal_checked }}> <b>Price Per Meal</b><br/>
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
                                  <input type="text" autocomplete="off" class="form-control pull-left" placeholder="Enter Price" id="price{{$key+1}}" name="price{{$key+1}}" required="true" data-parsley-errors-container="#meal_price{{$key+1}}" 
                                  value="{{number_format($price,2)}}" data-parsley-error-message="Please enter price.">
                                </div>
                                <span id="meal_price{{$key+1}}" style="color:red;"></span>
                            </td>
                            <td>
                               <div class="input-group">
                                  <div class="input-group-addon">
                                    <i class="fa fa-rupee"></i>
                                  </div>
                                  <input type="text" autocomplete="off" class="form-control" placeholder="Enter Discounted Price" id="discount_price{{$key+1}}" name="discount_price{{$key+1}}" required="true" data-parsley-errors-container="#dis_price{{$key+1}}" data-parsley-error-message="Please enter discounted price." value="{{number_format($durvalue->discount_price,2)}}" onchange="get_compair_price({{$key+1}})">
                                </div>
                                <span id="dis_price{{$key+1}}" style="color:red;"></span>
                            </td>
                             <td style="text-align: center;"  width="10%">
                               <!-- <a href="javascript:void(0);" class="btn btn-danger btn-sm remove"  onclick="removedurationRow_ajax(<?php echo $key+1;?>)"><i class="fa fa-trash"></i></a> -->
                               @if($durvalue->is_active==1)
                                 @php $checked="checked"; $style="success"; @endphp 
                               @else
                                 @php $checked=""; $style="danger";@endphp 
                               @endif
                               <input type="checkbox" {{$checked}} data-toggle="toggle" data-onstyle="success" title="status" onchange="change_Status_duration(<?php echo $key+1; ?>,<?php echo $durvalue->duration_id; ?>);" data-offstyle="danger" id="{{$key+1}}_is_active" data-size="small" data-style="slow" >
                               <input type="hidden" name="duration_id{{$key+1}}"  value="{{$durvalue->duration_id}}">
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
               <div class="row">
                <div class="col-xs-12">
                    <div class="form-group">
                       <label for="name">Short Description</label>
                       <textarea name="plan_description" id="plan_description">{{$data['plan_description']}}</textarea>
                    </div>
                </div>
              </div> 
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                  <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
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
  <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>
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
  
  getArea1(); 
  
  function getArea1() 
  {        
      var city_id = <?php echo $data['city'];?>;   
      var area_id = "<?php echo $data['area'];?>";
      $.ajax({
          url: "{{url('/admin')}}/getAreamultiarea",
          type: 'post',
          data: {city: city_id,area:area_id},
          success: function (data) 
          {
            $("#area").html(data);
          }
      });
  };

  
  function change_Status_duration(id,duration_id) 
  {  
     /*swal({
        title: "Duration Day Status",
        text: "Are You sure to change day status",
        icon: "warning",
        closeOnConfirm: false,
        dangerMode: true,
        }).then(function(isConfirm) {
        if (isConfirm) { 
        var status = $("#"+id+"_is_active").prop('checked');
        var durations_id = duration_id;
        //alert(status);
        $.ajax({
              url: "{{url('/admin')}}/status_duration_plan",
              type: 'post',
              data: {status:status,durations_id:duration_id},
              success: function (data) 
              {
                if(data=="success"){
                 swal("Success", "Duration status successfully changed !", "success");
                }else{
                  swal("Not Deactivate", "Sorry! You can not deactivate days, as duration under this plan is currently assigned and activated for some subscribers.", "error");
                }

              }
          });
        }                
      });*/ 

      swal({
          title: "Duration Day Status",
          text: "Are You sure to change day status",
          icon: "warning",
          buttons: [
            'Cancel',
            'Yes, change it!'
          ],
         
        }).then(function(isConfirm) {
          if (isConfirm) 
          { 
            var status = $("#"+id+"_is_active").prop('checked');
            var durations_id = duration_id;
            //alert(status);
            $.ajax({
                  url: "{{url('/admin')}}/status_duration_plan",
                  type: 'post',
                  data: {status:status,durations_id:duration_id},
                success: function (data) 
                {
                  if(data=="success"){
                  swal("Success", "Duration status successfully changed !", "success");
                  }else{
                  swal("Not Deactivate", "Sorry! You can not deactivate days, as duration under this plan is currently assigned and activated for some subscribers.", "error");
                  }

                }
             });
                
          } else {
               
            var className = $("#"+id+"_is_active").closest('div').prop('className');
           
            if(className == "toggle btn btn-sm slow btn-danger off"){
               $("#"+id+"_is_active").closest('div').removeClass(className);
               $("#"+id+"_is_active").closest('div').addClass('toggle btn btn-success btn-sm slow');
            }else{
              $("#"+id+"_is_active").closest('div').removeClass(className);
               $("#"+id+"_is_active").closest('div').addClass('toggle btn btn-sm slow btn-danger off');
            }
          }
        });

   }

</script>
@endsection