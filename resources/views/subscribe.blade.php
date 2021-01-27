@extends('layouts.master') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.css" rel="stylesheet">
</link>
<!-- css -->
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->
<style>
.wizard-container {
    background-color: #fff;
    margin-top: 4rem;
    border-radius: 6px;
    /* min-height: 410px; */
    box-shadow: 0 16px 24px 2px rgba(0, 0, 0, 0.14), 0 6px 30px 5px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(0, 0, 0, 0.2);
    padding: 18px 0px 0px;
}
.image-container {
    background-position: center center;
    background-size: cover;
    position: relative;
}
.wizgard-footer {
    position: relative;
    padding: 9px 16px 8px;
    background-color: #ddd;
    width: 102%;
    margin-left: -5px;
    margin-right: -5px;
    border-bottom-left-radius: 6px;
    border-bottom-right-radius: 6px;
}
.btn.btn-default.btn-circle {
  text-align: center;
  padding: 6px 6px;
  font-size: 16px;
  text-transform: capitalize;
  background-color: #c1c1c1;
  color: #FFFFFF !important;
  font-weight: 600;
  border: 0;
  cursor: not-allowed;
  pointer-events: none;
  filter: alpha(opacity=65);
  -webkit-box-shadow: none;
  box-shadow: none;
}
.btn.btn-circle.btn-default.btn-primary {
    background-color: #67d251;
    box-shadow: 0 16px 26px -10px rgba(78, 244, 54, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(176, 244, 54, 0.2);
}
.stepwizard-step p {
  margin-top: 2px;
  margin-bottom: 5px;
  font-size: 13px;
}
.setup-content {
    padding:20px 20px 0px;
    position: relative;
    overflow: hidden;
}
.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
    background-color: #e3e2e2;
    padding: 12px 0px 0px;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 27px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #1c2a391c;
    z-order: 0;
}
.wizard-header {
    text-align: center;
    padding: 0px 0 20px;
}
.wizard-header .wizard-title {
    font-weight: 700;
    color: #3C4858;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.info-text {
    text-align: center;
    font-weight: 300;
    margin: 10px 0 30px;
    color: #1c2a39;
}
.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
label {
    font-size: 14px;
    color: #222;
    font-weight: 600;
}
.radio-toolbar input[type="radio"]:checked + label {
    background-color: #b3e6778f;
    border-color: #67d251;
}
.radio-toolbar label {
    display: inline-block;
    background-color: #ddd;
    padding: 6px 20px;
    font-size: 13px;
    border: 1px solid #bec0c1;
        border-top-color: rgb(190, 192, 193);
        border-right-color: rgb(190, 192, 193);
        border-bottom-color: rgb(190, 192, 193);
        border-left-color: rgb(190, 192, 193);
    border-radius: 50px;
    cursor: pointer;
}
.checkbox label, .radio label, label {
    font-size: 14px;
    line-height: 1.42857;
    color: #1C1C1C;
    font-weight: 400;
}
.radio-toolbar input[type="radio"] {
    opacity: 0;
    position: fixed;
    width: 0;
}
.chk-toolbar label {
    display: inline-block;
    background-color: #ddd;
    padding: 6px 20px;
    font-size: 13px;
    border: 1px solid #bec0c1;
    border-radius: 50px;
    cursor: pointer;
}
.checkbox label, .radio label, label {
    font-size: 14px;
    line-height: 1.42857;
    color: #1C1C1C;
    font-weight: 400;
}
.chk-toolbar input[type="checkbox"] {
    opacity: 0;
    position: fixed;
    width: 0;
}
.chk-toolbar input[type="checkbox"]:checked + label {
    background-color: #b3e6778f;
    border-color: #67d251;
}
.offer-price span {
    color: #5e5a5a;
    font-size: 13px;
}
.og {
    color: #64bb2c;
    font-weight: bold;
}
.checkbox a, .checkbox {
    color: #222;
    font-size: 14px;
}
.invoice-from ul li {
    font-size: 12px;
}

    .mt10px{
        margin-top: 10px;
    }
    .mt20px{
        margin-top: 20px;
    }
  
    p{
        line-height: 25px;
    }
    .wizard-navigation .active {
    text-align: center;
    padding: 12px 11px;
    font-size: 12px;
    text-transform: capitalize;
    -webkit-font-smoothing: subpixel-antialiased;
    background-color: #67d251;
    border-radius: 4px;
    color: #FFFFFF !important;
    cursor: pointer;
    font-weight: 600;
    box-shadow: 0 16px 26px -10px rgba(78, 244, 54, 0.56), 0 4px 25px 0px rgba(0, 0, 0, 0.12), 0 8px 10px -5px rgba(176, 244, 54, 0.2);
}
.bl-0{
  border-left:0px !important
}
.br-0{
  border-right:0px !important 
  }
  .checkbox a , .checkbox {
    color: #222;
    font-size: 14px;
}
.table-bordered thead th {
    border-bottom-width: 1px;
    font-size: 14px;
    color: #262626;
}
.parsley-errors-list{
  color: #f00;
  font-weight: 400;
  font-size: 13px;
  list-style:none;
  padding:0px;
}   
</style>

