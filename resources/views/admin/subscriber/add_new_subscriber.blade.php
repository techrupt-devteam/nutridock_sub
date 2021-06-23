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
          <div class="box box-body box-primary">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">  
                  <div class="col-md-12">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="nutritionsit_name">Name<span style="color:red;" >*</span></label>
                          <input type="text" autocomplete="off" class="form-control" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter full name." id="full_name" name="full_name" placeholder="Full Name" required="true">
                          <div id="name_error" style="color:red;"></div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                          <label for="email_name">Email<span style="color:red;" >*</span></label>
                          <input type="text" autocomplete="off" class="form-control" data-parsley-errors-container="#email_error" data-parsley-error-message="Please enter email." id="email" name="email" placeholder="Email" required="true">
                          <div id="email_error" style="color:red;"></div>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                          <label for="mobile_no">Mobile<span style="color:red;" >*</span></label>
                          <input type="text" autocomplete="off" class="form-control" data-parsley-errors-container="#mobile_error" data-parsley-error-message="Please enter mobile." id="mobile_no" name="mobile_no" placeholder="Mobile Number" required="true">
                          <div id="mobile_error" style="color:red;"></div>
                        </div>
                     </div>
                  </div>
              </div>
              <div class="row">  
                  <div class="col-md-12">
                      <div class="col-md-6 col-md-4">
                        <div class="form-group">
                          <label class="control-label">Age <span style="color:red;">*</span></label>
                            <input name="age" 
                            type="text" 
                            data-parsley-pattern="^[0-9]*$" 
                            autocomplete="nope"
                            class="form-control" 
                            placeholder="Age" 
                            required="required"  
                            data-parsley-errors-container="#age-errors" 
                            data-parsley-error-message="Age required" 
                            data-parsley-type="number"
                            maxlength="3" 
                            data-parsley-group="step-2">
                            <div id="age-errors"></div>
                          </div>
                        </div>
                     <div class="col-md-4 col-md-6">
                        <div class="form-group">
                           <label class="control-label">Gender <span style="color:red;">*</span></label>
                          <select class="form-control" name="gender" id="gender" required="required" style="min-height:45px"  data-parsley-errors-container="#gender-errors" data-parsley-error-message="Gender required" data-parsley-group="step-2">
                            <option value="">Select</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">Other</option>
                          </select>
                          <div id="gender-errors"></div>
                        </div>
                     </div>
                     <div class="col-md-4 col-md-6">
                        <div class="form-group">
                          <label class="control-label">Weight <span style="color:red;">*</span></label>
                          <input name="weight" type="text" class="form-control" placeholder="Kgs" 
                          autocomplete="nope"
                          required="required"  
                          data-parsley-errors-container="#weight-errors" 
                          data-parsley-error-message="Weight required" 
                          data-parsley-group="step-2">  
                          <div id="weight-errors"></div>     
                        </div>
                     </div>
                  </div>
              </div>   
              <div class="row">  
                  <div class="col-md-12">
                      <div class="col-md-6 col-md-4">
                        <div class="form-group">
                        <label class="control-label">Height <span style="color:red;">*</span></label>
                        <div  class="form-group label-floating">
                          <div class="row">
                            <div class="col-md-6 pr-1">
                              <input type="text" name="height_in_feet" class="form-control" placeholder="Feet" required="required" 
                              autocomplete="nope"
                              data-parsley-errors-container="#height-in-feet-errors" data-parsley-error-message="Feet required" 
                              data-parsley-group="step-2">
                              <div id="height-in-feet-errors" ></div>   
                            </div>
                            <div class="col-md-6 pl-1">
                              <input type="text" name="height_in_inches" class="form-control" placeholder="Inch" required="required" 
                              autocomplete="nope"
                              data-parsley-errors-container="#height-in-inches-errors"  data-parsley-error-message="Inch required" data-parsley-group="step-2">
                              <div id="height-in-inches-errors"></div> 
                            </div>
                          </div>
                        </div>
                        </div>
                        </div>
                     <div class="col-md-4 col-md-6">
                        <div class="form-group">
                           <label class="control-label">Physical Activity <span style="color:red;">*</span></label>
                        <select class="form-control select2" name="physical_activity_id" id="physical_activity_id" required="required" 
                        autocomplete="nope"
                        data-parsley-errors-container="#physical-activity-errors"  data-parsley-error-message="Physical activity required" 
                        data-parsley-group="step-2" style="min-height: 45px;">
                          <option selected="selected" value=" " >Select an option</option>
                           @foreach($getPhysicalActivityData as $getPhysicalActivity)
                          <option value="{{ $getPhysicalActivity['physical_activity_id'] }}">
                            {{ $getPhysicalActivity['physical_activity'] }} 
                          </option>
                           @endforeach   
                        </select>
                        <div id="physical-activity-errors"></div> 
                        </div>
                     </div>
                     <div class="col-md-4 col-md-6">
                        <div class="form-group">
                         <label class="control-label">Avoid / Dislike Food <span style="color:red;">*</span></label>
                        <select id="avoid_food_id" class="form-control select2" multiple name="avoid_or_dislike_food_id[]" data-parsley-checkmin="1" required data-parsley-errors-container="#avoid-or-dislike-errors"  data-parsley-error-message="Avoid / Dislike Food required" data-parsley-group="step-2">
                          <option value="None">None</option>
                          @foreach($getFoodAvoidData as $getFoodAvoidData)
                          <option value="{{ $getFoodAvoidData['food_avoid_id'] }}"> 
                            {{ $getFoodAvoidData['food_avoid_name'] }} </option>
                          @endforeach  
                          <option value="Other">Other</option>
                        </select>
                        <div id="avoid-or-dislike-errors"></div>   
                        </div>
                     </div>
                  </div>
              </div>
              <div class="row">  
                  <div class="col-md-12">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="nutritionsit_name">Other Food</label>
                           <input name="other_food" type="text" class="form-control" placeholder="Other" autocomplete="nope"> 
                        </div>
                     </div>
                  </div>
              </div>         

              <div class="row">
                <div class="col-md-12">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="control-label">Any lifestyle disease? (Diabetes,Cholesterol,etc)</label>
                      <textarea class="form-control" rows="1" name="lifestyle_disease" id="lifestyle_disease" placeholder="Any lifestyle disease"></textarea>
                    </div>
                  </div>
                  <div class="col-lg-6">
                    <div class="form-group" >
                      <label class="control-label">Any food preparation instructions?</label>
                      <textarea class="form-control" rows="1" name="food_precautions" id="food_precautions" placeholder="Any Food Precautions"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                 <div class="col-md-4 col-md-6">
                    <div class="form-group">
                     <label class="control-label">Subscription Plan<span style="color:red;">*</span></label>
                      <select id="sub_plan_id" class="form-control"  name="sub_plan_id" data-parsley-checkmin="1" required data-parsley-errors-container="#subscription-plan-errors"  data-parsley-error-message="Select Subscription Plan" data-parsley-group="step-2" onchange="get_duration();">
                        <option value="">-Select Subscription Plan-</option>
                        @foreach($subscription_plan as $subscription_value)
                         <option value="{{$subscription_value->sub_plan_id}}">{{$subscription_value->sub_name}}</option>
                        @endforeach
                      </select>
                     <div id="subscription-plan-errors"></div>   
                    </div>
                 </div>
                 <div class="col-md-4 col-md-6">
                    <div class="form-group">
                     <label class="control-label">No of days<span style="color:red;">*</span></label>
                    <select id="no_of_days" class="form-control" name="no_of_days"  required data-parsley-errors-container="#no-of-days-errors"  data-parsley-error-message="Select No Of Days" data-parsley-group="step-2" onchange="getPlanPrice();">
                      <option value="">-Select Days-</option>
                    </select>
                    <div id="no-of-days-errors"></div>   
                    </div>
                 </div>
                 <div class="col-md-4 col-md-6">
                    <div class="form-group">
                     <label class="control-label">Meal Plan<span style="color:red;">*</span></label>
                    <select id="meal_type_id" class="form-control select2" multiple name="meal_type_id[]" required data-parsley-errors-container="#meal-plan-errors"  data-parsley-error-message="Select Meal Plan" onchange="getPlanPrice();">
                      <option value="">-Select -</option>
                        @foreach($meal_plan as $meal_type_value)
                         <option value="{{$meal_type_value->meal_type_id}}">{{$meal_type_value->meal_type_name}}</option>
                        @endforeach
                    </select>
                    <div id="meal-plan-errors"></div>   
                    </div>
                 </div>
               </div>
              </div>
               <div class="row">
                <div class="col-md-12">
                 <div class="col-md-4 col-md-6">
                    <div class="form-group">
                     <label class="control-label">Start Date<span style="color:red;">*</span></label>
                     <input type="text" class="form-control" name="start_date" id="start_date" required data-parsley-errors-container="#start_date-errors"  data-parsley-error-message="Select start date">
                    </div>

                    <div id="start_date-errors"></div>   
                    
                 </div>
                 <div class="col-md-8 col-md-6">
                    <div class="form-group">
                     <label class="control-label">Price <small style="color:red;">(5% GST applicable)</small></label>
                      <div style="border:1px dashed #4f4f4f;background-color: #e1e1e1;" class="p-2">
                          <div class="price">
                        </div>
                     </div>
                 </div>
                </div>
              </div>
              </div>  
              <div class="row">
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="state_id">State<span style="color:red;" >*</span></label>
                  <select class="form-control select2" name="state_id" id="state_id" required="true" data-parsley-errors-container="#state_error" data-parsley-error-message="Please select state." onchange="getCity();">
                    <option value="">-Select State-</option>
                    
                          @foreach($state as $svalue)
                          
                    <option value="{{$svalue->id}}">{{$svalue->name}}</option>
                    
                          @endforeach
                        
                  </select>
                  <div id="state_error" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="operation_manager_name">City<span style="color:red;" >*</span></label>
                  <select class="form-control select2"  name="city_id" id="city_id"  data-parsley-errors-container="#city_error" data-parsley-error-message="Please select city." required="true" onchange="getArea();">
                    <option value="">-Select City-</option>
                    <option value=""></option>
                  </select>
                  <div id="city_error" style="color:red;"></div>
                </div>
              </div>
            </div>
            <div class="col-md-4">
              <div class="box-body">
                <div class="form-group">
                  <label for="area_id">Area<span style="color:red;" >*</span></label>
                  <select class="form-control select2"  name="area_id" id="area_id" required="true" data-parsley-errors-container="#area_error" data-parsley-error-message="Please select area." onchange="get_kitchen();">
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
                <div class="box-body">
                  <div class="form-group">
                    <label for="skitchen_id">Assign Kitchen <span style="color:red;" >*</span></label>
                    <select class="form-control select2"  name="skitchen_id" id="skitchen_id" required="true" data-parsley-errors-container="#area1_error" data-parsley-error-message="Please select area.">
                      <option value="">-Select Kitchen-</option>
                      <option value=""></option>
                    </select>
                    <div id="area1_error" style="color:red;"></div>
                  </div>
                </div>
              </div>
              <div class="col-md-4" style="display:none !important;">
                <div class="box-body">
                  <div class="form-group">
                    <label for="operation_manager_name">Pincode<span style="color:red;" >*</span></label>
                    <div class="input-group">
                      <div class="input-group-addon"> <i class="fa fa-map-marker"></i> </div>
                      <input type="text"  class="form-control"  id="pincode" name="pincode" placeholder="Pincode">
                    </div>
                    <div id="pincode_error" style="color:red;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="skitchen_id">Address<span style="color:red;" >*</span></label>
                         <textarea class="form-control" placeholder="Address" name="address1" id="address1" rows="2" required="required" data-parsley-group="step-4" data-parsley-errors-container="#address_error" data-parsley-error-message="Please enter address."></textarea>
                        <div id="address_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="skitchen_id">Pincode<span style="color:red;" >*</span></label>
                        <input type="text" placeholder="Pincode" name="pincode1" id="pincode1" class="form-control" required="required" minlength="6" maxlength="6" data-parsley-group="step-4" data-parsley-errors-container="#pincode_error1" data-parsley-error-message="Please enter address.">
                        <div id="pincode_error1" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-md-6">  
                    <div class="box-body">
                    <div class="form-group">
                     <label class="control-label">Meal Plan<span style="color:red;">*</span></label>
                    <select id="address1_meal" class="form-control select2" multiple name="address1_meal[]" required data-parsley-errors-container="#meal-plan1-errors"  data-parsley-error-message="Select Meal Plan">
                      <option value="">-Select -</option>
                        @foreach($meal_plan as $meal_type_value)
                         <option value="{{$meal_type_value->meal_type_id}}">{{$meal_type_value->meal_type_name}}</option>
                        @endforeach
                    </select>
                    <div id="meal-plan1-errors"></div>   
                    </div>
                  </div>
                 </div>
               </div>
              <div class="row">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="skitchen_id">Office Address <span style="color:red;" >*</span></label>
                        <textarea class="form-control" placeholder="Address" name="address2" id="address2" rows="2" required="required" data-parsley-group="step-4" data-parsley-errors-container="#address_error2" data-parsley-error-message="Please enter address."></textarea>
                        <div id="address_error2" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="skitchen_id">Pincode<span style="color:red;" >*</span></label>
                        <input type="text" placeholder="Pincode" name="pincode2" id="pincode2" class="form-control" required="required" minlength="6" maxlength="6" data-parsley-group="step-4" data-parsley-errors-container="#pincode_error1" data-parsley-error-message="Please enter address.">
                        <div id="pincode_error1" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 col-md-6">  <div class="box-body">
                    <div class="form-group">
                     <label class="control-label">Meal Plan<span style="color:red;">*</span></label>
                    <select id="address2_meal" class="form-control select2" multiple name="address2_meal[]" required data-parsley-errors-container="#meal-plan2-errors"  data-parsley-error-message="Select Meal Plan">
                      <option value="">-Select -</option>
                        @foreach($meal_plan as $meal_type_value)
                         <option value="{{$meal_type_value->meal_type_id}}">{{$meal_type_value->meal_type_name}}</option>
                        @endforeach
                    </select>
                    <div id="meal-plan2-errors"></div>   
                    </div>
                  </div>
                 </div>
              </div> 
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
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

