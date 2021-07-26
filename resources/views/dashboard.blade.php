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
               <div class="dashboard_section">
                <div class="row">
                    <div class="col-md-12">
                        <!--begin::Engage Widget 8-->
                        <div class="card days-7-plan">
                            <div class="card-body p-0 d-flex ">
                                <div class="d-flex align-items-start w-100 justify-content-start bg-light-warning p-8 card-rounded position-relative" style="border-radius: 25px;">
                                  <div class="col-md-4">
                                    <div class="d-flex flex-column align-items-start flex-grow-1 h-100">
                                        <div class="p-3 flex-grow-1">
                                            <h4 class="text-warning font-weight-bold">
                                            {{ $getadditionalData->no_of_days}} Plan</h4>
                                            <p class="text-dark-50 font-weight-bold mt-3">{{date('d-M-Y',strtotime($getadditionalData->start_date))}} - {{date('d-m-Y',strtotime($getadditionalData->expiry_date))}}</p>
                                        </div>
                                        <a href="{{url('')}}/editmealprogram/{{$getadditionalData->dll_s_id}}" class="btn btn-success btn-round btn-sm ml-3"><i class="glyphicon glyphicon-hand-right"></i>  View Meal Plan  </a>
                                       
                                         <button type='button' class='btn btn-info btn-sm ml-3 mt-4' data-toggle='modal' data-target='#modal-details' onclick='viewDetails1({{$getadditionalData->dll_s_id}})' title='Meal Program calendar'><i class="fa fa-calendar" aria-hidden="true" style="font-size: 16px;"></i> View Datewise</button>
                                    </div>
                                  </div>
                                  <div class="col-md-5">
                                      @php 
                                    $no_of_addition_meal = $getadditionalData->duration_additional_meal - $getadditionalData->no_of_additional_meal; 
                                    @endphp  

                                    @if($no_of_addition_meal !=0)
                                     <div class="d-flex flex-column align-items-start flex-grow-1 h-100">
                                        <div class="p-3 flex-grow-1">
                                            <h4 class="text-warning font-weight-bold">Get Your Additional meal </h4>
                                           <p class="text-dark-50 font-weight-bold mt-3" ><label id="blink">Click Here <i class="glyphicon glyphicon-hand-down"></i></label></p>
                                        </div>
                                  
                                    <button type='button' class='buttonanm btn btn-danger btn-sm' data-toggle='modal' data-target='#modal-additional-meal' onclick='additional_meal();' title='Subscriber additional meal'> <i class="glyphicon glyphicon-hand-right"></i> You have {{ $no_of_addition_meal }} Additional Meal</button>
                                    @endif



                                    </h4><hr/>
                                    <input type="hidden" id="start_date" value="{{$getadditionalData->start_date}}">
                                    <input type="hidden" id="expiry_date" value="{{$getadditionalData->expiry_date}}">
                                    <input type="hidden" id="subscriber_id" value="{{$getadditionalData->subscriber_id}}">
                                    <input type="hidden" id="subscriber_dtl_id" value="{{$getadditionalData->dll_s_id}}">
                                   </div>
                                  </div>
                                  
                                    <div class="position-absolute right-0 bottom-0 overflow-hidden">
                                        <img src="{{url('')}}/public/front/img/7-day.png" class="max-h-200px max-h-xl-275px mb-n20" alt="">
                                    </div>
                                 
                                </div>
                            </div>
                        </div>

                        <!--end::Engage Widget 8-->
                       </div>
                    <div class="col-md-12">
                       <div class="row">
                           <div class="col-md-12 mb-5 mt-3">
                               <h4><strong>Today</strong> Meal </h4>
                           </div>
                           <?php  
                                  $calories_array = [];
                                  $proteins_array = [];
                                  $carbo_array = [];
                                  $fats_array = [];
                            ?>
                          @foreach($todays_menu as $mvalue) 
                            @if($mvalue->meal_type_id == 1)
                               <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 ">                           
                                <div class="ms-card">
                                  <div class="ms-card-img">
                                    <img src="{{ url('/')}}/uploads/menu/{{$mvalue->image}}" class="img-fluid"> <p class="text-center text-success"><strong>{{$mvalue->meal_type_name}}</strong></p>
                                  </div>
                                  <div class="ms-card-body">
                                    <div class="ms-card-heading-title text-center" style="justify-content: center;">
                                      <h5 class="text-center font-weight-bold">{{ucwords($mvalue->menu_title)}}</h5>
                                     </div>
                                    <hr/>
                                    <div class="ms-card-heading-title">
                                      <div class="row">
                                        <span class="col-sm-6"><img src="{{ URL('') }}/uploads/images/calories.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->calories }}
                                        @php 
                                        $calories_array [] = $mvalue->calories;
                                        $proteins_array [] = $mvalue->proteins;
                                        $carbo_array    [] = $mvalue->carbohydrates;
                                        $fats_array     [] = $mvalue->fats;
                                        @endphp  
                                        </strong>
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/protein.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->proteins }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                        <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->carbohydrates }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="20" height="20"> <strong>{{ $mvalue->fats }}</strong>
                                      </span>
                                      </div>
                                      <p></p>
                                     
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endif
                           
                          @if($mvalue->meal_type_id == 2)  
                          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 >">
                            <div class="ms-card" style="background-color: #bcf4b1;"> 
                                  <div class="ms-card-img">
                                    <img src="{{ url('/')}}/uploads/menu/{{$mvalue->image}}" class="img-fluid"> <p class="text-center text-success"><strong>{{$mvalue->meal_type_name}}</strong></p>
                                  </div>
                                  <div class="ms-card-body">
                                    <div class="ms-card-heading-title text-center" style="justify-content: center;">
                                      <h5 class="text-center font-weight-bold">{{ucwords($mvalue->menu_title)}}</h5>
                                     </div>
                                    <hr/>
                                    <div class="ms-card-heading-title">
                                      <div class="row">
                                        <span class="col-sm-6"><img src="{{ URL('') }}/uploads/images/calories.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->calories }}</strong>
                                          @php 
                                        $calories_array [] = $mvalue->calories;
                                        $proteins_array [] = $mvalue->proteins;
                                        $carbo_array    [] = $mvalue->carbohydrates;
                                        $fats_array     [] = $mvalue->fats;
                                        @endphp  
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/protein.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->proteins }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                        <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->carbohydrates }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="20" height="20"> <strong>{{ $mvalue->fats }}</strong>
                                      </span>
                                      </div>
                                      <p></p>
                                     
                                    </div>
                                  </div>
                                </div>
                          </div>
                          @endif

                          @if($mvalue->meal_type_id == 3)  
                          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6>">
                            <div class="ms-card">
                                  <div class="ms-card-img">
                                    <img src="{{ url('/')}}/uploads/menu/{{$mvalue->image}}" class="img-fluid"> <p class="text-center text-success"><strong>{{$mvalue->meal_type_name}}</strong></p>
                                  </div>
                                  <div class="ms-card-body">
                                    <div class="ms-card-heading-title text-center" style="justify-content: center;">
                                      <h5 class="text-center font-weight-bold">{{ucwords($mvalue->menu_title)}}</h5>
                                     </div>
                                    <hr/>
                                    <div class="ms-card-heading-title">
                                      <div class="row">
                                        <span class="col-sm-6"><img src="{{ URL('') }}/uploads/images/calories.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->calories }}</strong>
                                          @php 
                                        $calories_array [] = $mvalue->calories;
                                        $proteins_array [] = $mvalue->proteins;
                                        $carbo_array    [] = $mvalue->carbohydrates;
                                        $fats_array     [] = $mvalue->fats;
                                        @endphp  
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/protein.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->proteins }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                        <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->carbohydrates }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="20" height="20"> <strong>{{ $mvalue->fats }}</strong>
                                      </span>
                                      </div>
                                      <p></p>
                                     
                                    </div>
                                  </div>
                                </div>
                          </div>
                          @endif
                          
                          @if($mvalue->meal_type_id == 4)  
                          <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6>">
                            <div class="ms-card" style="background-color: #bcf4b1;">
                               
                                  <div class="ms-card-img">
                                    <img src="{{ url('/')}}/uploads/menu/{{$mvalue->image}}" class="img-fluid"> <p class="text-center text-success"><strong>{{$mvalue->meal_type_name}}</strong></p>
                                  </div>
                                  <div class="ms-card-body">
                                    <div class="ms-card-heading-title text-center" style="justify-content: center;">
                                      <h5 class="text-center font-weight-bold">{{ucwords($mvalue->menu_title)}}</h5>
                                     </div>
                                    <hr/>
                                    <div class="ms-card-heading-title">
                                      <div class="row">
                                        <span class="col-sm-6"><img src="{{ URL('') }}/uploads/images/calories.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->calories }}</strong>
                                          @php 
                                        $calories_array [] = $mvalue->calories;
                                        $proteins_array [] = $mvalue->proteins;
                                        $carbo_array    [] = $mvalue->carbohydrates;
                                        $fats_array     [] = $mvalue->fats;
                                        @endphp  
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/protein.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->proteins }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                        <img src="{{ URL('') }}/uploads/images/carbohydrates.svg" alt="your image" width="20" height="20"> <strong>{{ $mvalue->carbohydrates }}</strong>
                                    </span>
                                    <span class="col-sm-6">
                                      <img src="{{ URL('') }}/uploads/images/fat.png" alt="your image" width="20" height="20"> <strong>{{ $mvalue->fats }}</strong>
                                      </span>
                                      </div>
                                      <p></p>
                                     
                                    </div>
                                  </div>
                                </div>
                          </div>
                          @endif



                          @endforeach
                       </div> 
                     </div>



                      <div class="col-md-6">
                        <h4 class="my-3"><strong>Todays</strong> Calories </h4>
                        <!--begin::Engage Widget 8-->
                       <!--  <div class="card">
                            <img src="{{url('')}}/public/front/img/Screenshot_2.png" class="img-fluid"/>
                        </div> -->

                          @php 
                           $calories_array_final [] = $calories_array;
                           $proteins_array_final [] = $proteins_array;
                           $carbo_array_final    [] = $carbo_array;
                           $fats_array_final     [] = $fats_array;
                          @endphp  
                         <div class="card border-0" style="border-radius: 15px;">
                            <div class="card-body">
                                <h3 style="font-weight: 600;">
                                    You have Taken  <strong class="text-success">  {{array_sum($calories_array)}} </strong>K calories of your today food.
                                </h3>
                            </div>
                        </div>               
                        <div class="card">
                           <div id="piechart_3d" style="width:400px; height:250px;"></div>
                        </div>
                    </div> 
                  
                    <div class="col-md-6">
                        <h4 class="my-3"><strong>Meal </strong> Consumtion </h4>
                        <div class="card border-0" style="border-radius: 15px;">
                          <div class="card-body">
                                <h3 style="font-weight: 600;">
                                    You have Taken Food <strong class="text-success"> {{ $total_percent }}% </strong> of your Goal</h3>
                                </div>
                             <!--     &nbsp;<span> <small><strong>&nbsp;Consume Meal : {{$consume_cnt}}</strong>&nbsp;|&nbsp;<strong> Total Meal:{{$total_no_of_meal}} </strong></small></span> -->
                           
                        </div>
                          <div class="card">
                             <div id="donut_single" style="width: 400px; height: 250px;"></div>
                          </div>
                        </div> 
                    </div>
                 
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
 
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
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
<<style type="text/css">
@keyframes glowing{0%{background-color:#d43f3a;box-shadow:0 0 5px #d43f3a;font-size:15px}50%{background-color:#d43f3a;box-shadow:0 0 20px #d43f3a;font-size:15px}100%{background-color:#d43f3a;box-shadow:0 0 5px #d43f3a;font-size:15px}}@keyframes glowing_lbl{0%{font-size:15px}}
.buttonanm1{animation:glowing 1.5s infinite}
#blink{animation:glowing_lbl 1.5s infinite}.box-body{border-top-left-radius:0;border-top-right-radius:0;border-bottom-right-radius:3px;border-bottom-left-radius:3px;padding:10px;background-color:#fff!important}.card{font-size:1em;overflow:hidden;padding:0;border:none;border-radius:.28571429rem;box-shadow:0 1px 3px 0 #d4d4d5,0 0 0 1px #d4d4d5}.card-block{font-size:1em;position:relative;margin:0;padding:1em;border:none;border-top:1px solid rgba(34,36,38,.1);box-shadow:none}.card-img-top{display:block;width:100%;height:auto}.card-title{font-size:1.28571429em;font-weight:700;line-height:1.2857em}.card-text{clear:both;margin-top:.5em;color:rgba(0,0,0,.68)}.card-footer{font-size:1em;position:static;top:0;left:0;max-width:100%;padding:.75em 1em;color:rgba(0,0,0,.4);border-top:1px solid rgba(0,0,0,.05)!important;background:#fff}.card-inverse .btn{border:1px solid rgba(0,0,0,.05)}

  body{background-color:#ecf0f5}.card{margin-bottom:24px;box-shadow:0 .75rem 1.5rem rgba(18,38,63,.03);border-radius:.45rem}.meal_plan_img{border-radius:50%;height:100px;width:100px;object-fit:cover;float:right;border:3px solid #fff}.ms-card{background-color:#fff;-webkit-box-shadow:0 1px 6px 1px rgba(69,65,78,.1);-moz-box-shadow:0 1px 6px 1px rgba(69,65,78,.1);box-shadow:0 1px 6px 1px rgba(69,65,78,.1);margin-bottom:2rem;border-radius:15px}.ms-card-body p{margin-bottom:8px;line-height:1;font-size:12px;color:#119f05}.ms-card-heading-title h6{margin-bottom:5px}.ms-card-body,.ms-card-footer{position:relative;padding:0 .7rem 8px;font-size:14px}.ms-card-heading-title{display:flex;justify-content:space-between;align-items:end}.green-text{color:green}.bg-light-warning{background-color:#fff4de!important;border-radius:.45rem}.max-h-xl-275px{max-height:255px!important}.mb-n20,.my-n20{margin-bottom:-2rem!important}.bottom-0{bottom:0!important}.right-0{right:0!important}.overflow-hidden{overflow:hidden!important}.ms-card-img .img-fluid{width:100%;height:100%;border-radius:50%;object-fit:cover}.ms-card-img{width:100px;height:100px;transform:translateY(-30px);margin:0 auto}.days-7-plan{border:0;min-height:200px;border-radius:25px}.ms-card-heading-title h6{margin-bottom:5px;height:40px;overflow:hidden;text-overflow:ellipsis;-webkit-line-clamp:2;display:-webkit-box;-webkit-box-orient:vertical
  }
  hr {
    margin-top: 10px !important;
    margin-bottom: 10px !important;
    border: 0 !important;
    border-top: 1px solid #eee !important;
 }
</style>
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

//Piecharts

 var c = $('#calories1').val();
 var p = $('#proteins1').val();
 var carbo = $('#carbo1').val();
 var fats  = $('#fats1').val();

      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Task', 'Percentage'],
        /*  ['Calories', {{array_sum($calories_array)}}],*/
          ['Proteins', {{array_sum($proteins_array)}}],
          ['carbo',    {{array_sum($carbo_array)}}],
          ['fats',     {{array_sum($fats_array)}}]
        ]);

        var options = {
          //title: 'My Daily Activities',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
        chart.draw(data, options);
      }

// donut charts 

      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart1);

      function drawChart1() {

        var data1 = google.visualization.arrayToDataTable([
          ['Effort', 'Amount given'],
          ['Consume meal',     {{ $total_percent }}],
          ['Total meal',  {{$total_no_of_meal}}],
        ]);

        var options1 = {
          pieHole: 0.6,
          pieSliceTextStyle: {
            color: 'black',
          },
          legend: 'yellow'
        };

        var chart1 = new google.visualization.PieChart(document.getElementById('donut_single'));
        chart1.draw(data1, options1);
      }

</script>
@endsection