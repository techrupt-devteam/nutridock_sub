@extends('layouts.master') 
<script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.css" rel="stylesheet">
</link>
<!-- css -->
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<!------ Include the above in your HEAD tag ---------->
<link href="{{url('')}}/public/front/css/signUp.css" rel="stylesheet"/>

@section('content')

<!-- For Datepickr 
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css"> -->
<script type="text/javascript" src="{{url('')}}/public/front/dist/date-time-picker.min.js"></script>
<script type="text/javascript" src="{{url('')}}/public/front/js/settings.js"></script>
<section class="pb-0 pt-0" style="margin-top: 2.3rem">
  <div class="">
    <div class="image-container set-full-height pb-5" 
    style="background-image: url('{{url('')}}/uploads/images/bg-img.jpg')"> 
      <!--   Big container   -->
      <div class="container">
        <div class="row">
          <div class="col-lg-9 mx-auto">
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
          <form role="form" id="sign-up" class="w-100" method="POST"  action="#" data-parsley-validate="">
          {!! csrf_field() !!}
              <!-- @START: Personal Details tab -->
              <div class="row setup-content step-1" id="step-1">
             
                  <div class="col-sm-12">
                    <h4 class="info-text"> Let's start with the basic details.</h4>                    
                  </div>
                  <div class="col-sm-12 mb-3">
                  <div class="alert alert-danger" id="signup-alert-danger" role="alert" style="font-size:13px; display:none" ></div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-group mb-0"> 
                          <div class="form-group label-floating w-100">
                            <label class="control-label">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group mb-3 ">
                              <div class="input-group-prepend"> 
                                <span class="input-group-text">
                                  <i class="fa fa-user-circle" aria-hidden="true"></i>
                                </span> 
                              </div>
                              <input type="text" name="full_name" class="form-control" id="full_name" aria-describedby="basic-addon3" placeholder="Full Name"
                              name="first_name" Choose placeholder="First Name" required="required" 
                              autocomplete="nope"
                              data-parsley-errors-container="#firstname-errors" data-parsley-group="step-1">
                            </div>
                             <div id="firstname-errors" style="margin-left:0px !important;margin-top: -11px!important;"></div>
                             </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group label-floating">
                          <label class="control-label">Email <span class="text-danger">*</span></label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon3" ><i class="fa fa-envelope" aria-hidden="true"></i></span> </div>
                            <input type="email" class="form-control" id="email" aria-describedby="basic-addon3" placeholder="Email" name="email" required="required" data-parsley-errors-container="#email-errors" 
                            data-parsley-trigger="change"
                            autocomplete="nope"
                            data-parsley-group="step-1" value="{{ Session::get('subscriber_email') }}" 
                            {{ Session::get('subscriber_email') ? 'readonly' : ''}}>
                          </div>
                          <div id="email-errors" style="margin-top: -11px!important;"></div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group label-floating w-100">
                          <label class="control-label">Mobile <span class="text-danger">*</span></label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon3"><i class="fa fa-phone" aria-hidden="true"></i></span> </div>
                            <input type="number" class="form-control" id="mobile_no" 
                            autocomplete="nope"
                            aria-describedby="basic-addon3" placeholder="Mobile" name="mobile_no" required="required" maxlength="10"
                            data-parsley-pattern="^[0-9]*$" 
                            data-parsley-trigger="keyup" 
                            data-parsley-errors-container="#mobile-errors"     
                            data-parsley-type="number"                        
                            data-parsley-group="step-1" 
                            value="{{ Session::get('subscriber_mobile') }}"
                            {{ Session::get('subscriber_mobile') ? 'readonly' : ''}}
                            >
                          </div>
                          <div id="mobile-errors"  style="margin-top: -11px!important;"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="wizgard-footer"> 
                   <span class="nextBtn btn btn-dark pull-right" data-current-block="1" data-next-block="2">Next 
                   </span> 
                  </div>
              </div>
              <!-- @END: Personal Details tab -->

              <!-- @START: Personal Health Details tab -->
              <div class="row setup-content step-2" id="step-2">
                <div class="col-sm-12">
                  <h4 class="info-text"> Let us know more about your Health </h4>
                </div>
                <div class="col-sm-12 mb-3">
                 <div class="row">
                   <div class="col-sm-6">
                     <div class="row">
                       <div class="col-6">
                          <div class="form-group label-floating">
                            <label class="control-label">Age <span class="text-danger">*</span></label>
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
                       <div class="col-6">
                        <div class="form-group label-floating w-100">
                          <label class="control-label">Gender <span class="text-danger">*</span></label>
                          <select class="form-control" name="gender" id="gender" required="required" style="min-height:45px"  data-parsley-errors-container="#gender-errors" data-parsley-error-message="Gender required" data-parsley-group="step-2">
                            <option value="">Select</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">Other</option>
                          </select>
                          <div id="gender-errors"></div>
                        </div>                        
                       </div>
                     </div>
                   </div>
                   <div class="col-sm-6">
                     <div class="row">
                       <div class="col-5">
                        <div class="form-group label-floating">
                          <label class="control-label">Weight <span class="text-danger">*</span></label>
                          <input name="weight" type="text" class="form-control" placeholder="Kgs" 
                          autocomplete="nope"
                          required="required"  
                          data-parsley-errors-container="#weight-errors" 
                          data-parsley-error-message="Weight required" 
                          data-parsley-group="step-2">  
                          <div id="weight-errors"></div>                        
                        </div>
                       </div>
                       <div class="col-7 pl-2">
                        <label class="control-label">Height <span class="text-danger">*</span></label>
                        <div  class="form-group label-floating">
                          <div class="row">
                            <div class="col-6 pr-1">
                              <input type="text" name="height_in_feet" class="form-control" placeholder="Feet" required="required" 
                              autocomplete="nope"
                              data-parsley-errors-container="#height-in-feet-errors" data-parsley-error-message="Feet required" 
                              data-parsley-group="step-2">
                              <div id="height-in-feet-errors" ></div>   
                            </div>
                            <div class="col-6 pl-1">
                              <input type="text" name="height_in_inches" class="form-control" placeholder="Inch" required="required" 
                              autocomplete="nope"
                              data-parsley-errors-container="#height-in-inches-errors"  data-parsley-error-message="Inch required" data-parsley-group="step-2">
                              <div id="height-in-inches-errors"></div> 
                            </div>
                          </div>
                        </div>
                       </div>
                     </div>
                   </div>
                 </div>
                 <div class="row">
                   <div class="col-sm-6">
                    <div class="form-group">
                      <label class="control-label">Physical Activity <span class="text-danger">*</span></label>
                        <select class="form-control" name="physical_activity_id" id="physical_activity_id" required="required" 
                        autocomplete="nope"
                        data-parsley-errors-container="#physical-activity-errors"  data-parsley-error-message="Physical activity required" 
                        data-parsley-group="step-2" style="min-height: 45px;">
                          <option selected="selected" value=" " >Select an option</option>
                           @foreach($data['getPhysicalActivityData'] as $getPhysicalActivity)
                          <option value="{{ $getPhysicalActivity['physical_activity_id'] }}">
                            {{ $getPhysicalActivity['physical_activity'] }} 
                          </option>
                           @endforeach   
                        </select>
                        <div id="physical-activity-errors"></div> 
                    </div>
                   </div>
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label class="control-label">Avoid / Dislike Food <span class="text-danger">*</span></label>
                        <select id="avoid_food_id" class="form-control" multiple name="avoid_or_dislike_food_id[]" data-parsley-checkmin="1" required data-parsley-errors-container="#avoid-or-dislike-errors"  data-parsley-error-message="Avoid / Dislike Food required" data-parsley-group="step-2">
                          <option value="None">None</option>
                          @foreach($data['getFoodAvoidData'] as $getFoodAvoidData)
                          <option value="{{ $getFoodAvoidData['food_avoid_id'] }}"> 
                            {{ $getFoodAvoidData['food_avoid_name'] }} </option>
                          @endforeach  
                          <option value="Other">Other</option>
                        </select>
                        <div id="avoid-or-dislike-errors"></div> 
                      </div>
                 </div>
                 <div class="col-sm-12">
                    <div class="form-group" style="z-index: unset;">
                        <div id="other_food_div">
                          <label class="control-label">Other Food</label>
                          <input name="other_food" type="text" class="form-control" placeholder="Other" autocomplete="nope">
                        </div>
                    </div>
                   </div>
                </div>
                </div>
                <div class="col-sm-12 mb-3">
                  <div class="row">
                    <div class="col-lg-6">
                      <div class="form-group label-floating" style="z-index: auto;">
                        <label class="control-label">Any lifestyle disease? (Diabetes,Cholesterol,etc)</label>
                        <textarea class="form-control" rows="1" name="lifestyle_disease" id="lifestyle_disease" placeholder="Any lifestyle disease"></textarea>
                      </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="form-group label-floating" style="z-index: auto;">
                        <label class="control-label">Any food preparation instructions?</label>
                        <textarea class="form-control" rows="1" name="food_precautions" id="food_precautions" placeholder="Any Food Precautions"></textarea>
                      </div>
                    </div>
                  </div>
                </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-secondary pb-1 pt-1 prevBtn" type="button" > Previous 
                    </button>
                    <span class="nextBtn btn btn-dark pull-right" data-current-block="2" data-next-block="3"> Next </span> 
                  
                  </div>
              </div>
              <!-- @END: Personal Health Details tab -->

              <!-- @START: Plan details tab -->
              <div class="row setup-content step-3" id="step-3">
                <div class="col-sm-12">
                  <h4 class="info-text"> <span class="font-weight-bold" style="color:#70AA20">Plan </span>Details</h4>
                </div>
                <div class="col-sm-6 mb-2">     
                    <label class="control-label">Select Subscription Plan <span class="text-danger">*</span></label> 
                    <div class="row">
                      @foreach($data['getSubscriptionPlan'] as $getSubscriptionPlanKey => $getSubscriptionPlan)                        
                      <div class="col-sm-12 radio-toolbar mb-2">                  
                        <input type="radio" id="{{ $getSubscriptionPlan['sub_name'] }}" name="radioSubscriptionPlan" value="{{ $getSubscriptionPlan['sub_plan_id'] }}" onchange="getPlan(this.value);" required="" data-parsley-errors-container="#sub-plan-errors" data-parsley-error-message="Please select subscription plan" data-parsley-group="step-3" {{($getSubscriptionPlanKey == 0) ? 'checked' : '' }} > 
                        <label for="{{ $getSubscriptionPlan['sub_name'] }}" class="w-100"> 
                        <img src="{{url('')}}/uploads/subscription_icon/thumb/{{ $getSubscriptionPlan['icon_image'] }}" height="35">
                        {{ $getSubscriptionPlan['sub_name'] }} 
                        <a href="#" class="float-right info-popover" data-placement="bottom" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">
                          <i class="fa fa-info-circle" aria-hidden="true"></i>
                        </a>

                        </label>                        
                        </div>
                    @endforeach
                    </div>      
                   
                    <div id="sub-plan-errors"></div>
              
                </div>

                <div class="col-sm-6 mb-2">
                      <div class="form-group label-floating">
                        <label class="control-label">No of Days <span class="text-danger">*</span></label>
                        <div class="col-sm-12 radio-toolbar">
                          <div class="row" id="getPlanDetails"> </div>
                          <div id="duration-errors"></div>
                        </div>
                      </div>
                   </div>
                     
                    <div class="col-sm-6">
                      <div class="form-group label-floating">
                        <label class="control-label">Start Date <span class="text-danger">*</span></label>
                        <div class="input-group date" >
                          <div class="input-group-prepend"> 
                            <span class="input-group-text">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            </span> 
                          </div>
                          <input type="text" data-provide="datepicker" class="form-control" name="start_date" id="start_date" required="required" data-parsley-errors-container="#start-date-errors" data-parsley-error-message="Date required" data-parsley-group="step-3" autocomplete="nope" value="<?php echo date("Y-m-d", strtotime("+ 2 day")) ?>">
                        </div>
                      
                        <div id="start-date-errors"></div>
                      </div>                      
                    </div>
                 
                
                
                <div class="col-sm-12 mb-3" id="plandetails" style="display: none;">
                  <div class="row">                    
                    <div class="col-sm-12 mb-1">
                      <label class="control-label"> Type of meals <span style="color:red;">*</span></label>
                      <div id="meals">
                        <div class="chk-toolbar"> 
                          @foreach($data['getMealTypeData'] as $getMealTypeDataKey => $getMealTypeData)
                            <input 
                            type="checkbox" 
                            id="{{ $getMealTypeData['meal_type_name'] }}" 
                            name="radioMealType" 
                            class="meal_type_id" 
                            value="{{ $getMealTypeData['meal_type_id'] }}" 
                            required="required" 
                            autocomplete="nope"
                            data-parsley-errors-container="#meal-type-errors" 
                            data-parsley-error-message="Please select Type of meals" 
                            data-parsley-group="step-3" 
                            onchange="getPlanPrice();"
                            {{($getMealTypeDataKey == 0) ? "checked" : "" }} >
                            <label for="{{ $getMealTypeData['meal_type_name'] }}">
                              {{ $getMealTypeData['meal_type_name'] }}
                            </label> 
                          @endforeach 
                          <div id="meal-type-errors"></div>
                          <input type="hidden" id="meal_type" name="meal_type" />
                        </div>
                      </div>                      
                    </div>                   
                    <div class="col-sm-12 mb-1">
                      <div class="">
                        <label class="control-label">Price</label>
                        <div style="border:1px dashed #4f4f4f;background-color: #e1e1e1;" class="p-2">
                          <div class="price"></div>
                        </div>
                      </div>
                    </div> 
                    <span style="font-size: 12px;" class="ml-3 mt-2 p-2 alert-info">
                    <span style="color: #e81212;">*</span> 5% GST applicable</span>
                  </div>
                </div>
                <div class="wizgard-footer">
                  <button class="btn btn-secondary pb-1 pt-1 prevBtn" type="button" ><i class="fa fa-angle-left" aria-hidden="true"></i> Previous &nbsp;
                  </button>
                  <span class="nextBtn btn btn-dark pull-right" data-current-block="3" data-next-block="4">Next 
                  </span>                 
                </div>
              </div>
              <!-- @END: Plan details tab -->

              <!-- @START: Address details tab -->
              <div class="row setup-content step-4" id="step-4">
                <div class="col-sm-12">
                  <h4 class="info-text"> 
                    <span class="font-weight-bold" style="color: #70AA20;">Address</span>  Details
                  </h4>
                </div>
                  <div class="col-sm-12 mb-3">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="control-label">Address <span style="color: red;">*</span></label>
                          <textarea class="form-control" placeholder="Address" name="address1" id="address1" rows="2" required="required" data-parsley-group="step-4"></textarea>
                          <span id="err_address1" class="text-danger"></span>
                        </div>  
                      </div>
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Pincode <span style="color: red;">*</span></label>
                              <input type="text" placeholder="Pincode" name="pincode1" id="pincode1" class="form-control" required="required" minlength="6" maxlength="6"  data-parsley-group="step-4">
                              <span id="err_pincode1" class="text-danger"></span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group" id="mealtype_div">
                                <label class="control-label">Select meal type</label>
                                <select multiple id="mealtype1" class="form-control" name="address1_meal[]" >
                                <option value="None">None</option>                                
                                </select>
                              <input type="hidden" name="" id="checkout_address1_meal1">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <hr/>
                    <div class="row" style="z-index: 1;position: relative;">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="control-label">Office Address <span style="color: red;">*</span></label>
                          <textarea class="form-control" placeholder="Address" name="address2" id="address2" rows="2" required="required"></textarea>
                          <span id="err_address1" class="text-danger"></span>
                        </div>  
                      </div>
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-sm-6">
                            <div class="form-group">
                              <label class="control-label">Pincode <span style="color: red;">*</span></label>
                              <input type="text" placeholder="Pincode" name="pincode2" id="pincode2"  class="form-control" required="required" minlength="6" maxlength="6" autocomplete="nope">
                              <span id="err_pincode1" class="text-danger"></span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <div class="form-group" id="mealtype_div">
                                <label class="control-label">Select meal type</label>
                                <select multiple id="mealtype2" class="form-control" name="address2_meal[]">
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
                            <input type="checkbox" value="1" name="termsConditions" class="showDive" id="termsConditions" required="required"
                            data-parsley-errors-container="#err_termsConditions" 
                            data-parsley-error-message="Please select Type of meals"  
                            data-parsley-group="step-4">
                          </label><!-- 
                          //{{url('')}}/terms_conditions -->
                          <a href="#" data-toggle="modal" data-target="#myModal">I Agree With Terms & Conditions? <span style="color: red;">*</span></a><br>
                         </div>                         
                      </div>
                      <div id="err_termsConditions" style="color: red;font-size: 13px;"></div> 
                    </div>
                  </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-secondary pb-1 pt-1 prevBtn" type="button" ><i class="fa fa-angle-left" aria-hidden="true"></i> Previous &nbsp;
                    </button>
                    <button type="button" class="nextBtn btn btn-dark pull-right" data-current-block="4" data-next-block="5" onclick="getData();" >
                    Next </button> 
                    <!-- <button class="btn btn-success pb-1 pt-1 nextBtn pull-right" type="button" >
                      Next &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button> -->
                  </div>
              </div>
              <!-- @END: Address details tab -->
              
              <!-- @START: Checkout tab -->
              <div class="row setup-content" id="step-5">
                <div class="col-sm-12 mb-3">
                  <!-- Invoice -->                      
                    <div class="row invoice row-printable">
                    <div class=""> 
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
                            <div class="w-100 border-top pt-2 mt-2">
                              <div style="text-align: center; display: none;" id="all_details" >
                                  <span id="err_all_details" style="color: red;"> </span>
                              </div>                            
                              <div class="invoice-to mt-3 mb-3">
                                <table>
                                  <tr>
                                    <td><strong> Name </strong></td>
                                    <td class="text-center" style="width:35px"> : </td>
                                    <td style="min-width: 76%;"><span id="checkout_name"></span></td>
                                  </tr>
                                  <tr>
                                    <td><strong> Mobile No. </strong></td>
                                    <td class="text-center" style="width:35px"> : </td>
                                    <td>+91 <span id="checkout_phone_no"></span></td>
                                  </tr>
                                  <tr>
                                    <td><strong> Email </strong></td>
                                    <td class="text-center" style="width:35px"> : </td>
                                    <td><span id="checkout_email"></span></td>
                                  </tr> 
                                  </table>
                              </div>
                              <div class="invoice-items mt-3">
                                <div class="table-responsive" style="overflow: hidden; outline: none;" tabindex="0">
                                  <table class="table table-condensed table-hover">
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
                                        <td class="br-0">
                                        <input type="hidden" id="no_of_days" name="no_of_days" />
                                        <span id="checkout_no_of_days"></span> Days</td>
                                        <td class="text-left br-0 bl-0">
                                          <span id="checkout_meal_name" ></span>
                                        </td>
                                        <td class="text-right br-0 bl-0">
                                          <span id="checkout_meal_type_name"></span>
                                          
                                        </td>
                                        <td class="text-right bl-0">
                                          <span id="checkout_sale_price"></span>
                                        </td>
                                      </tr>                                       
                                   </tbody>                                                                        
                                      <tr>
                                        <th colspan="3" class="text-right br-0" style="border-bottom: 0px;">
                                        GST 5%</th>
                                        <th class="text-right bl-0" style="border-bottom: 0px;">
                                        <span id="checkout_gst_price"></span> 
                                        <input type="hidden" id="gst_price" name="gst_price" /> 
                                        </th>
                                      </tr>
                                      <tr>
                                        <td colspan="3" class="text-right br-0" style="border-top: 0px;font-weight: 600;color: #1c2a39;">Total</td>
                                        <td class="text-right bl-0" style="border-top: 0px;font-weight: 600;color: #1c2a39;"><span id="checkout_total_amount"></span> </td>
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
                  <button class="btn btn-success pb-1 pt-1 pull-right" type="button" id="btnSubmit">
                    <i class="fa fa-hand-o-right" aria-hidden="true"></i> &nbsp;  Finish 
                  </button>
                </div>
              </div>
              <!-- @END: Checkout tab -->
            </form>
          </div>
        </div>
        </div>
      </div>   
    </div>
  </div>
