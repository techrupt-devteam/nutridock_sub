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
            <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            <a href="{{url('/admin')}}/add_{{$url_slug}}" class="btn btn-primary btn-sm" style="float: right;">Add Cloude Kitchen</a> </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Name</th>
                  <th>State</th>
                  <th>City</th>
                  <th>Area</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              
              @foreach($data as $key=>$value)
              <tr>
                <td>{{$key+1}}</td>
                <td>{{$value->kitchen_name}}</td>
                <td>{{$value->state_name}}</td>
                <td>{{$value->city_name}}</td>
                <td>{{$value->area_name}}</td>
                <td><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->kitchen_id;?>);"><i class="fa fa-info-circle"></i> Kitchen Details</button>
                  <div class="btn-group"> <a href="{{url('/admin')}}/edit_{{$url_slug}}/{{base64_encode($value->kitchen_id)}}"  class="btn btn-primary"  title="Edit"> <i class="fa fa-pencil"></i> </a> <a href="{{url('/admin')}}/delete_{{$url_slug}}/{{base64_encode($value->kitchen_id)}}"   class="btn btn-default "  title="Delete" onclick="return confirm('Are you sure you want to delete this record?');"> <i class="fa fa-trash text-danger"></i> </a> </div></td>
              </tr>
              @endforeach
                </tbody>
              
            </table>
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
 </script> 
@endsection 