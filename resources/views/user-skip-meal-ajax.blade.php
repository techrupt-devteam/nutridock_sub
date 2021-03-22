
     <div class="modal-header">
    
        <h5 class="modal-title">Day {{ $program_data->day }} Menu Skip</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <div class="modal-body">
             
     
            <form action="{{ url('/')}}/store_skip_menu" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
               
              <div class="row">
                <div class="col-md-12">   
                  <div class="form-group">
                     <label class="d-block">Compensation Date<span style="color:red;" >*</span></label>
                      <div class="input-group">
                        
                          <div class="input-group-prepend">

                              <span class="input-group-text"><img  src="{{ url('/')}}/uploads/images/calendar.svg" alt="your image" width="20" height="20"/></span>
                          </div>
                          <input  type="textbox" class="form-control" name="compensation_date" id="compensation_date" required="true" data-parsley-errors-container="#date_error" data-parsley-error-message="Please enter compensation date." autocomplete="off" readonly="">
                          <input type="hidden" name="start_date" id="start_date" value="{{$expiry_date}}">
                          <input type="hidden" name="end_date" id="end_date" value="{{date('Y-m-d',strtotime($expiry_date .'+10day'))}}">
                          <input type="hidden" name="program_id" id="program_id" value="{{$program_id}}">
                          <input type="hidden" name="subscriber_dtl_id" id="subscriber_dtl_id" value="{{$subscriber_dtl_id}}">
                      </div>
                       <div id="date_error" style="color:red;"></div>
                  </div>            
                </div>
                <div class="col-md-12">
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
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
  td.day {
    font-family: 'Poppins' !important;
    font-size: 16px !important;
    font-style: normal !important;
    font-weight: 600 !important;
}
.datepicker table tr td.active.active, .datepicker table tr td.active.highlighted.active, .datepicker table tr td.active.highlighted:active, .datepicker table tr td.active:active {
    color: #fff  !important;
    background-color: #8bc34a !important;
    border-color: #8bc34a !important;
}
</style>

