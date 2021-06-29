@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> {{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Area</th>
                    <th>Feedback</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->mobile_no}}</td>
                    <td>{{$value->city_name}}</td>
                    <td>{{$value->area_name}}</td>
                    <td class="text-center">
                     <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->feedback_id;?>);"><i class="fa fa-info-circle"></i> Feedback Details</button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-details-send" onclick="send(<?php echo $value->feedback_id;?>);"><i class="fa fa-paper-plane"></i>  Reply </button>
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

<div class="modal fade static" id="modal-details-send">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="content-repaly"> </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script type="text/javascript">


    function viewDetails(feedback_id) 
    { 

      var feedback_id = feedback_id;
      //alert(status);
       $.ajax({
            url: "{{url('/admin')}}/feedback_details",
            type: 'post',
            data: {id:feedback_id},
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }

    function send(feedback_id) 
    { 

      var feedback_id = feedback_id;
      //alert(status);
       $.ajax({
            url: "{{url('/admin')}}/feedback_replay",
            type: 'post',
            data: {id:feedback_id},
            success: function (data) 
            {
              $('#content-repaly').html(data);
            }
        });
    }
 </script> 
@endsection