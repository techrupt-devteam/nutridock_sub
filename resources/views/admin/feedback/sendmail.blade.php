<div class="modal-header">
  <h4 class="modal-title"><b>Name :</b> {{ucfirst($data['name'])}}</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <form action="{{ url('/admin')}}/send_replay" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
            {!! csrf_field() !!}
       <div class="col-md-12">
        <div class="form-group">
              <label for="name">Mail To<span style="color:red;" >*</span></label>
              <input type="text" class="form-control" name="feedback_mail" id="feedback_mail"  data-parsley-error-message="Please enter mail." value="{{$data['email']}}" required="true">
              <input type="hidden" name="cust_name" value="{{$data['name']}}">
            </div>
       </div> 
       <div class="col-md-12">
           <div class="form-group">
              <label for="name">Reply<span style="color:red;" >*</span></label>
              <textarea class="form-control" name="feedback_replay" id="feedback_replay"  data-parsley-error-message="Please enter the replay ."  rows="3" 
              style="resize: none;" required> </textarea>
            </div>
        </div>
        <div class="col-md-12"> 
         <button type="submit" class="btn btn-primary">Submit</button>
         <a href="{{url('/admin')}}/manage_feedback"  class="btn btn-default">Back</a>
        </div>
      </form>
    </div>    
  </div>  
</div>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>





