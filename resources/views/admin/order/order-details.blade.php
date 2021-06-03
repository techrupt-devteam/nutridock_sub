<div class="modal-header">
  <h3 class="modal-title">Customer Name : {{ ucfirst($data->subscriber_name)}} <span class="float-right">Bill Date : {{ date('d-m-Y',strtotime($data->bill_date)) }} </span></h3>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="row">
    <div class="col-md-12 col-lg-12">
      <div class="table-responsive">
      <table class="table table-bordered table">
        <tr>
          <th>Order Status</th>
          <td>@if($data->order_status=='y')<span style="color:green !important;"><b>Order Push <small>(processing)</small></b></span>@else<span style="color:red !important;"><b>Order Pending <small>(Failed)</small></b></span>@endif</td>
        </tr> 
        <tr>
          <th>Posist Order No</th>
          <td>{{ $data->order_no }}</td>
        </tr>
        <tr>
          <th>Posist Bill No</th>
          <td>{{ $data->bill_no }}</td>
        </tr>
         <tr>
          <th>Posist Bill Id</th>
          <td>{{$data->bill_id}}</td>
        </tr>
        <tr>
          <th>Menu Title</th>
          <td>{{$data->menu_title}}</td>
        </tr>
        <tr>
          <th>Posist Menu Item Id</th>
          <td>{{$data->item_id}}</td>
        </tr>
        <tr>
          <th>Kitchen Name</th>
          <td>{{$data->kitchen_name}}</td>
        </tr>  <tr>
          <th>Customer Key</th>
          <td>{{$data->customer_key}}</td>
        </tr>      
      </table>
    </div>
  </div>
  </div>  
</div>





