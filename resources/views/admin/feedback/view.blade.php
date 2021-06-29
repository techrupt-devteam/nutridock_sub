<div class="modal-header">
  <h4 class="modal-title"><b>Name :</b> {{ucfirst($data['name'])}}</h4>
  <h5 class="modal-title"><b>Email :</b> {{ucfirst($data['email'])}}</h5>
  <h5 class="modal-title"><b>Mobile No :</b> {{ucfirst($data['mobile_no'])}}</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12">
      <p>{{$data['feedback']}}</p>
    </div>    
  </div>  
</div>





