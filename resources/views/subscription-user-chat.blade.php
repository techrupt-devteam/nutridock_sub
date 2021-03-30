@extends('layouts.subscriber_master')
@section('content')
<style>
    .user-panel {
        margin-top: 5rem;
    }
</style>
<main>
   <section class="user-panel">
      <div class="container mt-3">
          @php $title ="Chat with nutritionist"; @endphp 
          <!-- @include('layouts.bread_crum') -->
           <div class="row">
               @include('layouts.subscriber_sidebar')
              <div class="col-md-8 col-lg-9  my-account">
                <div class="profile-container box box-success">
                    <div class="address-coupon-container">    
                        <div class="box-header with-border">
                            <!-- <i class="fa fa-weixin" aria-hidden="true"></i>  -->
                            Chat with Nutrionist 
                            <small class="d-block"><i><b style="color:#8bc34a">Note</b>: Here is list of Subscriber, approved by admin & assigned Nutrionist</i></small>
                        </div>                   
                        <div class="box-body p-3">
                            <div class="table-responsive">
                            <table id="dtable" class="ui celled table table-responsive-sm" style="width:100%">
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
                                  
                                    <a href="goforchat/{{ $value->id }}" target="_blank"  class='btn btn-warning btn-sm' title='Chat with Nutrionist' style="font-size: 20px; color: #000"><i class="fa fa-weixin" aria-hidden="true" ></i>
                                    </a>
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
<script>
	$('#dtable').DataTable();  

</script>
@endsection