</section>

<div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Terms & Conditions</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <section id="contact" class="mt-4 bg-default section section-xl text-md-left">
      <div class="container">
       <div class="Term-Condition-page">
         <p>
           Please read the below terms and conditions related to the use of our website vigilantly. By creating an official account on our website with a valid username/email-id and confidential password, you become a registered user of the website and by doing so you accept to be legally bound to and adhere to the terms and conditions mentioned on this page. Registering yourself as an official user also mandates that the below terms and conditions are equivalent to a written agreement with the website. Non-compliance to the terms and conditions, may amount to termination of your account and/or access to the website. By not adhering to the website terms and conditions, you agree that the website hold authority to delete/deactivate all your information on our website. You also agree that any form of such termination may be put to effect by the website without any prior notice.
         </p>
         <div class="heading">
           <h3>Communication</h3>
           <p>By signing up on Nutridock, you agree to communicate with the team over phone calls, SMS and emails with Nutridock. You are, however, provided with the option of not receiving emails by opting out while signing up. Alternatively, you can contact us through email at <a href="#"> customercare@nutridock.com </a>  </p>
         </div>

         <div class="heading">
           <h3>Private Communication</h3>
           <p>Although protecting user privacy is one of our top priorities, we may have to disclose your personally identifiable information to third parties, under certain circumstances. For example, as a liability or obligation we may have to disclose information to the government or third parties law officials and private entitles, which we believe is appropriate. Although, we assure to carry out thorough investigation before disclosing any of your personally identifiable information to third party</a>  </p>
         </div>

         <div class="heading">
           <h3>Communication to other sites</h3>
           <p>In case you willingly provide any personal information to third parties who offer services to us or to any other websites, you encounter on the Internet (even if these websites are branded with our branding), different rules, terms and conditions apply to use of their services or to any disclosure of your personal information to them. <br/> We suggest you to investigate the policies and terms and clear all your queries before disclosing information to third parties. </p>
         </div>

         <div class="heading">
           <h3>Privacy Policy</h3>
           <p>At Nutridock, we prioritize users’ privacy policy. That’s why our privacy policy ensures that our users’ information is always protected while using our services.</p>
         </div>

         <div class="heading">
           <h3>General</h3>
           <p>We offer our users diverse ways to connect with the Nutridock, without obtaining their personally identifiable information, in most cases. In cases, where we do collect personally identifiable information from users, we provide them with the choice revealing the information to us or securing it. Users may encounter this choice of voluntarily submitting their personal information while filling out the registration page, sharing with us their valuable feedback, or posting comments and information in our chat rooms or message boards. </p>
         </div>

         <div class="heading">
           <h3>As per our terms, users’ personally identifiable information includes,</h3>
           <p>
             <ul>
               <li>Name</li>
               <li>Email address</li>
               <li>Contact number</li>
               <li>Birth date</li>
             </ul>
           </p>
         </div>

          <div class="heading">
           <h3>Other information pertaining to our services includes</h3>
           <p>
             <ul>
               <li>Age</li>
               <li>Gender</li>
               <li>Weight</li>
               <li>Height</li>
               <li>Physical Activity</li>
               <li>Avoid/Dislike food</li>
               <li>Any lifestyle diseases</li>
               <li>Any special instruction</li>
               <li>Residential address and Pin code</li>
             </ul>
           </p>
         </div>

         <div class="heading">
           <h3>Personal information pertaining to accounting and monetary</h3>
           <p>We assure not to disclose any of your personal information unless you authorize us to do so or to protect the rights or property of Nutridock. We accumulate statistics such as page views for the most popular features on our website in the form of an aggregation or on a collective basis. Under certain circumstances, such as complaints, we may receive personally identifiable information about you from other parties or from other users or third parties who may communicate information to us about you with regards to that complaint. We use third party integrated software which uses and applies their own terms. Kindly go through their T&C for any further clarification.  </p>
         </div>

         <div class="heading">
           <h3>Policy for processing information we collect</h3>
           <p>When you sign up for our services, we initially request for your personally identifiable information. This information is used to develop a personalised program for you. Once you register yourself on Nutridock, you will be asked for your non-personally identifiable information. Under the website policy, non-personally identifiable information includes Demographic information include age Information pertaining to health information</p>
         </div>

         <div class="heading">
           <h3>Policy for usage and disclosure of personal information</h3>
           <p>We assure to not disclose your personal information to mass marketers. Your information will be used on a collective basis to distribute email communications and operate the website. We may also use this data to enhance your on-site experience by displaying content that we believe may matter to you. We may disclose information about our site to third parties for purposes of analysing our website traffic and optimising how we lay out content on the website. <br/> 
            We may have to share your personal information provided to us online or at our centre with companies such as printers, mail houses, and list management companies under contracts with Nutridock. This may be done to inform you about products or special offers to which you may be entitled. All companies with which we have a contract have agreed to be bound to these Privacy Policy restraints and we assure not to sell, rent or otherwise share your personal information elsewhere.
           </p>
         </div>

         <div class="heading">
           <h3>Policy for storage of Cookies</h3>
           <p>Cookies are packets of information stored on your hard drive, when you access a website and register on it for the first time. They allow you to store your password without having to constantly re-enter it every time you visit the website. Cookies can also help us reach you with a marketing message that may interest you. They also allow us to better understand how users navigate through our site, which in turn, helps us focus our resources on features that are most popular with the users. You always have the choice to decline storage of cookies if your browser permits, but some parts of our site may not work properly if you do so.</p>
           <p>Please note that our privacy policy does not authenticate cookies installed by advertisers and other third parties when you click on them. Installation of such cookies is governed by separate policies, independent of policy for our website. We do not govern the use by such third party websites or providers of third party advertising, and we shall not be liable to you as a result of your linking to third party websites.</p>
           <p>
             Security policy We comply to industry standards in order to safeguard confidentiality of your personal identifiable information. We have incorporated firewalls and Secure Socket Layers wherever appropriate in order to secure user data. However, “perfect security” does not exist on the Internet. Nutridock suggests you to learn as much as you can about your privacy on the Internet. Our employees who have the access to your information for performing website specific task or functions adhere to our Privacy Policy while doing so. They constantly update themselves about security practices for immediate application.
           </p>
           <p>
             We execute written agreements with our employees to protect private and confidential information of the users. Violation of the agreement by employees is met with disciplinary action. Notwithstanding the foregoing, we do not guarantee the security of member account information. Unauthorized entry or use, hardware or software failure, and other factors may compromise the security of member information at any time. Although, we take all necessary measures and strive hard to protect your information, we do not ensure the security and privacy of any information you share with us. For additional information about the security measures we use on Nutridock, please contact us using our customer care E-mail ID. 
           </p>
         </div>
         <div class="heading">
           <h3>Website changes and updates</h3>
           <p>In circumstances where we change or make amendments to our privacy policy, a written notice of modifications will not be posted on the website. Alternatively, the information will be passed on through our monthly email newsletter if subscribed to. If users wish to continue with the website despite a policy change, it implies that the user agrees to comply with the amended policy</p>
         </div>
         <div class="heading">
           <h3>Policy for use of Chat Rooms, Message Boards, Blogs, Groups</h3>
           <p>Nutridock offers diverse platforms for users to communicate with our team in a number of ways including what’s app and e-mail. <br/>
            Note that our Privacy Policy does not protect information willingly shared by users on open groups. These are public services and users must be aware that any information shared in a public type forum is seen by third parties and may be even collected and stored by them or collected. We suggest you to be cautious about the information you divulge and the user name you choose. As per the policy, users do not hold Nutridock liable for personal injury or emotional distress caused as a result of divulgence personal information, such as real names and addresses, to other members into such groups.
           </p>
         </div>
         <div class="heading">
           <h3>Policy for sharing information with third party</h3>
           <p>Note that you may be required to provide information to third parties given an opportunity of purchasing or obtaining certain products or services from our website but not offered directly by us. Users will be notified about opening such links in another browser or about leaving our website before divulging into utilization of services offered by third party. <br/>We suggest that prior to sharing your personal information with such a third party user, you should have a glimpse at the website’s Privacy Policy and terms and conditions of use. We do not otherwise share or disclose your personally identifiable information to third party providers. </p>
         </div>
         <div class="heading">
           <h3>Policy for Sharing and Disclosure of Information</h3>
           <p>In situations that compel us to sell, merge or otherwise transfer all or substantially all of our company assets to a third party, or in a situation of liquidation of our business, we completely reserve the right to transfer user information to such third party, although we assure to make reasonable efforts in order to gain the agreement of such third party to our initial Privacy Policy. However, we will notify all users of any such transfer through notice on our site and through email.</p>
         </div>
       </div>
      </div>
    </section>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript" src="{{url('')}}/public/js/form-wizard.js"></script>
