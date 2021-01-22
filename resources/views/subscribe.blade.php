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
</style>
@section('content')

<!-- For Datepickr -->
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{{url('')}}/public/front/dist/date-time-picker.min.js"></script>
<section class="mt-5 pb-0 pt-5">
  <div class="">
    <div class="image-container set-full-height pb-5" style="background-image: url('{{url('')}}/uploads/images/1.jpeg');"> 
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
                    <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">
                      <i class="fa fa-truck" aria-hidden="true"></i>
                    </a>
                    <p>Delivery</p>
                </div>
                <div class="stepwizard-step">
                  <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">
                    <i class="fa fa-check" aria-hidden="true"></i>
                  </a>
                  <p>Checkout</p>
              </div>
              </div>
          </div>
          <form role="form" class="w-100">
              <div class="row setup-content" id="step-1">
                  <div class="col-sm-12">
                    <h4 class="info-text"> Let's start with the basic details.</h4>
                  </div>
                  <div class="col-sm-12 mb-3">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="input-group mb-0"> 
                          <div class="label-floating w-100">
                            <label class="control-label">Full Name <span class="text-danger">*</span></label>
                            <div class="input-group mb-3">
                              <div class="input-group-prepend"> <span class="input-group-text"><i class="fa fa-user-circle" aria-hidden="true"></i></span> </div>
                              <input type="text" name="full_name" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Full Name" required="required">
                            </div>
                            <span id="err_full_name" class="text-danger"></span> </div>
                        </div>
                      </div>
                      <div class="col-md-8">
                        <div class="form-group label-floating">
                          <label class="control-label">Email <span class="text-danger">*</span></label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon3" ><i class="fa fa-envelope" aria-hidden="true"></i></span> </div>
                            <input type="email" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Email" name="email" required="required">
                          </div>
                          <span id="err_email" class="text-danger"></span> 
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group label-floating w-100">
                          <label class="control-label">Mobile <span class="text-danger">*</span></label>
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"> <span class="input-group-text" id="basic-addon3"><i class="fa fa-phone" aria-hidden="true"></i></span> </div>
                            <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" placeholder="Mobile" name="phone_no" required="required" minlength="10"  maxlength="10">
                          </div>
                          <span id="err_mobile_no" class="text-danger"></span> 
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
                  <div class="col-xs-12">
                      <div class="col-md-12">
                          <h3> Step 2</h3>
                          <div class="form-group">
                              <label class="control-label">Company Name</label>
                              <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Name" />
                          </div>
                          <div class="form-group">
                              <label class="control-label">Company Address</label>
                              <input maxlength="200" type="text" required="required" class="form-control" placeholder="Enter Company Address"  />
                          </div>
                          
                      </div>
                  </div>
                  <div class="wizgard-footer">
                    <button class="btn btn-secondary pb-1 pt-1 nextBtn pull-right" type="button" >
                      Next &nbsp;<i class="fa fa-angle-right" aria-hidden="true"></i>
                    </button>
                  </div>
              </div>
              <div class="row setup-content" id="step-3">
                  <div class="col-xs-12">
                      <div class="col-md-12">
                          <h3> Step 3</h3>
                          <button class="btn btn-success pull-right" type="submit">Finish!</button>
                      </div>
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
<script>
  $(document).ready(function () {

var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn');

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
        curInputs = curStep.find("input[type='text'],input[type='url']"),
        isValid = true;

    $(".form-group").removeClass("has-error");
    for(var i=0; i<curInputs.length; i++){
        if (!curInputs[i].validity.valid){
            isValid = false;
            $(curInputs[i]).closest(".form-group").addClass("has-error");
        }
    }

    if (isValid)
        nextStepWizard.removeAttr('disabled').trigger('click');
});

$('div.setup-panel div a.btn-primary').trigger('click');
});
</script>
@endsection 