@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Manage {{ $title }}</a></li>
        {{-- <li class="active">{{ $page_name." ".$title }}</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><!-- {{ $page_name." ".$title }} --></h3>
              <a href="{{url('/admin')}}/add_{{$url_slug}}" class="btn btn-primary btn-sm" style="float: right;">Add Assign Location Menu</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>state</th>
                  <th>City</th>
                  <th>Area</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
              
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{ucfirst($value->state_name)}}</td>
                      <td>{{ucfirst($value->city_name)}}</td>
                      <td>{{ucfirst($value->area_name)}}</td>
                      <td>
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->assign_menu_id;?>);">
                           <i class="fa fa-info-circle"></i> View Menu</button>
                        @if($value->is_active=='1')
                           @php $checked="checked"; $style="success"; @endphp 
                        @else
                           @php $checked=""; $style="danger";@endphp 
                        @endif
                        <input type="checkbox" {{$checked}} data-toggle="toggle" data-onstyle="success" title="status" onchange="change_Status(<?php echo $key+1; ?>,<?php echo $value->assign_menu_id; ?>);" data-offstyle="danger" id="{{$key+1}}_is_active" data-size="small" data-style="slow" >
                        <a href="{{url('/admin')}}/edit_{{$url_slug}}/{{base64_encode($value->assign_menu_id)}}" class="btn btn-sm btn-primary" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{url('/admin')}}/delete_{{$url_slug}}/{{base64_encode($value->assign_menu_id)}}"  class="btn btn-sm btn-default" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a>
                      </td>
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
  <div class="modal fade" id="modal-details" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div id="content">
          
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
 <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
<script type="text/javascript">
    function change_Status(id,plan_id) 
    {  
        swal({
          title: "Assign Menu status",
          text:  "Are You sure to change status",
          icon:  "warning",
          dangerMode: true,
          }).then(function(isConfirm) {
          if (isConfirm) { 
          var status = $("#"+id+"_is_active").prop('checked');
          var plan_ids = plan_id;
          //alert(status);
           $.ajax({
                url: "{{url('/admin')}}/status_assign_menu",
                type: 'post',
                data: {status:status,plan_ids:plan_id},
                success: function (data) 
                {
                  swal("Success", "Assign location menu status successfully changed !", "success");
                }
            });
          }
        });
     }

    function viewDetails(assign_menu_id) 
    { 
      var assign_menu_id = assign_menu_id;
      //alert(status);
       $.ajax({
            url: "{{url('/admin')}}/assign_menu_details",
            type: 'post',
            data: {assign_menu_id:assign_menu_id},
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }

    $('#modal-details').modal({backdrop: 'static', keyboard: false})  
</script>
@endsection