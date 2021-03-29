@extends('layouts.subscriber_master')
@section('content')
<main>
    <section class="user-panel">
      <div class="container mt-3">
          @php $title ="Subscription"; @endphp 
          <!-- @include('layouts.bread_crum') -->
           <div class="row">
               @include('layouts.subscriber_sidebar')
              <div class="col-md-8 col-lg-9  my-account" >
               
                <div class="profile-container box box-success">
                       @include('layouts._status_msg')  
                    <div class="box-header with-border">
                         <!-- <i class="fa fa-shopping-basket"></i> -->
                          My Subscription     
                    </div>
                    <div class="box-body no-padding">
                    <div class="address-coupon-container">                       
                        <div class="table-responsive">
                            <table id="dtable" class="ui celled table table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>Susbscriber Name</th>
                                        <th>Plan Details</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>                    
                                @foreach($data as $key=>$value)
                                    <tr>
                                    <td>{{ $value->subscriber_name }}</td>
                                    <td>{{ $value->sub_name }}<br /><small><b>Duration: {{ $value->no_of_days }}</small></b></td>                     
                                    <td>{{ date('d-M-Y', strtotime($value->start_date)) }}</td>
                                    <td>{{ date('d-M-Y', strtotime($value->expiry_date)) }}</td>                   
                                    <td>
                                    <button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails({{$value->id}})' title='Subscriber Details'><i class='fa fa-info-circle'></i></button>
                                    <!-- <button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails({{$value->id}})' title='Edit Subscriber Details'><i class="icon fa fa-pencil"></i></button> -->
                                    <button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-details' onclick='changeAddress({{$value->id}})' title='Edit Subscriber Details'><i class="icon fa fa-pencil"></i></button>
                                    </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>    
                        </div>                  
                    </div>
                </div>
           </div> 
      </div>
   </section>

   <div class="modal fade" id="modal-details" role="dialog" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div id="content"  style="background-color: #cff9c41f">          
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery/dist/jquery.min.js"></script>
<script src="{{url('/admin_css_js')}}/css_and_js/admin/jquery-ui/jquery-ui.min.js"></script>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.css' rel='stylesheet' />
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='https://cdn.jsdelivr.net/npm/moment@2.24.0/min/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js'></script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@3.10.2/dist/fullcalendar.min.js'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/css/select2.min.css">

<script>
	//$('#dtable').DataTable();  

//function to show details of subscriber
function viewDetails(id) { 
    var id  = id ;
    //alert(id);
    $.ajax({
        url: "{{url('')}}/details",
        type: 'post',
        data: {sid :id },
        success: function (data) 
        {
        $('#content').html(data);
        }
    });
} 

function changeAddress(id)
{
  $.ajax({
        url: "{{url('')}}/change_address",
        type: 'post',
        data: {sid :id },
        success: function (data) 
        {
        $('#content').html(data);
        }
    });
}


</script>
@endsection