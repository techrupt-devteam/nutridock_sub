<div class="modal-header">
  <h4 class="modal-title"><b>Kitchen Name :</b> {{ucfirst($data['kitchen_name'])}}</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <form action="{{ url('/admin')}}/store_target" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
            {!! csrf_field() !!}
      
              <input type="hidden" name="kitchen_id" value="{{$data['kitchen_id']}}">
       <div class="col-md-12">
           <div class="form-group">
              <label for="name">Month <span style="color:red;" >*</span></label>
                  <div class="input-group">
                    <div class="input-group-addon">Month</div>
              <input type="text" class="form-control" name="month" id="month"  data-parsley-error-message="Please select month" required> 
            </div>
            </div>
        </div>
        <div class="col-md-12">
           <div class="form-group">
              <label for="name">Target Amount <span style="color:red;" >*</span></label>
              <div class="input-group">
                    <div class="input-group-addon">Amount</div>
              <input type="text" class="form-control" name="target_amt" id="target_amt"  data-parsley-error-message="Please select amount" required></div> 
            </div>
        </div>
        <div class="col-md-12"> 
         <button type="submit" class="btn btn-primary">Submit</button>
         <a href="{{url('/admin')}}/manage_kitchen"  class="btn btn-default">Back</a>
        </div>
      </form>
    </div>    
  </div>  
</div>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>
<!-- datepicker -->
<script src="{{url('/admin_css_js')}}/css_and_js/admin/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $("#month").datepicker({ format: "M-yyyy",
    viewMode: "months", 
    minViewMode: "months",
    autoclose: true}).val();
</script>