@section('content')

<!-- For Datepickr 
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">-->
<script type="text/javascript" src="{{url('')}}/public/front/dist/date-time-picker.min.js"></script>
<section class="mt-5 pb-0 pt-5">
  <div class="">
    <div class="image-container set-full-height pb-5" 
    style="background-image: url('{{url('')}}/uploads/images/1.jpeg')"> 
      <!--   Big container   -->
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <div class="wizard-container">
              <div class="wizard-header">
                <h3 class="wizard-title"> Subscribe Now </h3>
              </div>
              <div class="stepwizard">
              <div class="stepwizard-row setup-panel">
                  <div class="stepwizard-step">
                      <a href="#step-1" type="button" class="btn btn-primary btn-circle">
                        <i class="fa fa-user-o" aria-hidden="true"></i>
                      </a>
                      <p>Personal</p>
                  </div>
                  <div class="stepwizard-step">
                      <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">
                        <i class="fa fa-medkit" aria-hidden="true"></i>
                      </a>
                      <p>Health</p>
                  </div>
                  <div class="stepwizard-step">
                      <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">
                        <i class="fa fa-heart" aria-hidden="true"></i>
                      </a>
                      <p>Choose Plan</p>
                  </div>
                  <div class="stepwizard-step">
                    <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">
                      <i class="fa fa-truck" aria-hidden="true"></i>
                    </a>
                    <p>Delivery</p>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">
                    <i class="fa fa-check" aria-hidden="true"></i>
                  </a>
                  <p>Checkout</p>
              </div>
              </div>
          </div>
          <form role="form" class="w-100" data-parsley-validate="parsley">
              <div class="row setup-content" id="step-1">
                  <div class="col-sm-12">
                    <h4 class="info-text"> Let's start with the basic details.</h4>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-group mb-0"> 
                          <div class="form-group label-floating w-100">
                            <label class="control-label">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 ">
                              <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-user-circle" aria-hidden="true"></i></span> </div>
                              <input type="text" name="full_name" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Full Name"
                              name="first_name" Choose placeholder="First Name" required="true" data-parsley-errors-container="#firstname-errors">
                            </div>
                            <div id="firstname-errors"></div>
                             </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group label-floating">
                          <label class="control-label">Email <span class="text-danger">*</span></label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon3" ><i class="fa fa-envelope" aria-hidden="true"></i></span> </div>
                            <input type="email" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Email" name="email" required="required" data-parsley-errors-container="#email-errors">
                          </div>
                          <div id="email-errors"></div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group label-floating w-100">
                          <label class="control-label">Mobile <span class="text-danger">*</span></label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon3"><i class="fa fa-phone" aria-hidden="true"></i></span> </div>
                            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Mobile" name="mobile" required="required"  data-parsley-length="[10, 10]" data-parsley-errors-container="#mobile-errors" maxlength="10">
                          </div>
                          <div id="mobile-errors"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizgard-footer">                  
                    <button class="btn btn-secondary pb-1 pt-1 nextBtn pull-right" type="button" > Next &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>
                  </div>
              </div>
              <div class="row setup-content" id="step-2">
                <div class="col-sm-12">
                  <h4 class="info-text"> Let us know more about your Health </h4>
                </div>
                <div class="col-sm-12 mb-3">
                 <div class="row">
                   <div class="col-sm-5">
                     <div class="row">
                       <div class="col-5">
                          <div class="form-group label-floating">
                            <label class="control-label">Age <span class="text-danger">*</span></label>
                            <input name="age" type="text" class="form-control" placeholder="Age" required="required"  data-parsley-errors-container="#age-errors" data-parsley-error-message="Age required" maxlength="3" >
                            <div id="age-errors"></div>
                          </div>
                       </div>
                       <div class="col-7">
                        <div class="form-group label-floating w-100">
                          <label class="control-label">Gender <span class="text-danger">*</span></label>
                          <select class="form-control" name="gender" id="gender" required="required" style="min-height:45px"  data-parsley-errors-container="#gender-errors" data-parsley-error-message="Gender required" >
                            <option selected="selected" disabled="disabled" value="">Select</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">Other</option>
                          </select>
                          <div id="gender-errors"></div>
                        </div>                        
                       </div>
                     </div>
                   </div>
                   <div class="col-sm-7">
                     <div class="row">
                       <div class="col-5">
                        <div class="form-group label-floating">
                          <label class="control-label">Weight <span class="text-danger">*</span></label>
                          <input name="weight" type="text" class="form-control" placeholder="Kgs" required="required" data-parsley-errors-container="#weight-errors" data-parsley-error-message="Weight required">  
                          <div id="weight-errors"></div>                        
                        </div>
                       </div>
                       <div class="col-7">
                        <label class="control-label">Height <span class="text-danger">*</span></label>
                        <div  class="form-group label-floating">
                          <div class="row">
                            <div class="col-6 pr-1">
                              <input type="text" name="height_in_feet" class="form-control" placeholder="Feet" required="required" data-parsley-errors-container="#height-in-feet-errors" data-parsley-error-message="Feet required"><div id="height-in-feet-errors"></div>   
                            </div>
                            <div class="col-6 pl-1">
                              <input type="text" name="height_in_inches" class="form-control" placeholder="Inch" required="required" data-parsley-errors-container="#height-in-inches-errors"  data-parsley-error-message="Inch required">
                              <div id="height-in-inches-errors"></div> 
                            </div>
                          </div>
                        </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                      <label class="control-label">Physical Activity <span class="text-danger">*</span></label>
                        <select class="form-control" name="physical_activity_id" id="physical_activity_id" required="required"  data-parsley-errors-container="#physical-activity-errors"  data-parsley-error-message="Physical activity required">
                          <option selected="selected" disabled="disabled" value="" >Select an option</option>
                           @foreach($data['getPhysicalActivityData'] as $getPhysicalActivity)
                          <option value="{{ $getPhysicalActivity['physical_activity_id'] }}">
                            {{ $getPhysicalActivity['physical_activity'] }}
                          </option>
                           @endforeach   
                        </select>
                        <div id="physical-activity-errors"></div> 
                    </div>
                   </div>
                   <div class="col-sm-6 col-md-4">
                      <div class="form-group">
                        <label class="control-label">Avoid / Dislike Food <span class="text-danger">*</span></label>
                        <select id="demo" multiple name="avoid_or_dislike_food_id[]" data-parsley-checkmin="1" required data-parsley-errors-container="#avoid-or-dislike-errors"  data-parsley-error-message="Avoid / Dislike Food required">
                          <option value="None">None</option>
                              @foreach($data['getFoodAvoidData'] as $getFoodAvoidData)
                          <option value="{{ $getFoodAvoidData['food_avoid_id'] }}"> {{ $getFoodAvoidData['food_avoid_name'] }} </option>
                              @endforeach  
                          <option value="Other">Other</option>
                        </select>
                        <div id="avoid-or-dislike-errors"></div> 
                      </div>
                 </div>
                 <div class="col-sm-6 col-md-4">
                    <div class="form-group">
                        <div id="other_food_div">
                          <label class="control-label">Other Food</label>
                          <input name="other_food" type="text" class="form-control" placeholder="Other">
                        </div>
                    </div>
                   </div>
                </div>
                </div>
                <div class="col-sm-12 mb-3">
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Any lifestyle disease? (Diabetes,Cholesterol,etc)</label>
                        <textarea class="form-control" rows="2" name="lifestyle_disease" id="lifestyle_disease" placeholder="Any lifestyle disease"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="form-group label-floating">
                        <label class="control-label">Any food preparation instructions?</label>
                        <textarea class="form-control" rows="2" name="food_precautions" id="food_precautions" placeholder="Any Food Precautions"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-secondary pb-1 pt-1 prevBtn" type="button" ><i class="fa fa-angle-left" aria-hidden="true"></i> Previous &nbsp;
                    </button>
                    <button class="btn btn-secondary pb-1 pt-1 nextBtn pull-right" type="submit" >
                      Next &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>
                  </div>
              </div>
              <div class="row setup-content" id="step-3">
                <div class="col-sm-12">
                  <h4 class="info-text"> <span class="text-success font-weight-bold">{{ $data['getSubscribeNowPlan']['name'] }}</span>  Details</h4>
                </div>
                  <div class="col-sm-12 mb-3">
                   <div class="row">
                    <div class="col-sm-6 col-md-4">
                      <div class="form-group label-floating">
                        <label class="control-label">Start Date<span class="text-danger">*</span></label>
                        <input type="text" class="mt10px input form-control" id="start_date" value="<?php echo date('Y-m-d', strtotime('+ 2 day')) ?>">
                      </div>
                    </div> 
                    <div class="col-sm-6 col-md-8">
                      <div class="form-group label-floating">
                        <label class="control-label">No. of days <span style="color: red;"> *</span></label>
                        <div id="meals" class="radio-toolbar">
                          @foreach($data['getSubscribeNowPlan']['duration'] as $key => $duration_dtl)
                          <input type="radio" onclick="calculatePrice();" id="rad_{{ $duration_dtl['subscribe_now_duration'] }}" name="radNoOfDays" data-id="{{ $duration_dtl['subscribe_now_duration'] }}" value="{{ $duration_dtl['subscribe_now_plan_duration_id'] }}" 
                              <?php echo ($key == 0) ? 'checked' : '' ?> class="subscribe_now_plan_duration_id" required="required">
                          <label for="rad_{{ $duration_dtl['subscribe_now_duration'] }}">{{ $duration_dtl['subscribe_now_duration'] }}</label>
                          @endforeach </div>
                      </div>
                    </div>
                    <div class="col-sm-12 mb-1">
                      <label class="control-label"> Type of meals <span style="color:red;">*</span></label>
                      <div id="meals">
                        <div class="chk-toolbar"> @foreach($data['getMealTypeData'] as $getMealTypeData)
                          <input type="checkbox" id="radio{{ $getMealTypeData['meal_type_name'] }}" name="radioFruit[]" data-value="radioFruitValue" data-no="1" class="meal_type_id" value="{{ $getMealTypeData['meal_type_id'] }}" dataname="{{ $getMealTypeData['meal_type_name'] }}" onclick="calculatePrice();" required="required">
                          <label for="radio{{ $getMealTypeData['meal_type_name'] }}">{{ $getMealTypeData['meal_type_name'] }}</label>
                          @endforeach </div>
                      </div>
                      <input type="hidden" name="" id="checkout_meal_type_name_value">
                    </div>
                    <div class="col-sm-12 mb-1">
                      <div class="">
                        <label class="control-label">Price</label>
                        <div style="border:dotted" class="p-2">
                          <div class="offer-price"> <del> <span style="display: block;" id="close_value"></span> </del> </div>
                          <span class="og"  id="rs_html"> Rs.</span> <span class="og" id="final_value" ></span> | <span class="og" id="final_value_details"></span> </div>
                        <input type="hidden" name="price" id="price">
                        <input type="hidden" id="total" name="total">
                        <input type="hidden" id="discount_value" name="discount">
                      </div>
                    </div>                    
                   </div> 
                   <span style="font-size: 12px;"><span style="color: #e81212;">*</span> 5% GST applicable</span> 
                  </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-secondary pb-1 pt-1 prevBtn" type="button" ><i class="fa fa-angle-left" aria-hidden="true"></i> Previous &nbsp;
                    </button>
                    <button class="btn btn-secondary pb-1 pt-1 nextBtn pull-right" type="button" >
                      Next &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>
                  </div>
              </div>
              <div class="row setup-content" id="step-4">
                <div class="col-sm-12">
                  <h4 class="info-text"> 
                    <span class="text-success font-weight-bold">Address</span>  Details
                  </h4>
                </div>
                  <div class="col-sm-12 mb-3">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="control-label">Address <span style="color: red;">*</span></label>
                          <textarea class="form-control" placeholder="Address" name="address1" id="address1" rows="3" required="required" style="height: 134px;"></textarea>
                          <span id="err_address1" class="text-danger"></span>
                        </div>  
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Pincode <span style="color: red;">*</span></label>
                              <input type="text" placeholder="Pincode" name="pincode1" id="pincode1" class="form-control" required="required" minlength="6" maxlength="6">
                              <span id="err_pincode1" class="text-danger"></span>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-6">
                            <div class="form-group" id="mealtype_div">
                                <label class="control-label">Select meal type</label>
                                <select multiple id="mealtype1" class="form-control" name="address1_meal[]" onchange="selectSessionValue('mealtype1');">
                                </select>
                              <input type="hidden" name="" id="checkout_address1_meal1">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr/>
                    <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="control-label">Office Address <span style="color: red;">*</span></label>
                          <textarea class="form-control" placeholder="Address" name="address2" id="address2" rows="3" required="required" style="height: 134px;"></textarea>
                          <span id="err_address1" class="text-danger"></span>
                        </div>  
                      </div>
                      <div class="col-md-4">
                        <div class="row">
                          <div class="col-md-12 col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Pincode <span style="color: red;">*</span></label>
                              <input type="text" placeholder="Pincode" name="pincode2" id="pincode2"  class="form-control" required="required" minlength="6" maxlength="6">
                              <span id="err_pincode1" class="text-danger"></span>
                            </div>
                          </div>
                          <div class="col-md-12 col-sm-6">
                            <div class="form-group" id="mealtype_div">
                                <label class="control-label">Select meal type</label>
                                <select multiple id="mealtype1" class="form-control" name="address2_meal[]" onchange="selectSessionValue('mealtype2');">
                                </select>
                                <input type="hidden" name="" id="checkout_address1_meal2">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="optionsCheckboxes" class="showDive" id="optionsCheckboxes" onchange="showAddress();">
                          </label>
                          Is your evening address same?</div>
                      </div>
                      <div class="col-md-12">
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" value="1" name="termsConditions" class="showDive" id="termsConditions" required="required">
                          </label>
                          <a href="{{url('')}}/terms_conditions">I Agree With Terms & Conditions? <span style="color: red;">*</span></a><br>
                          <span id="err_termsConditions" style="color: red;font-size: 13px;"></span> </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-secondary pb-1 pt-1 prevBtn" type="button" ><i class="fa fa-angle-left" aria-hidden="true"></i> Previous &nbsp;
                    </button>
                    <button class="btn btn-secondary pb-1 pt-1 nextBtn pull-right" type="button" >
                      Next &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>
                  </div>
              </div>
                
                <div class="row setup-content" id="step-5">
                  <div class="col-sm-12 mb-3">
                    <!-- Invoice -->                      
                     <div class="row invoice row-printable">
                      <div class="col-md-12"> 
                        <!-- col-lg-12 start here -->
                        <div class="panel panel-default plain" id="dash_0"> 
                          <!-- Start .panel -->
                          <div class="panel-body p30">
                            <div class="row ml-2 mr-2">
                              <div class="col-lg-6"> 
                                <!-- <div class="invoice-logo"><img width="100" src="https://nutridock.com/public/front/img/logo.png" alt="Invoice logo"></div> --> 
                              </div>
                              <div class="col-lg-6">
                                <div class="invoice-from ">
                                  <ul class="list-unstyled text-right mb-0">
                                    <li>Nutridock, Store B-17,MIDC Ambad</li>
                                    <li>Nashik,Maharashtra 422010</li>
                                    <li>GST EU826113958<br>
                                    </li>
                                  </ul>
                                </div>
                              </div>
                              <div class="col-lg-12 text-right text-danger" ><small>Note : Please check & confirm your plan details</small></div>
                              <div class="col-lg-12 border-top pt-3 mt-2">
                                  <div style="text-align: center; display: none;" id="all_details" >
                                      <span id="err_all_details" style="color: red;"> </span>
                                    </div>
                                
                                <div class="invoice-to mt-3 mb-3">
                                  <table>
                                    <tr>
                                      <td>Name</td>
                                      <td class="text-center" style="width:35px"> : </td>
                                      <td style="min-width: 76%;"><span id="checkout_name"></span></td>
                                    </tr>
                                    <tr>
                                      <td> Mobile No.</td>
                                      <td class="text-center" style="width:35px"> : </td>
                                      <td>+91 <span id="checkout_phone_no"></span></td>
                                    </tr>
                                    <tr>
                                      <td>Email</td>
                                      <td class="text-center" style="width:35px"> : </td>
                                      <td><span id="checkout_email"></span></td>
                                    </tr>
                                    <tr>
                                      <td>Address-1 </td>
                                      <td class="text-center" style="width:35px"> : </td>
                                      <td><span id="checkout_address1"></span> <span id="openbrk1" style="display: none;">(</span><span id="checkout_address1_meal"></span><span id="openbrk2" style="display: none;">)</span></td>
                                      <!-- X-46, MIDC,Ambad, Nashik, 4221021 --> 
                                    </tr>
                                    <tr id="checkout_address2_div" style="display: none;">
                                      <td>Address-2</td>
                                      <td class="text-center" style="width:35px"> : </td>
                                      <td><span id="checkout_address2"></span> (<span id="checkout_address2_meal"></span><span id="checkout_address1_meal"></span>)</td>
                                      <!-- Hari om appartment,Nasik road, 4221021 --> 
                                    </tr>
                                  </table>
                                </div>
                                <div class="invoice-items mt-3">
                                  <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                    <table class="table table-bordered">
                                      <thead>
                                        <tr>
                                          <th class=" br-0">No. of days</th>
                                          <th class="per70 br-0">Meal Plan</th>
                                          <th class="per5 text-right bl-0 br-0">Meal Type</th>
                                          <th class="per25 text-right bl-0">Total</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        <tr>
                                          <td class="br-0"><span id="checkout_no_of_days"></span> Days</td>
                                          <td class="text-left br-0 bl-0">Classic</td>
                                          <td class="text-right br-0 bl-0"><span id="checkout_meal_type_name" ></span></td>
                                          <td class="text-right bl-0"><span id="checkout_price"></span>/-</td>
                                        </tr>                                       
                                      </tbody>
                                                                          
                                        <tr>
                                          <th colspan="3" class="text-right br-0" style="border-bottom: 0px;">GST</th>
                                          <th class="text-right bl-0" style="border-bottom: 0px;">5% </th>
                                        </tr>
                                        <tr>
                                          <th colspan="3" class="text-right br-0" style="border-top: 0px;">Total</th>
                                          <th class="text-right bl-0" style="border-top: 0px;"><span id="checkout_final_gst_value"></span> </th>
                                        </tr>
                                      </tfoot>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <!-- col-lg-12 end here --> 
                            </div>
                            <!-- End .row --> 
                          </div>
                        </div>
                        <!-- End .panel --> 
                      </div>
                      <!-- col-lg-12 end here --> 
                    </div>
                    <!-- Invoice --> 
                  </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-success pb-1 pt-1 nextBtn pull-right" type="button">
                      <i class="fa fa-hand-o-right" aria-hidden="true"></i> &nbsp;  Finish 
                    </button>
                  </div>
                </div>
            </form>
          </div>
        </div>
        </div>
      </div>   
    </div>
  </div>
