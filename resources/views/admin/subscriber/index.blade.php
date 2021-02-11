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
              <a href="{{url('/admin')}}/add_{{$url_slug}}" class="btn btn-primary btn-sm" style="float: right;">Add Assign Nutritionist</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <?php // dd($data); ?>  <input type="checkbox" data-toggle="toggle" data-onstyle="success" title="status"  data-offstyle="danger" id="_is_active" data-size="small" data-style="slow" >
              <table class="table table-bordered" id="example1">
                    <thead>
                       <th>Id</th>
                       <th>Name</th>
                       <th>Email</th>
                       <th>Mobile</th>
                       <th>Action</th>
                    </thead>        
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
  $(document).ready(function () {
        $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax":{
                     "url": "{{url('/admin')}}/getSubscriberData",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            "columns": [
                { "data": "id" },
                { "data": "name" },
                { "data": "email" },
                { "data": "mobile" },
                { "data": "action" }
            ]  

        });
    });



  

    function viewDetails(subcriber_assign_id ) 
    { 
      var subcriber_assign_id  = subcriber_assign_id ;
      //alert(status);
       $.ajax({
            url: "{{url('/admin')}}/assign_menu_details",
            type: 'post',
            data: {subcriber_assign_id :subcriber_assign_id },
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }

   $('.verifybtn').click(function() {
    $this = $(this);
    alert($this);
    if (($this.html()).indexOf('Verified') != -1) btnval = '1';
            else btnval = '0';
            if(btnval=="0")
            {
              var status ="pending"; 
            }
            else
            {
              var status ="approve";
            }
     swal({
          title: "Approve Subscriber",
          text: "Are you sure you want to Verify & Activate this Subscriber?",
          icon: "warning",
          buttons: [
            'Cancel',
            'Activate'
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
          if (isConfirm) 
          {
 
            $.post( '{{url('/')}}/admin/verify_subscriber', {
               action: btnval,
               id: $this.val()
            }, function(data) {
              //alert(data);
              if (data == '0') $this.html('Pending').removeClass('btn-success').addClass('btn-danger');
              else if (data == '1') $this.html('Verified').removeClass('btn-danger').addClass('btn-success');
            location.reload();
            });    

          } else {
             swal("Cancelled", "Verification Cancel", "error");
             return false;
          }
        });
   });

</script> 
@endsection