@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Manage {{ $title }}</a></li>
        {{-- <li class="active">{{ $page_name." ".$title }}</li> --}}
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $page_name." ".$title }}
                {{--  <small>advanced tables</small> --}}</h3>
              <a href="{{url('/admin')}}/add_role" class="btn btn-primary btn-sm" style="float: right;">Add Role</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$value['role_name']}}</td>
                      <td>
                        @if($value['is_active']==1)
                           @php $checked="checked"; $style="success"; @endphp 
                        @else
                           @php $checked=""; $style="danger";@endphp 
                        @endif
                        <input type="checkbox" {{$checked}} data-toggle="toggle" data-onstyle="success" title="status" onchange="change_Status(<?php echo $key+1; ?>,<?php echo $value['role_id']; ?>);" data-offstyle="danger" id="{{$key+1}}_is_active" data-size="small" data-style="slow" >
                        <a href="{{url('/admin')}}/edit_{{$url_slug}}/{{$value['role_id']}}"  class="btn btn-primary btn-sm"  title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                       
                        <!-- <a href="{{url('/admin')}}/delete_{{$url_slug}}/{{$value['role_id']}}"   class="btn btn-default btn-sm"  title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a> -->
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
 <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  
 <script type="text/javascript">
   function change_Status(id,role_id) 
    {  
      
      swal({
        title: "Role status",
        text: "Are You sure to change role status",
        icon: "warning",
          buttons: [
            'Cancel',
            'Yes, change it!'
          ],
         
        }).then(function(isConfirm) {
          if (isConfirm) 
          { 
            
            var status = $("#"+id+"_is_active").prop('checked');
            var roleids = role_id;
            //alert(status);
             $.ajax({
                  url: "{{url('/admin')}}/status_role",
                  type: 'post',
                  data: {status:status,role_id:roleids},
                  success: function (data) 
                  {
                    if(data==1){
                       swal("Success", "Role status successfully changed !", "success");
                   }else{

                      swal("Warning", "Error! Role can not off. beacause role assign user.", "error");
                      var className = $("#"+id+"_is_active").closest('div').prop('className');
                      if(className == "toggle btn btn-sm slow btn-danger off")
                      {
                        $("#"+id+"_is_active").closest('div').removeClass(className);
                        $("#"+id+"_is_active").closest('div').addClass('toggle btn btn-success btn-sm slow');
                      }
                      else
                      {
                        $("#"+id+"_is_active").closest('div').removeClass(className);
                        $("#"+id+"_is_active").closest('div').addClass('toggle btn btn-sm slow btn-danger off');
                      }

                    }
                  }
              });
                
          } else {
               
            var className = $("#"+id+"_is_active").closest('div').prop('className');
           
            if(className == "toggle btn btn-sm slow btn-danger off"){
               $("#"+id+"_is_active").closest('div').removeClass(className);
               $("#"+id+"_is_active").closest('div').addClass('toggle btn btn-success btn-sm slow');
            }else{
              $("#"+id+"_is_active").closest('div').removeClass(className);
               $("#"+id+"_is_active").closest('div').addClass('toggle btn btn-sm slow btn-danger off');
            }
          }
        });


     }
 </script>
@endsection