
     <div class="modal-header">
    
        <h5 class="modal-title">Update Health Details : {{ucfirst($health_details->subscriber_name)}}</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <div class="modal-body">
             
     
            <form action="{{ url('/')}}/update-health-store" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
            
              <div class="row">  
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">BMI<span style="color:red;" >*</span></label>
                        <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text">BMI</span>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter BMI" id="bmi" name="bmi" required="true" data-parsley-errors-container="#bmi_error" data-parsley-error-message="Please enter bmi." value="{{ isset($health_details) ? ($health_details->bmi) : ('') }}">
                            <input type="hidden" name="subcriber_id" value="{{$health_details->subcriber_id}}">
                            <input type="hidden" name="subscriber_health_id" value="{{$health_details->subscriber_health_id}}">
                            <input type="hidden" name="nutritionist_id" value="{{$health_details->nutritionist_id}}">
                          </div>
                          <div id="bmi_error" style="color:red;"></div>
                      </div>
                    </div>
                          
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">BMR<span style="color:red;" >*</span></label>
                         <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text">
                            BMR</span>
                          </div>
                          <input type="text" class="form-control" placeholder="Enter BMR" id="bmr" name="bmr" required="true" data-parsley-errors-container="#bmr_error" data-parsley-error-message="Please enter bmr." value="{{ isset($health_details) ? ($health_details->bmr) : ('') }}">
                        </div>
                        <div id="bmr_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="">Current Weight<span style="color:red;" >*</span></label>
                        <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text">
                            <i class="fa fa-balance-scale"></i></span>
                          </div>
                          <input type="text" class="form-control" placeholder="Enter Current Weight" id="current_wt" name="current_wt" required="true" data-parsley-errors-container="#weight_error" data-parsley-error-message="Please enter weight." value="{{ isset($health_details) ? ($health_details->current_wt) : ('') }}">
                        </div>
                        <div id="weight_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
              </div>
              <hr/>
              <div class="row">  
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Body Fat<span style="color:red;" >*</span></label>
                     <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text">
                            <img  src="{{ url('/')}}/uploads/images/fat.png" alt="your image" width="20" height="20"/></span>
                          </div>
                          <input type="text" class="form-control" placeholder="Enter Body Fats" id="body_fat" name="body_fat" required="true" data-parsley-errors-container="#fats_error" data-parsley-error-message="Please enter body fats." value="{{ isset($health_details) ? ($health_details->body_fat) : ('') }}">
                        </div>
                        <div id="fats_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Req.Calories<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text"><img  src="{{ url('/')}}/uploads/images/calories.svg" alt="your image" width="20" height="20"/></span></div>
                        <input type="text" class="form-control" placeholder="Enter required calories" id="req_calories" name="req_calories" required="true" data-parsley-errors-container="#calories_error" data-parsley-error-message="Please enter calories." value="{{ isset($health_details) ? ($health_details->req_calories) : ('') }}"></div>
                       <div id="calories_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Protine<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text"> <img  src="{{ url('/')}}/uploads/images/protein.svg" alt="your image" width="20" height="20"/></span></div>
                        <input type="text" class="form-control" placeholder="Enter required protein" id="protein" name="protein" required="true" data-parsley-errors-container="#protein_error" data-parsley-error-message="Please enter protein." value="{{ isset($health_details) ? ($health_details->protein) : ('') }}"></div>
                       <div id="protein_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="row">  
                
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">fat<span style="color:red;" >*</span></label>
                     <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text"><img  src="{{ url('/')}}/uploads/images/fat.png" alt="your image" width="20" height="20"/></span></div>
                        <input type="text" class="form-control" placeholder="Enter required fat" id="fat" name="fat" required="true" data-parsley-errors-container="#fts_error" data-parsley-error-message="Please enter fat." value="{{ isset($health_details) ? ($health_details->fat) : ('') }}"></div>
                       <div id="fts_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Fiber<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fab fa-pagelines"></i></span></div>
                        <input type="text" class="form-control" placeholder="Enter required fiber" id="fiber" name="fiber" required="true" data-parsley-errors-container="#Fiber_error" data-parsley-error-message="Please enter fiber." value="{{ isset($health_details) ? ($health_details->fiber) : ('') }}"></div>
                       <div id="Fiber_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="">Carbohydrates<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        
                          <div class="input-group-prepend">
                                <span class="input-group-text"><img  src="{{ url('/')}}/uploads/images/carbohydrates.svg" alt="your image" width="20" height="20"/></span></div>
                        <input type="text" class="form-control" placeholder="Enter required carbohydrates" id="carbs" name="carbs" required="true" data-parsley-errors-container="#carbs_error" data-parsley-error-message="Please enter carbohydrates." value="{{ isset($health_details) ? ($health_details->carbs) : ('') }}"></div>
                       <div id="carbs_error" style="color:red;"></div>
                    </div>
                  </div>
                </div>
              </div>

               
                    <div class="modal-footer pull-left">
                      <button type="submit" class="btn btn-success btn-sm">Update</button>
                      <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    </div>
              </div>
            </form>
        </div>


<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>
<script type="text/javascript" src="{{url('')}}/public/front/js/bootstrap-datepicker.min.js"></script>
<link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
<script>
$(document).ready(function () {
$('#compensation_date').datepicker({ 
  format:'yyyy-mm-dd', 
  changeMonth: true,
  autoclose: true,
  startDate: new Date($('#start_date').val()),
  endDate:  $('#end_date').val(),
});
})
</script>
<style>
label{
    font-size: 13px !important;
    font-weight: 900  !important;
}
.parsley-custom-error-message{
  font-size: 13px !important;
}
input{
  font-size: 14px !important;
}
.input-group-text{
      font-size: 11px !important;
    font-weight: bold !important;
    font-variant: common-ligatures !important;
}
</style>