</section>
<script type="text/javascript" src="{{url('')}}/public/js/form-wizard.js"></script>
<script type="text/javascript" src="{{url('')}}/public/front/js/bootstrap-datepicker.min.js"></script>

<script>
$(document).ready(function () {
var navListItems = $('div.setup-panel div a'),
    allWells = $('.setup-content'),
    allNextBtn = $('.nextBtn');
    allPrevBtn = $('.prevBtn');

allWells.hide();

navListItems.click(function (e) {
    e.preventDefault();
    var $target = $($(this).attr('href')),
            $item = $(this);

    if (!$item.hasClass('disabled')) {
        navListItems.removeClass('btn-primary').addClass('btn-default');
        $item.addClass('btn-primary');
        allWells.hide();
        $target.show();
        $target.find('input:eq(0)').focus();
    }
});

allNextBtn.click(function(){
    var curStep = $(this).closest(".setup-content"),
        curStepBtn = curStep.attr("id"),
        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
        curInputs = curStep.find("input[type='text'],input[type='url'],input[type='email']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid){
            isValid = false;
           // $(curInputs[i]).closest(".form-group").addClass("has-error");
            if ($(curInputs[i]).parsley().validate() !== true) isValid = false;
        }
    }
    
    if (isValid)
        nextStepWizard.removeAttr('disabled').trigger('click');
});

/* script for previous button click */
allPrevBtn.click(function(){
var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a").trigger('click');
});



$('div.setup-panel div a.btn-primary').trigger('click');
});

$(document).ready(function() {
  var x = new SlimSelect({
    select: '#demo'
  });

  var mySessionId = '<?php echo Session::getId(); ?>';
  //console.log(mySessionId);

  var x = new SlimSelect({
    select: '#mealtype1'
  });

  var x = new SlimSelect({
    select: '#mealtype2'
  });
});
</script>
@endsection 