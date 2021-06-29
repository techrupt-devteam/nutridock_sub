@extends('admin.layout.master')
 
@section('content') 
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper"> 
  <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12"> @include('admin.layout._status_msg')
        <div class="box">
          <div class="box-header">
          <h3 class="box-title">{{ $page_name." ".$title }} for <strong>{{ucfirst($data[0]->kitchen_name)}}</strong></h3><a href="{{url('/admin')}}/manage_kitchen" class="btn btn-info btn-sm" style="float: right;"><i class="fa fa-arrow-alt-circle-left"></i>Back</a></div>
          <!-- /.box-header -->
          <div class="box-body"><div class="table-responsive">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Month</th>
                  <th>Target Amount</th>
                  <th>Achive Amount</th>
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
                  <div class="btn-group"> <!-- <a href="{{url('/admin')}}/edit_target/{{base64_encode($value->kitchen_id)}}"  class="btn btn-primary btn-sm"  title="Edit"> <i class="fa fa-pencil"></i> </a> --> <a href="{{url('/admin')}}/delete_target/{{base64_encode($value->target_kitchen_id)}}"   class="btn btn-default"  title="Delete" onclick="return confirm('Are you sure you want to delete this record?');"> <i class="fa fa-trash text-danger"></i> </a> </div></td>
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
      <!-- /.col --> 
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper -->
<div class="modal fade static" id="modal-details">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="content"> </div>
    </div>
  </div>
</div>
<div class="modal fade static" id="modal-add" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="content-add"> </div>
    </div>
  </div>
</div>

<div class="modal fade static" id="modal-target-list" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="content-targetlist"> </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script type="text/javascript">


    function viewDetails(kitchen_id) 
    { 

      var kit_id = kitchen_id;
      //alert(status);
       $.ajax({
            url: "{{url('/admin')}}/kitchen_details",
            type: 'post',
            data: {kitchen_id:kit_id},
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }

    function addtarget(kitchen_id) 
    { 
      //alert(status);
      $.ajax({
            url: "{{url('/admin')}}/kitchen_target",
            type: 'post',
            data: {id:kitchen_id},
            success: function (data) 
            {
              $('#content-add').html(data);
            }
      });
    } 
    function viewtarget(kitchen_id) 
    { 
      //alert(status);
      $.ajax({
            url: "{{url('/admin')}}/view_target",
            type: 'post',
            data: {id:kitchen_id},
            success: function (data) 
            {
              $('#content-targetlist').html(data);
            }
      });
    }
 </script> 
@endsection 