<script type="text/javascript" src="{{url('')}}/public/front/js/bootstrap-datepicker.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
$(document).ready(function () {
$('.alert-danger').hide();
$('#start_date').datepicker({ 
  format:'yyyy-mm-dd', 
  startDate: new Date($("#start_date").val()),
});

// $('#mealtype1').change(function(){
//   var getMealTypeData = new Array();
//   $($('input[name=radioMealType]:checked')).each(function () { 
//     getMealTypeData += '<option value="'+this.value+'">'+this.id+'</option>';    
//   }); 
//   $('#mealtype1').html(getMealTypeData);
// });


// $('#mealtype2').change(function(){
//   var getMealTypeData2 = new Array();
//   $($('input[name=radioMealType]:checked')).each(function () { 
//     getMealTypeData2 += '<option value="'+this.value+'">'+this.id+'</option>';    
//   }); 
//   $('#mealtype2').html(getMealTypeData2);
// });

$("#btnSubmit").click(function(){
  $.ajax({
      url: '{{ URL::to('/') }}/checkout_sub',
      type: 'POST',
      dataType: 'json',
      data: $('form#sign-up').serialize(),
      success: function(data) {       
     
        if(data) {
          paySuccess(data['total_amount'],data['subscriber_id']);
        }
        
      }
  }); 
});


function paySuccess(total_amount,subscriber_id)
{
  var totalAmount = total_amount;
  var order_id  = subscriber_id;
  var options = {          
  "key": "rzp_test_l0k2WKd4DEWBUI",
  "amount": (totalAmount*100), // 2000 paise = INR 20
  "name": "Nutridock",
  "description": "Payment",
  "status": "captured",
  "image": "https://nutridock.com/public/front/img/logo.png",
  "handler": function (response){
      $.ajax({
        url: '{{ URL::to('/') }}/pay-success',
        type: 'POST',
        dataType: 'json',
        data: {
        razorpay_payment_id: response.razorpay_payment_id , 
        totalAmount : totalAmount ,order_id : order_id,
        }, 
        success: function (msg) {
          if(msg){
            location.href = '{{ URL::to('/') }}/thankyou'
          } else {
            return false;
          }
           // window.location.href = SITEURL + 'thank-you';
        },
        error: function (data) {
          return false;
        },
      });    
  },
"prefill": {
      "contact": '9975649868',
      "email":   'developer@techrupt.in',
  },
  "theme": {
      "color": "#528FF0"
  }
};
var rzp1 = new Razorpay(options);
rzp1.open();
e.preventDefault();
}

getPlan($('input[type="radio"][name="radioSubscriptionPlan"]:checked').val());

/************* Pop Over tool tip *************/
$('[data-toggle="popover"]').popover();

/************* @START: CODE FOR CHECK VALIDATION ON GOTO NEXT TAB *************/
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
    nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a");
    
  var current = $(this).data('currentBlock'),
      next = $(this).data('nextBlock');

  if (next > current) {
    if(true === $('#sign-up').parsley().validate('step-' + current)) {
      if(current == 1) {
        $.ajax({
            type: "POST",
            url:  "{{ URL::to('/') }}/store_basic_details",
            data: {
                name    : $("#full_name").val(),
                email   : $("#email").val(),
                mobile  : $("#mobile_no").val()
              },
            success: function (data) {
              if(data == 'exist') {
                $('#signup-alert-danger').html('<b>' +$("#mobile_no").val()+ '</b> Mobile number already registered with Nutridock Fit<br /> Please login to your account, or register with another Mobile Number');   
               $('#signup-alert-danger').show();

               window.setTimeout(function() {
                  $("#signup-alert-danger").fadeTo(500, 0).slideUp(500, function(){
                     $(this).remove(); 
                  });
               }, 5000);

                return false;
              } else if(data == 'true'){
                nextStepWizard.removeAttr('disabled').trigger('click');
              } 
            },
            error: function (data) {
              return false;
            },
        });  
      } else {
        // validation is ok. goto next step.
        nextStepWizard.removeAttr('disabled').trigger('click');
      }
    }      
  } 
});


