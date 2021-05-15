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
              <h3 class="box-title">
                {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}
              </h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>

            </div>
            <div class="row"> <div class="box-body">
                <div class="col-md-12">
                    <div class="alert alert-info alert-dismissible">
                      <h4><i class="fa fa-sticky-note"></i> Note!</h4>
                      <ul>
                      <li><strong >Expire subscriber show this background color :- <b class="expire_row">Content </b> </strong></i></li>
                       <br/>
                      <li><strong >Ongoing Subscriber show this background color:- <b class="noexp">Content </b> </strong></li>
                    </ul>
                    </div>
                </div></div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="example1">
                  <thead>
                     <th>Id</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Mobile</th>
                     <th>City</th> 
                     <th>Start Date</th>
                     <th width="10%">Expire Date</th>
                     <th>Payment Status</th>
                     <th width="35%">Action</th>
                  </thead>  
                  <tfoot>
                     <th>Id</th>
                     <th>Name</th>
                     <th>Email</th>
                     <th>Mobile</th>
                     <th>City</th> 
                     <th>Start Date</th>
                     <th>Expire Date</th>
                     <th>Payment Status</th>
                     <th width="35%">Action</th>
                  </tfoot>        
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
<!--   <div class="modal fade" id="modal-details" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div id="content">
          
        </div>
      </div>
    </div>
  </div> -->
   <div class="modal fade" id="modal-details" role="dialog" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div id="content"  style="background-color: #cff9c41f">          
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  
 <style type="text/css">
   .expire_row{
     background-color: #e80f0f1c !important;  
   } 
   .noexp{
     background-color: #38ff514a !important;  
   }
 </style>
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
                { data: "id", },
                { data: "name",},
                { data: "email",},
                { data: "mobile",},       
                { data: "city",},       
                { data: "start_date",},
                { data: "expire_date",},
                { data: "status"},
                { data: "action"}
            ],
            rowCallback: function (row, data) {
              if (data.class_r=="expire_row") {
                $(row).addClass('expire_row');
              }else{
                $(row).addClass('noexp');
              }
            }



        });
    });
    
    function default_meal_not_found()
    {
        swal("Default menu not set","Default menu not set on current duration please contact admin!", "error");
    }  

    function viewDetails(id) 
    { 
      var id  = id ;
       //alert(id);
      $.ajax({
          url: "{{url('/admin')}}/subscriber_details",
          type: 'post',
          data: {sid :id },
          success: function (data) 
          {
            $('#content').html(data);
          }
      });
    } 
   
    function viewMealProgramDetails(id) 
    { 
      var id  = id ;
       //alert(id);
      $.ajax({
          url: "{{url('/admin')}}/view_subscriber_meal_program",
          type: 'post',
          data: {sid :id },
          success: function (data) 
          {
            $('#content').html(data);
          }
      });
    }

     function viewDetailspdf(id) 
    { 
      var id  = id ;
       //alert(id);
      $.ajax({
          url: "{{url('/admin')}}/subscriber_pdf",
          type: 'get',
          data: {sid :id },
          success: function (data) 
          {
            //alert(data);
           // $('#content').html(data);
          }
      });
    }

   function verified_subscriber(value){

    var id           = value;
    var status_value = $("#status"+id).val(); 
    //alert(status_value);
    if (status_value != 0) btnval = '1';
            else btnval = '0';
            if(status_value==1)
            {
              var status ="pending"; 
              var btn_status ="Pending"; 
              var status_value_update = 0; 
            }
            else
            {
              var status ="verified";
              var btn_status ="Verified"; 
              var status_value_update = 1;
            }
     swal({
          title: btn_status+" Subscriber",
          text: "Are you sure you want to "+status+" this subscriber?",
          icon: "warning",
          buttons: [
            'Cancel',
             btn_status
          ],
          dangerMode: true,
        }).then(function(isConfirm) {
          if (isConfirm) 
          {
 
            $.post( "{{url('/admin')}}/verify_subscriber", {
               action: btnval,
               id: id,
               status: status_value_update
            }, function(data) {
              //alert(data);
              if (data == '0'){ 
              $('#btn-verify'+id).html('Pending <i class="fa fa-times-circle"></i>').removeClass('btn-success').addClass('btn-danger');  
              $("#status"+id).val(data);
               swal("Pending", "Verification Pending", "error");             
              }
              else if (data == '1'){ $('#btn-verify'+id).html('Verified <i class="fa fa-check-circle"></i>').removeClass('btn-danger').addClass('btn-success');
              $("#status"+id).val(data);
               swal("Verified", "Verification Success", "success");  
             };

            });    

          } else {
             swal("Cancelled", "Verification Cancel", "error");
             return false;
          }
        });
   }

</script> 
@endsection