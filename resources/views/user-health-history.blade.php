@extends('layouts.subscriber_master')
@section('content')
<style>
  .user-panel{
    margin-top: 5rem;
  }
</style>
<main>
   <section class="user-panel">
      <div class="container mt-3">
          @php $title ="Edit Health History"; @endphp 
          <!-- @include('layouts.bread_crum') -->
           <div class="row">
               @include('layouts.subscriber_sidebar')      
              <div class="col-md-8 col-lg-9  my-account" > 
                <div class="profile-container box box-success">
                  @include('layouts._status_msg')  
                  <div class="box-header with-border">
                      Edit Health History
                      <button class="btn btn-sm btn-dark pull-right" onclick="location.href='{{ URL('') }}/health-history'">
                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>
                  </div>
                  <div class="box-body">
                    <div class="address-coupon-container">  
                        <!-- <div class="heading pt20"><i class="fa fa-heartbeat"></i>
                           EDIT HEALTH HISTORY  
                           <button class="btn btn-sm btn-primary pull-right" onclick="location.href='{{ URL('') }}/health-history'">
                           <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>
                        </div> -->
                         <div class="table-responsive">
                            <table class="table table-sm">
                                <tbody>
                                @foreach($data as $key=>$value) 
                                @if($key == 0)     
                                  <tr>
                                  <td width="25%">Subscriber Name: </td>
                                  <td>{{ ucfirst($value->subscriber_name) }}</td>
                                  </tr>
                                  <td width="25%">Plan Name: </td>
                                  <td>{{ $value->sub_name }} <br />
                                    <small><b>From:</b> </small>
                                    {{ date('d-M-Y',strtotime($value->start_date)) }}
                                    <small><b>To:</b> </small>
                                    {{ date('d-M-Y',strtotime($value->expiry_date)) }}
                                  </td>
                                  </tr>
                                  <tr>
                                  <td width="25%">Nutritionist Name: </td>
                                  <td>{{ ucfirst($value->name) }}</td>
                                  </tr>                                 
                                @endif                          
                                @endforeach
                              </tbody>
                            </table>
                            </div>                          
                            <div class="table-responsive"  style="font-size: 14px;">
                            <table id="dtable" class="ui celled table table-sm"  style="width:100%" style="botder-top:1px solid #DEE2E6">                                                   
                                <thead>
                                    <tr class="text-center">
                                        <th style="background:#e5e5e5; color:#000">Current Weight</th>
                                        <th style="border-left: dashed 1px #588937;border-right: dashed 1px #588937">Bmr</th>
                                        <th style="border-left: dashed 1px #588937;border-right: dashed 1px #588937">Bmi</th>
                                        <th style="border-left: dashed 1px #588937;border-right: dashed 1px #588937">Body Fat</th>
                                        <th>Calories</th>
                                        <th>Protein</th>
                                        <th>Fiber</th>
                                        <th>Carbs</th>
                                        <th>Fats</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody> 
                              
                                @foreach($data as $key=>$value) 
                                    @if($value->is_active=="0")
                                     @php $style="background-color:";
                                    
                                     $bgcolor = '';
                                     @endphp
                                    @else
                                     @php $style="background-color:#f2f9ed";
                                     $bgcolor = '';
                                     @endphp
                                    @endif     
                                    <tr style="{{$style}}">
                                    <td style="background:#e5e5e5; color:#000" class="pl-4"><!-- <img src="{{ URL('') }}/uploads/images/kg.svg"" alt="nutrtidock-subscriber" width="20" height="20"> -->  {{ $value->current_wt }} Kg</td>

                                    <td style="border-left: dashed 1px #588937;border-right: dashed 1px #588937; background:{{ $bgcolor }}" class="pl-3"><!-- <img src="{{ URL('') }}/uploads/images/metabolism.svg"" alt="nutrtidock-subscriber" width="20" height="20"> --> {{ $value->bmr }}</td>

                                    <td style="border-left: dashed 1px #588937;border-right: dashed 1px #588937; background:{{ $bgcolor }}" class="pl-3"><!-- <img src="{{ URL('') }}/uploads/images/bmi.svg"" alt="nutrtidock-subscriber" width="20" height="20"> --> {{ $value->bmi }}</td>

                                    <td style="border-left: dashed 1px #588937;border-right: dashed 1px #588937; background:{{ $bgcolor }}" class="pl-3"><!-- <img src="{{ URL('') }}/uploads/images/bfat.svg"" alt="nutrtidock-subscriber" width="20" height="20"> --> {{ $value->body_fat }}</td>
                                    <td><img src="{{ URL('') }}/uploads/images/calories.svg"" alt="nutrtidock-subscriber" width="20" height="20"> {{ $value->req_calories }}</td>
                                    <td>
                                      <img src="{{ URL('') }}/uploads/images/protein.svg"" alt="nutrtidock-subscriber" width="20" height="20"> {{ $value->protein }}</td>
                                      <td>
                                      <img src="{{ URL('') }}/uploads/images/fiber.svg"" alt="nutrtidock-subscriber" width="20" height="20"> {{ $value->fiber }}</td>
                                    <td>
                                        <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="nutrtidock-subscriber" width="20" height="20"> {{ $value->carbs }}</td>
                                    <td>
                                      <img src="{{ URL('') }}/uploads/images/fat.png" alt="nutrtidock-subscriber" width="20" height="20"> {{ $value->fat }}</td>                   
                                    <td>  
                                      @if($value->is_active==1)                               
                                      <button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-details'  onclick='edithealthdetails({{$value->subscriber_health_id }})' title='Edit Meal'><i class="icon fa fa-pencil"></i></button>
                                      @else
                                      <img src="{{ URL('') }}/uploads/images/Prohibited-75-512.png" width="28">
                                      @endif


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
  <div class="modal fade" id="modal-details2" role="dialog" >
    <div class="modal-dialog  modal-dialog-centered">
      <div class="modal-content">
        <div id="content2"  style="background-color: #cff9c41f">          
        </div>
      </div>
    </div>
  </div>
</main>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script>
function edithealthdetails(id) { 
    var id  = id ;
    $.ajax({
        url: "{{url('/')}}/update-health-details",
        type: 'post',
        data: {
          subscriber_health_id :id 
          
        },
        success: function (data) {
            $("#content").html(data);
        }
    });
}
</script>
@endsection