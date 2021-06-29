@extends('layouts.subscriber_master')
@section('content')
<main>
   <section class="user-panel">
      <div class="container">
          @php $title ="Profile"; @endphp 
          <!-- @include('layouts.bread_crum') -->
           <div class="row">
               @include('layouts.subscriber_sidebar')
              <div class="col-md-8 col-lg-9  my-account">
               <div class="profile-container">
                  <div class="mobile-mapping-status">
                     <div class="alert alert-info">
                        <div class="icon-wrap float-left">
                           <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                        </div>
                        <div class="message" style="width: calc(100% - 28px);display: inline-block;"> 
                           Your phone number is still verified! For security reasons, we recommend you to verify  your mobile number now! 
                        </div>
                     </div>
                  </div> 
                  <!-- <div class="user-details">
                  <div class="inner">
                     <div>
                        <img src="{{url('')}}/public/front/img/no-image.jpeg" alt="user" class="profile-img">
                     </div>
                     <div>
                        <div class="name">Surendra Singh Rathore</div>
                        <div class="contact-info"><div>
                           <span class="key">Email:&nbsp;</span> surendrajnvu@gmail.com </div>
                           <div>
                              <span class="key">Mobile:&nbsp;</span> 7028102190</div>
                              <div>
                                 <span class="key">Date of Birth:&nbsp;</span>
                                 <input type="date" readonly="" value="1992-02-17" style="border: medium none;"></div>
                                 <div class="change-password"><span>
                                    <i class="padlock fa fa-unlock-alt"></i> change password </span>
                                 </div>
                              </div>
                           </div>
                          <a href="" data-toggle="modal" data-target="#edit-profile"> <span class="edit-link"><i class="icon fa fa-pencil"></i> EDIT </span> </a>
                        </div>
                     </div> 
                    <div class="address-coupon-container clearfix mt-3"><div>
                       <div class="heading pt20"> My Address 
                        <span class="add-address">Add New Address </span>
                      </div>
                      <div class="card-view">
                        <div class="row">
                           <div class="col-md-6">
                              <div class="content">
                                 <span class="tag">Nashik</span>
                                 <div class="description pb5">
                                    <div class="name"> Surendra Singh</div> B-7 Hari Om appartment Shikhrewadi&amp;#10;Nashik Road, Nashik&amp;#10;Maharashtra,  Nashik -  422101,  Maharashtra 
                                    <div class="contact">+91-7028102190</div>
                                   </div>
                                   <div class="actions">
                                      <span class="action-link" title="Edit">
                                         <i class="icon fa fa-pencil"></i> EDIT 
                                      </span>
                                      <span class="action-link" title="Remove">
                                         <i class="icon fa fa-trash-o"></i> REMOVE 
                                      </span>
                                  </div>
                                </div>
                           </div>
                           <div class="col-md-6">
                              <div class="content">
                                 <span class="tag">Jayal</span>
                                 <div class="description pb5">
                                    <div class="name"> Surendra Singh</div> W-2 Near Patrol Pump dugoli,  Jayal -  341023,  Rajasthan 
                                    <div class="contact"> +91-9413477711 </div>
                                 </div>
                                 <div class="actions">
                                    <span class="action-link" title="Edit"><i class="icon fa fa-pencil"></i> EDIT </span><span class="action-link" title="Remove"><i class="icon fa fa-trash-o"></i> REMOVE </span>
                                 </div>
                              </div>
                           </div>
                        </div> 
                        </div>
                     </div>
                   </div> -->







                  <div class="box-body">
                    <div class="row">
                  
                       <div class="col-md-12"> 

                        <h4>My Latest Subscription
                        @php 
                          $no_of_addition_meal = $getadditionalData->duration_additional_meal - $getadditionalData->no_of_additional_meal; 
                        @endphp  

                            @if($no_of_addition_meal !=0)
                            <button type='button' class='buttonanm float-right btn btn-danger btn-sm' data-toggle='modal' data-target='#modal-additional-meal' onclick='additional_meal();' title='Subscriber additional meal'>You have {{ $no_of_addition_meal }} Additional Meal</button>
                            @endif


                        </h4><hr/>
                          <input type="hidden" id="start_date" value="{{$getadditionalData->start_date}}">
                          <input type="hidden" id="expiry_date" value="{{$getadditionalData->expiry_date}}">
                          <input type="hidden" id="subscriber_id" value="{{$getadditionalData->subscriber_id}}">
                          <input type="hidden" id="subscriber_dtl_id" value="{{$getadditionalData->dll_s_id}}">
                          
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
                                      <td style="color:red !important">{{ $value->sub_name }}<br /><small><b>Duration: {{ $value->no_of_days }} days</small></b></td>                     
                                      <td>{{ date('d-M-Y', strtotime($value->start_date)) }}</td>
                                      <td>{{ date('d-M-Y', strtotime($value->expiry_date)) }}</td>                   
                                      <td> <button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails1({{$value->id}})' title='Meal Program calendar'><i class="fa fa-calendar" aria-hidden="true" style="font-size: 16px;"></i></button>
                                      <button type='button' class='btn btn-info btn-sm' data-toggle='modal' data-target='#modal-details' onclick='viewDetails({{$value->id}})' title='Subscriber Details'><i class='fa fa-info-circle'></i></button>
                                      <button type='button' class='btn btn-success btn-sm' data-toggle='modal' data-target='#modal-details' onclick='changeAddress({{$value->id}})' title='Edit Subscriber Details'><i class="icon fa fa-pencil"></i></button>
                                      </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                     </div> <hr/> 
                     <div class="col-md-12 mb-5">
                      <?php if(!empty($todays_menu)){?>
                        <h4>Today's Meal</h4>
                        <hr/>
                      
                          @foreach($todays_menu as $mvalue)
                            <div class="col-md-4 mt-4">
                                <div class="card card-inverse card-info">
                                    <img class="card-img-top" src="{{ url('/')}}/uploads/menu/{{$mvalue->image}}">
                                    <div class="card-block">
                                        <h5 class="text-bold"><strong>{{$mvalue->menu_title}}</strong></h5>
                                        <hr/>
                                        <div class="card-text">
                                           <p><strong>Calories:</strong> {{$mvalue->calories}}</p>
                                           <p><strong>Proteins:</strong> {{$mvalue->proteins}}</p>
                                           <p><strong>Carbohydrates:</strong> {{$mvalue->carbohydrates}}</p>
                                           <p><strong>Fats:</strong> {{$mvalue->fats}}</p>
                                           <p><strong>Meal Type:</strong> {{$mvalue->meal_type_name}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                         <?php } ?>
                      </div>
                      

                     
                   </div>
                 </div>
             </div> 
          </div>
   </section>
</main>
<!-- The Modal -->
<div class="modal" id="edit-profile">
   <div class="modal-dialog">
     <div class="modal-content">
 
       <!-- Modal Header -->
       <div class="modal-header p-2">
         <h4 class="modal-title" style="font-size: 21px;">Edit Profile</h4>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
 
       <!-- Modal body -->
       <div class="modal-body">
         <div class="user-pic">
            <img src="http://www.nykaa.com/media/profilepic/1782591.jpg?2017-02-0704:20:30" alt="user" class="img">
         </div>
         <div class="form-group">
            <label class="font-weight-bold">Full Name</label>
            <input type="text" class="form-control" placeholder="fullname">
         </div>
         
         <div class="form-group">
            <label class="font-weight-bold">Email Id</label>
            <input type="email" class="form-control" placeholder="email">
         </div>
         
         <div class="row">
            <div class="col-sm-6">
               <div class="form-group">
                  <label class="font-weight-bold">Phone No.</label>
                  <input type="text" class="form-control" maxlength="10" minlength="10" placeholder="phone no">
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group">
                  <label class="font-weight-bold">Date of Birth</label>
                  <input type="date" class="form-control">
               </div>
            </div>
         </div>
         <div class="form-group">
            <label class="font-weight-bold d-block">Gender</label>
            <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" name="optradio">Male
               </label>
             </div>
             <div class="form-check-inline">
               <label class="form-check-label">
                 <input type="radio" class="form-check-input" name="optradio">Female
               </label>
             </div>
         </div>
         
       </div>
 
       <!-- Modal footer -->
       <div class="modal-footer text-center" style="justify-content: center;">
         <button class="btn btn-dark rounded-0">Submit Detail</button>
       </div>
 
     </div>
   </div>
 </div>
    <div class="modal fade" id="modal-details" role="dialog" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div id="content"  style="background-color: #cff9c41f">          
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-additional-meal" role="dialog" >
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div id="meal-content"  style="background-color: #cff9c41f">          
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
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<<style type="text/css">@keyframes glowing{0%{background-color:#d43f3a;box-shadow:0 0 5px #d43f3a;font-size:15px}50%{background-color:#d43f3a;box-shadow:0 0 20px #d43f3a;font-size:15px}100%{background-color:#d43f3a;box-shadow:0 0 5px #d43f3a;font-size:15px}}.buttonanm{animation:glowing 1.5s infinite}.box-body{border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:3px;border-bottom-left-radius:3px;padding:10px;background-color:#fff!important}.card{font-size:1em;overflow:hidden;padding:0;border:none;border-radius:.28571429rem;box-shadow:0 1px 3px 0 #d4d4d5,0 0 0 1px #d4d4d5}.card-block{font-size:1em;position:relative;margin:0;padding:1em;border:none;border-top:1px solid rgba(34,36,38,.1);box-shadow:none}.card-img-top{display:block;width:100%;height:auto}.card-title{font-size:1.28571429em;font-weight:700;line-height:1.2857em}.card-text{clear:both;margin-top:.5em;color:rgba(0,0,0,.68)}.card-footer{font-size:1em;position:static;top:0;left:0;max-width:100%;padding:.75em 1em;color:rgba(0,0,0,.4);border-top:1px solid rgba(0,0,0,.05)!important;background:#fff}.card-inverse .btn{border:1px solid rgba(0,0,0,.05)}</style>
<script >
$('#dtable').DataTable();  
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

function viewDetails1(id) { 
    var id  = id ;
    //alert(id);
    $.ajax({
        url: "{{url('')}}/subscriber_calendar",
        type: 'get',
        data: {sid :id },
        success: function (data) 
        {
        $('#content').html(data);
        }
    });
    return false;
} 

function additional_meal(id) { 
    var id  = id ;
    var subscriber_id  = $('#subscriber_id').val();
    var dll_s_id       = $('#subscriber_dtl_id').val();
    var start_date     = $('#start_date').val();
    var expiry_date    = $('#expiry_date').val();


    $.ajax({
        url: "{{url('/')}}/set_additional_meal",
        type: 'post',
        data: {
          subscriber_id : subscriber_id, 
          subscriber_dtl_id :dll_s_id, 
          subscriber_start_date :start_date, 
          subscriber_expiry_date :expiry_date, 
          
        },
        success: function (data) {
            $("#meal-content").html(data);
        }
    });
}

</script>
@endsection