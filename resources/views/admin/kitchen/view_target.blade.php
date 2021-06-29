  <div class="modal-header">
  <h4 class="modal-title">Target Details</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body"> 


    <div class="row">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Kitchen Name : {{ucfirst($data[0]->kitchen_name)}}</h3>
            <div class="box-body"><div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Month</th>
                  <th>Target</th>
                  <th>Achivement</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

              @foreach($data as $key=>$value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->month}}</td>
                <td>{{$value->target_amt}}</td>
                <td>{{$value->achive_amt}}</td>
                <td>
                </td>
              </tr>
              @endforeach
                </tbody>
              
            </table>
          </div>
          </div>
          <!-- /.box-body --> 
        </div>
        <!-- /.box --> 
      </div>
      </div>
    </div>