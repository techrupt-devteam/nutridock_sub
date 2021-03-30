    <div class="modal-header"  style="justify-content: start;">
        <h3 class="modal-title"><small> Subscriber Details : </small> {{ucfirst($data->subscriber_name)}}</h3>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <div class="modal-body">
          <form autocomplete="off" action="{{ url('/')}}/update-address" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="row">
              <div class="col-md-12">
                   <div class="alert alert-danger alert_msg alert1" id="error_msg" style="display: none !important">
                   <p id="text_msg"></p>
                  </div>
              </div>
            </div>
            <div class="row">  
                 <div class="col-md-8 mb-3">
                  <label>Home Address</label>
                  <textarea class="form-control" name="address1" required="true" data-parsley-errors-container="#address1_error" data-parsley-error-message="Please enter address">{{$data->address1}}</textarea>
                 <div id="address1_error" style="color:red;"></div>
                 </div>
                 <div class="col-md-4 mb-3">
                  <label>Pincode</label>
                  <input type="text" name="pincode1" id="pincode1" class="form-control" value="{{$data->pincode1}}" required="true" data-parsley-errors-container="#pincode1_error" data-parsley-error-message="Please enter pincode." autocomplete="nope" maxlength="6">
                  <input type="hidden" name="id" value="{{$data->subscriber_id}}">
                 <div id="pincode1_error" style="color:red;"></div>
                 <div id="pincode1_er"></div>
                 </div>     
            </div>
            <div class="row">  
                 <div class="col-md-8">
                  <label>Other Address</label>
                  <textarea class="form-control" name="address2" required="true" data-parsley-errors-container="#address2_error" data-parsley-error-message="Please enter address.">{{$data->address2}}</textarea>
                   <div id="address2_error" style="color:red;"></div>
                 </div>
                 <div class="col-md-4">
                  <label>Pincode </label>
                  <input type="text" name="pincode2" id="pincode2" class="form-control" value="{{$data->pincode2}}" required="true" data-parsley-errors-container="#pincode2_error" data-parsley-error-message="Please enter pincode."  onckeyup="check_delivery(2);" autocomplete="nope" maxlength="6">
                  <div id="pincode2_error" style="color:red;"></div>
                  <div id="pincode2_er"></div>
                 </div>
            </div>
          <div class="modal-footer mt-4 pb-0">
            <button type="submit" class="btn btn-primary">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
          </form>
      </div>

<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>

<script>
$(document).ready(function () {

$('#pincode1').on("input", function() {

  if(this.value.length == this.getAttribute('maxlength')) {
    $.ajax({
          url: "{{url('')}}/chk_pincode",
          type: 'post',
          data: {pincode :this.value},
          success: function (data) 
          { 
          
             //$('#error_msg').show();
             $('#pincode1_er').html(data);  
             
             //$("#pincode1_error").fadeOut(10000);
          
          }
      });
  }
});

$('#pincode2').on("input", function() {
  
  if(this.value.length == this.getAttribute('maxlength')) {
     $.ajax({
        url: "{{url('')}}/chk_pincode",
        type: 'post',
        data: {pincode :this.value },
        success: function (data) 
        { 
          
           //$('#error_msg').show;  
           $('#pincode2_er').html(data);  
           //$("#pincode2_error").fadeOut(10000);

         
          
        }
    });
  }
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

