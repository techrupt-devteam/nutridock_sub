@extends('layouts.subscriber_master')
@section('content')

<main>
   <section class="user-panel">
      <div class="container">
          <ol class="breadcrumb product_des-breadcrumb">
            <li><a href="https://www.nykaa.com">Home &nbsp;</a></li>
            <li class="breadcrumb-item active breadCrumbLevel"> / &nbsp; <span> Profile</span></li>
          </ol>
           <div class="row">
           
               @include('layouts.subscriber_sidebar')      
              <div class="col-md-8 col-lg-9  my-account" > 
                <div class="profile-container">
                  @include('layouts._status_msg')  
                    <div class="address-coupon-container clearfix pt-4">  
                        <div class="heading pt20"><i class="icon fa icon fa-cutlery"></i> 
                           EDIT MEAL PROGRAM  
                           <button class="btn btn-sm btn-primary pull-right" onclick="location.href='{{ URL('') }}/mealprogram'">
                           <i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>
                        </div>
                        <div class="box-body">
                            <div class="col-md-12">
                            <table class="table table-sm" style="font-size: 14px;">
                                <tbody>
                                @foreach($data as $key=>$value) 
                                @if($key == 0)     
                                  <tr>
                                  <td width="25%">Subscriber Name: </td>
                                  <td>{{ $value->subscriber_name }}</td>
                                  </tr>
                                  <td width="25%">Plan Name: </td>
                                  <td>{{ $value->sub_name }} <br />
                                    <small><b>From:</b> </small>
                                    {{ date('d-M-Y',strtotime($value->start_date)) }}
                                    <small><b>To:</b> </small>
                                    {{ date('d-M-Y',strtotime($value->expiry_date)) }}
                                  </td>
                                  </tr>                                 
                                @endif                          
                                @endforeach
                              </tbody>
                            </table>
                            </div>  
                            <div class="oaerror warning mb-2"><strong>Note:</strong> You can change your Meal for tomorrow, till today's 8PM.</div>   
                            <div class="oaerror danger mb-2"><strong>Note:</strong> If you want to skip your meal, "Nutridock fit" allows you to compensate your meal within 10 days after your subscription has been expired 
                            
                            
                            </div>                        
                            <div class="table-responsive"  style="font-size: 14px;">
                            <table id="dtable" class="ui celled table table-sm"  style="width:100%" style="botder-top:1px solid #DEE2E6">                                                   
                                <thead>
                                    <tr class="text-center">
                                        <th style="background:#e5e5e5; color:#000">Date</th>
                                        <th style="border-left: dashed 1px #588937;border-right: dashed 1px #588937">Meal Type</th>
                                        <th>Meal</th>
                                        <th>Calories</th>
                                        <th>Proteins</th>
                                        <th>Carbs</th>
                                        <th>fats</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody> 
                             
                                @foreach($data as $key=>$value) 
                                    @if($value->skip_meal_flag=="y")
                                     @php $style="background-color:#ff000030 !important";
                                     $bgcolor = '#ff000030';
                                     @endphp
                                    @else
                                     @php $style=""; 
                                     $bgcolor = '#f5fcef';
                                     @endphp
                                    @endif     
                                    <tr style="{{$style}}">
                                    <td style="background:#e5e5e5; color:#000" class="pl-4">
                                    {{ date('d-M-Y', strtotime($value->meal_on_date)) }}  
                                    <small><b>[Day {{ $value->day }}</small>]</b><br/>
                                    @if($value->skip_meal_flag=="y")
                                    <small><b style="color:red">Compensation Date: {{date('d-m-Y',strtotime($value->compenset_date))}}</b></small>
                                    @endif
  
                                    </td>
                                    <td style="border-left: dashed 1px #588937;border-right: dashed 1px #588937; background:{{ $bgcolor }}" class="pl-3">{{ $value->meal_type_name }}</td>                     
                                    <td>{{ $value->menu_title }}</td>
                                    <td><img src="{{ URL('') }}/uploads/images/calories.svg"" alt="your image" width="15" height="15"> {{ $value->calories }}</td>
                                    <td>
                                      <img src="{{ URL('') }}/uploads/images/protein.svg"" alt="your image" width="15" height="15"> {{ $value->proteins }}</td>
                                    <td>
                                        <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="15" height="15"> {{ $value->carbohydrates }}</td>
                                    <td>
                                      <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="15" height="15"> {{ $value->fats }}</td>                   
                                    <td>  
                                     
                                      @if(strtotime($value->meal_on_date." 20:00:00") >= strtotime($currentdate))                                                
                                      <button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-details'  onclick='editMeal({{$value->program_id}})' title='Edit Meal'><i class="icon fa fa-pencil"></i></button>
                                      <button class="btn btn-sm btn-danger" itle='Skip Meal'  data-toggle='modal' data-target='#modal-details2' onclick="skip_meal({{$value->program_id}})">
                                      <i class="fa fa-pause-circle" aria-hidden="true" style="font-size:16px"></i></button>
                                      @else
                                      <img src="{{url('/')}}/uploads/images/Prohibited-75-512.png" width="28" />
                                      <img src="{{url('/')}}/uploads/images/stop.svg" width="28" />
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
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/slim-select/1.18.10/slimselect.min.css" rel="stylesheet"> -->
<script>
	//$('#dtable').DataTable();  
// $(document).ready(function() {
//   var x = new SlimSelect({
//     select: '#menu_specifiation'
//   });
// });
//function to show details of subscriber
function editMeal(id) { 
    var id  = id ;
    $.ajax({
        url: "{{url('/')}}/editmeal",
        type: 'get',
        data: {
          program_id :id 
          
        },
        success: function (data) {
            $("#content").html(data);
        }
    });
}

//function to show details of subscriber
function skip_meal(id){ 
    var id  = id ;
    $.ajax({
        url: "{{url('/')}}/skipmeal",
        type: 'get',
        data: {program_id :id },
        success: function (data) {
           // alert(data);
            $("#content2").html(data);
        }
    });
} 
</script>
@endsection