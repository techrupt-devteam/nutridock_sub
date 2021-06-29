
     <div class="modal-header">
    
        <h3 class="modal-title">Set Additional Meal </small></h3>
       

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            @if($sdays==0)
            <div class="row">
            <div class="col-md-12">
              <div class="alert alert-warning col-md-12 mt-4 text-left" style="margin-top: 13px;color:#000000!important;background-color: #f39c1229 !important;">
                  <strong ><i class="glyphicon glyphicon-warning"></i> Note!</strong>
                   <strong>Default Meal Program </strong> not set Nutritionist please contact assign <strong>Nutritionist.</strong>
              </div>
            </div>
          </div>
            @else

            <form action="{{url('/')}}/admin/store_additional_menu1" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" method="post" id="frmChangeMenu">
              {!! csrf_field() !!}
              
              <div class="row">
                <div class="col-md-6">
                </div>
              </div>
                <div class="row" >                
                      <input type="hidden" name="subscriber_dtl_id" value="{{$subscriber_dtl_id}}">
                      <input type="hidden" name="subscriber_start_date" value="{{$subscriber_start_date}}">
                      <input type="hidden" name="subscriber_expiry_date" value="{{$subscriber_expiry_date}}">
                  <div class="col-md-6">
                      <div class="form-group"><?php //dd($days);?>
                        <label class="d-block">Select Day<span style="color:red;" >*</span></label>
                        <select name="day" id="day" class="form-control" required="required" data-parsley-errors-container="#day_error" data-parsley-error-message="Please select day">
                        <option value="">Select Days</option>

                         @foreach($days as $key => $daysvalue)
                         <option value="{{$days[$key]->day.'#'.$days[$key]->meal_on_date}}">{{$days[$key]->day}} Day </option>
                         @endforeach  
                        </select>
                        <div id="day_error" style="color:red;"></div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group"> 
                     
                      <label  class="d-block">Meal Type
                      <span style="color:red;">*</span>
                      </label>
                       <select name="meal_type" id="meal_type" class="form-control" required="true" data-parsley-errors-container="#meal_type_error" data-parsley-error-message="Please select meal type">
                         <option value="">Select Meal Type</option>
                         @foreach($meal_type as $key => $meal_type_value)
                         <option value="{{$meal_type_value->meal_type_id}}">{{ucfirst($meal_type_value->meal_type_name)}}</option>
                         @endforeach  
                        </select>  
                       <div id="meal_type_error" style="color:red;"></div>
                    </div>
                </div>
                </div>
                <div class="row">     
                <div class="col-md-6">               
                    <div class="form-group">
                      <label class="d-block">Additional Menu<span style="color:red;" >*</span></label>
                       <select name="menu_id" id="menu_id" class="form-control" required="true" data-parsley-errors-container="#menu_error" data-parsley-error-message="Please select menu" onchange="get_menu_macros();">
                         <option value="">Select Menu</option>
                         @foreach($aditional_menu as $admenuvalue)
                         <option value="{{$admenuvalue->id}}">{{$admenuvalue->menu_title}}</option>
                         @endforeach
                        </select>  
                       <div id="menu_error" style="color:red;"></div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <label class="d-block">Macros</label>
                     <table class="table table-sm" id="det_table" style="font-size: 13px; color:#000">
                      
                     </table>
                 </div>
              </div>
              </div>
              <div class="modal-footer">
             <!-- <button type="submit" class="btn btn-success">Submit</button>  -->
               <button type="button" class="btn btn-success" onclick="changeMenu()">Submit</button> 
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
            @endif
        </div>


<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>
<!-- <style type="text/css">
  select#day {
    height: 35px !important;
  }
  select#meal_type {
    height: 35px !important;
  }
  select#menu_id {
    height: 35px !important;
  }
</style> -->
<script type="text/javascript">



 

  function get_menu_macros()
  {
      var menu_id =  $('#menu_id').val();
      $.ajax({
          url: "{{url('/')}}/admin/get_menu_macros1",
          type: 'post',
          data: { menu_id:menu_id},
          success: function (data) {
            $('#det_table').html(data);
            $('.dtlrow').show();
          }
       });
  }

  function get_menu_macros1()
  {
      var menu_id =  $('#old_menu_id').val();
      $.ajax({
          url: "{{url('/')}}/admin/get_menu_macros1",
          type: 'post',
          data: { menu_id:menu_id},
          success: function (data) 
          {
            $('#det_table').html(data);
            $('.dtlrow').show();
          }
       });
  }

  function changeMenu()
  {
   
    if($('#frmChangeMenu').parsley().validate())
    {
      $.ajax({
          url: "{{url('/')}}/admin/store_additional_menu1",
          type: 'post',
          data: $("#frmChangeMenu").serialize(),
          success: function (data) 
          {
           
           
            
            toastr.options =
            {
            "closeButton" : true,
            "progressBar" : true
            }

            if(data =="success"){
              //$('#modal-additional-meal').modal('hide');
              //$('.modal-backdrop').removeClass('in');
              location.reload();
  	      	 toastr.success("Your additional meal has been set successfully!");
            } else if(data =="error"){
              toastr.error("Error! while set additional meal, please contact to Nutridock Fit Customer Care.");
            
            }
          }
       });
    }
  }

</script>