/* script for previous button click */
allPrevBtn.click(function(){
var curStep = $(this).closest(".setup-content"),
    curStepBtn = curStep.attr("id"),
    prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a").trigger('click'); 
});

// dont remove this code
$('div.setup-panel div a.btn-primary').trigger('click');
/************* @END: CODE FOR CHECK VALIDATION ON GOTO NEXT TAB *************/

}); // end $(document)


/************* @START: CODE FOR GET PLAN DETAILS *************/
function getPlan(radioSubscriptionPlanVal) {
    var plan_details_html = ''; 
    if(radioSubscriptionPlanVal) {
          $.ajax({  
              url:"{{ URL::to('/') }}/get_plan_details",  
              method:"POST",  
              data:{plan_id:radioSubscriptionPlanVal},  
              success:function(data){              
                  $.each(data, function(i, val) {
                  if(i == 0) {
                    var checked_duration = "checked";
                  } else {
                    var checked_duration = "";
                  }
                  plan_details_html += '<div class="chk-toolbar pr-2"><input type="radio" id="'+val.duration+'" name="radioDuration" value="'+val.duration_id+'" onchange="getPlanPrice();" required="" data-parsley-errors-container="#duration-errors" data-parsley-error-message="Please select duration" data-parsley-group="step-3" '+ checked_duration +'> <label for="'+val.duration+'">'+val.duration+'</label></div>';      
                                                
                  });                  
                  
                  $("#getPlanDetails").append().html(plan_details_html); 
                  $("#plandetails").show(); 
                  getPlanPrice();
              } 
          });
    } else {
      $('input[type="radio"][name="radioSubscriptionPlan"]').click(function(){ 
     
          $.ajax({  
              url:"{{ URL::to('/') }}/get_plan_details",  
              method:"POST",  
              data:{plan_id:$(this).val()},  
              success:function(data){  
                $.each(data, function(i, val) {
                  plan_details_html += '<div class="chk-toolbar pr-2"><input type="radio" id="'+val.duration+'" name="radioDuration" value="'+val.duration_id+'" onchange="getPlanPrice();" required="" data-parsley-errors-container="#duration-errors" data-parsley-error-message="Please select duration" data-parsley-group="step-3" '+ checked_duration +'> <label for="'+val.duration+'">'+val.duration+'</label></div>';                                   
                });
                    
                $("#getPlanDetails").append().html(plan_details_html); 
                $("#plandetails").show(); 
                getPlanPrice();
              } 
          });  
      }); 
    }
    
} 
/************* @END: CODE FOR GET PLAN DETAILS *************/