<script type="text/javascript" src="{{url('')}}/public/front/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">

  $('#start_date').datepicker({ 
  format:'yyyy-mm-dd', 
  startDate: new Date(),
});

  //load city drop down script  
    function  getCity(){
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
  //load city drop down area   
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

    //Kitchen
    function  get_kitchen()
    {
      var area_id = $("#area_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/getKitchen",
        data: {
          area: area_id
        }
      }).done(function(data) {
           $("#skitchen_id").html(data);
      });
    }

    //load city drop down area   
    function  get_duration(){
        var sub_plan_id = $("#sub_plan_id").val();
        $.ajax({
          type: "POST",
          url: "{{url('/admin')}}/getDuration",
          data: {
            plan_id: sub_plan_id
          }
        }).done(function(data) {
             $("#no_of_days").html(data);
        });
    }

function getPlanPrice()
{   
  //alert('test');
  var subscription_plan_id = $('#sub_plan_id').val();
  var duration_id          = $('#no_of_days').val(); 
  var selectedMealType     = $('#meal_type_id').val(); 
 
  //if((subscription_plan_id != '') && (duration_id != 'undefined') && (selectedMealType != '')) 
  //{
    $.ajax({
        type: "POST",
        url:  "{{url('/admin')}}/getplan_price",
        data: {
          subscription_plan_id  : subscription_plan_id,
          duration_id   : duration_id,
          selectedMealType : selectedMealType
        },
        success: function (data) {
          if(data) {            
            $(".price").html('<input type="hidden" id="mrp" name="mrp" value="'+data['totalPrice']+'" /><input type="hidden" id="price_per_meal" name="price_per_meal" value="'+data['price_per_meal']+'" /><input type="hidden" id="salePrice" name="salePrice" value="'+data['salePrice']+'" /><input type="hidden" id="discount_price" name="discount_price" value="'+data['discount_price']+'" /><span class="mrp">Rs. '+data['totalPrice']+' for '+data['duration']+' days | Rs. '+data['price_per_meal']+' per meal </span><br /><span class="og">Rs. '+data['salePrice']+' for '+data['duration']+' days | Rs. '+data['discount_price']+' per meal </span>');           
          }
        },
        error: function (data) {
          return false;
        },
    });  
  //}
}



   function  get_nutritionist(){
     
      var state_id = $("#state_id").val();
      var city_id = $("#city_id").val();
      $.ajax({
        type: "POST",
        url: "{{url('/admin')}}/get_list",
        data: {
          city  :  city_id,
          state :  state_id
        }
      }).done(function(data) {
        
           $("#subscriber_body").html(data);
           $("#nutritionist_tbody").html(data);
      });
  }

  $('input.chk_boxn').on('change', function() {
     $('input.chk_boxn').not(this).prop('checked', false);  
  });
 
  /*//mewnu
  $('#menu-item').dataTable( {
   "scrollY": "200px",
  "scrollCollapse": true,
  "paging": false
  } );  

  $('#item2').dataTable( {
   "scrollY": "200px",
  "scrollCollapse": true,
  "paging": false
  } );*/

</script>
<style>
  .mrp{
    text-decoration: line-through;
    color: #d04b4b;
    text-transform: capitalize;
  }
</style>
@endsection