$(document).ready(function() {
  var x = new SlimSelect({
    select: '#avoid_food_id'
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

/************* @START: CODE FOR GET PLAN PRICE  *************/
function getPlanPrice()
{   
  var subscription_plan_id = $('input[type="radio"][name="radioSubscriptionPlan"]:checked').val();
  var duration_id = $('input[type="radio"][name="radioDuration"]:checked').val(); 
 
  var selectedMealType = new Array();
  var getMealTypeData = new Array();

  $("#meals input[type=checkbox]:checked").each(function () {
    selectedMealType.push(this.value);
    getMealTypeData.push('<option value='+this.value+'">'+this.id+'</option');
  });

  $('#mealtype1').html(getMealTypeData);
  $('#mealtype2').html(getMealTypeData);

  $("#meal_type").val(selectedMealType); 
  //alert(subscription_plan_id+" meal type: "+selectedMealType+" duration: "+duration_id);
  if((subscription_plan_id != '') && (duration_id != 'undefined') && (selectedMealType != '')) {
   
    $.ajax({
        type: "POST",
        url:  "{{ URL::to('/') }}/get_subscription_plan_price",
        data: {
          subscription_plan_id  : subscription_plan_id,
          duration_id   : duration_id,
          selectedMealTypeLength : selectedMealType.length,
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
  }
}

function getData() {  
  var selectedMealTypeName = new Array();
  var selectedMealTypeVal = new Array();
  var total_price;

  $("#checkout_name").html($("input[name='full_name']").val());
  $("#checkout_phone_no").html($("input[name='mobile_no']").val());
  $("#checkout_email").html($("input[name='email']").val());
  $("#checkout_meal_name").html($('input[name=radioSubscriptionPlan]:checked').attr('id'));
  $("#checkout_no_of_days").html($('input[name=radioDuration]:checked').attr('id'));
  $("#no_of_days").val($('input[name=radioDuration]:checked').attr('id')); 
 
  $($('input[name=radioMealType]:checked')).each(function (i, val) { 
    selectedMealTypeName += (selectedMealTypeName.length > 0 ? ', ' : '') + this.id;
    //selectedMealTypeVal += (selectedMealTypeVal.length > 0 ? ', ' : '') + this.val();
  }); 
 
  $("#checkout_meal_type_name").html(selectedMealTypeName); 
  
  $("#checkout_sale_price").html(formatCurrency($("input[name='salePrice']").val()));
  $("#checkout_gst_price").html(formatCurrency(calculateGST($("input[name='salePrice']").val())));
  $("#gst_price").val(calculateGST($("input[name='salePrice']").val()));
 
  total_price = parseFloat($("input[name='salePrice']").val()) + parseFloat($("input[name='gst_price']").val());
  $("#checkout_total_amount").html(formatCurrency(total_price)); 
}
/************* @END: CODE FOR GET PLAN PRICE  *************/

function showAddress()
{

  var address1 = $('#address1').val();
  var pincode1 = $('#pincode1').val();
  var mealtype1 = $('#mealtype1').val();
  $('#address2').val(address1);
  $('#pincode2').val(pincode1);

}

</script>
@endsection 