
@extends('admin.layout.master')
<?php  
  $session_user = Session::get('user');

  if($session_user->roles!='admin'){
      $session_module = Session::get('module_data');
      $session_permissions = Session::get('permissions');
      $session_parent_menu = Session::get('parent_menu');
      $session_sub_menu = Session::get('sub_menu');
  }


?>
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="min-height: auto !important;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard  <!--  Login-city : <?php echo Session::get('login_city_name'); ?> --> 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="">

        @if(empty($session_permissions) && $session_user->roles!='admin')
        <div class="col-md-12">
            <div class="alert alert-danger" role="alert">
              <strong>Sorry!</strong>  Admin not approve your access permission please contact with us.
            </div>
        </div>
        @elseif($session_user->roles=='admin')
        <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-success-gradient">
                <div class="inner">
                  <h4 class="wf"><strong>@if(!empty($data['total_subscriber_count'])){{$data['total_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf">Total Subscriber <small>All subscriber</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-cutlery"></i>
                </div>
                  <a href="{{url('/admin')}}/manage_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
              </div>
            </div>
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-orange">
                <div class="inner">
                 <h4 class="wf"><strong>@if(!empty($data['new_subscriber_count'])){{$data['new_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf">New Subscription <small>{{date('F Y', strtotime(date('Y-m-d')))}}</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus"></i>
                </div>
                  <a href="{{url('/admin')}}/manage_new_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
              </div>
            </div>
            <!-- ./col --> 
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-indigo">
                <div class="inner">
                 <h4 class="wf" ><strong>@if(!empty($data['expire_subscriber_count'])){{$data['expire_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf" >Expire Subscription <small>{{date('F Y', strtotime(date('Y-m-d')))}}</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-times"></i>
                </div>
                <a href="{{url('/admin')}}/manage_expire_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="row">
            <!-- ./col -->
            <div class="col-md-6">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                 <h4><strong>@if(!empty($data['nutritionist_count'])){{$data['nutritionist_count']}}@else 0 @endif</strong></h4>
                 <p>Nutritionist <small>All Nutritionist</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                 <a href="{{url('/admin')}}/manage_nutritionsit" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-md-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h4><strong>@if(!empty($data['opermanager_count'])){{$data['opermanager_count']}}@else 0 @endif</strong></h4>
                  <p>Operation Manager <small>All Operation Manager</small></p>
                </div>
                <div class="icon">
                 <i class="fa fa-file"></i>
                </div>
               <a href="{{url('/admin')}}/manage_user_manager" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
        </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #c3d4b0 !important;">
                <h3 class="box-title">Subscriber Monthly Statistics</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  </button>
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="chart" style="position: relative; height:40vh;">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>
        
        <div class="col-md-6">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #ddd !important;">
                <h3 class="box-title">Kitchen list for all location</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><b><i class="fa fa-plus"></i></b>
                  </button>
                </div>
              </div>
             
              <div class="box-body">
                <div class="table-responsive country-table">
                  <table id="example1" class="table table-bordered table-striped ">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>State</th>
                          <th>City</th>
                          <th>Area</th>
                          <th style="width: 90px;">View</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($data['kitchen'] as $key=>$value)
                      <tr>
                        <td>{{$value->kitchen_name}}</td>
                        <td>{{$value->state_name}}</td>
                        <td>{{$value->city_name}}</td>
                        <td>{{$value->area_name}}</td>
                        <td><button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->kitchen_id;?>);"><i class="fa fa-info-circle"></i> Kitchen Details</button>
                        </td>
                      </tr>
                      @endforeach
                        </tbody>
                    </table>
                </div>
              
              </div>
             
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #ddd !important;">
                <h3 class="box-title">Upcoming 2 days Expiry Subscriber List </h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><b><i class="fa fa-plus"></i></b>
                  </button>
                </div>
              </div>
             
              <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="datatb">
                    <thead>
                       <th>Name</th>
                       <th>Mobile</th>
                       <th width="10%">Expire</th>
                       <th width="25%" >Action</th>
                    </thead>  
                   <!--  <tfoot>
                   
                       <th>Name</th>
                       <th>Mobile</th>
                       <th>Expire Date</th>
                      
                    </tfoot> -->        
               </table>
             </div>
            </div>
             
            </div>
          </div>
        </div>
        <!------------------------Opration manager dashboard-------------------------->
        @elseif($session_user->roles=='2')
        <div class="row">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-success-gradient">
                <div class="inner">
                  <h4 class="wf"><strong>@if(!empty($data['total_subscriber_count'])){{$data['total_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf">Total Subscriber <small>All subscriber</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-cutlery"></i>
                </div>
                  <a href="{{url('/admin')}}/manage_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
              </div>
            </div>
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-orange">
                <div class="inner">
                 <h4 class="wf"><strong>@if(!empty($data['new_subscriber_count'])){{$data['new_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf">New Subscription <small>{{date('F Y', strtotime(date('Y-m-d')))}}</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus"></i>
                </div>
                  <a href="{{url('/admin')}}/manage_new_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
              </div>
            </div>
            <!-- ./col --> 
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-indigo">
                <div class="inner">
                 <h4 class="wf" ><strong>@if(!empty($data['expire_subscriber_count'])){{$data['expire_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf" >Expire Subscription <small>{{date('F Y', strtotime(date('Y-m-d')))}}</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-times"></i>
                </div>
                <a href="{{url('/admin')}}/manage_expire_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #c3d4b0 !important;">
                <h3 class="box-title">Subscriber Monthly Statistics</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  </button>
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="chart" style="position: relative; height:40vh;">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #ddd !important;">
                <h3 class="box-title">Nutridock Kitchen list for all location</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><b><i class="fa fa-plus"></i></b>
                  </button>
                </div>
              </div>
             
              <div class="box-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>State</th>
                          <th>City</th>
                          <th>Area</th>
                          <th style="width: 90px;">View</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($data['kitchen'] as $key=>$value)
                        <tr>
                          <td>{{$value->kitchen_name}}</td>
                          <td>{{$value->state_name}}</td>
                          <td>{{$value->city_name}}</td>
                          <td>{{$value->area_name}}</td>
                          <td>
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->kitchen_id;?>);"><i class="fa fa-info-circle"></i> Kitchen Details</button>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #ddd !important;">
                <h3 class="box-title">Upcoming 2 days Expiry Subscriber List </h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><b><i class="fa fa-plus"></i></b>
                  </button>
                </div>
              </div>
             
              <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="datatb">
                    <thead>
                       <th>Name</th>
                       <th>Mobile</th>
                       <th width="10%">Expire</th>
                       <th width="25%" >Action</th>
                    </thead>  
                   <!--  <tfoot>
                   
                       <th>Name</th>
                       <th>Mobile</th>
                       <th>Expire Date</th>
                      
                    </tfoot> -->        
               </table>
             </div>
            </div>
             
            </div>
          </div>
        </div>
        <!------------------------------Nutritionist Dashboard------------------------------->
        @elseif($session_user->roles=='1')
        <div class="row">
            <div class="col-md-7">
              <div class="row">
                <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-success-gradient">
                <div class="inner">
                  <h4 class="wf"><strong>@if(!empty($data['total_subscriber_count'])){{$data['total_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf">Total Subscriber <small>All subscriber</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-cutlery"></i>
                </div>
                  <a href="{{url('/admin')}}/manage_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
              </div>
            </div>
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-orange">
                <div class="inner">
                 <h4 class="wf"><strong>@if(!empty($data['new_subscriber_count'])){{$data['new_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf">New Subscription <small>{{date('F Y', strtotime(date('Y-m-d')))}}</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus"></i>
                </div>
                  <a href="{{url('/admin')}}/manage_new_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> 
              </div>
            </div>
            <!-- ./col --> 
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-indigo">
                <div class="inner">
                 <h4 class="wf" ><strong>@if(!empty($data['expire_subscriber_count'])){{$data['expire_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p class="wf" >Expire Subscription <small>{{date('F Y', strtotime(date('Y-m-d')))}}</small></p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-times"></i>
                </div>
                <a href="{{url('/admin')}}/manage_expire_subscriber" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
              </div>
            </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #c3d4b0 !important;">
                <h3 class="box-title">Subscriber Monthly Statistics</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse">
                  </button>
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="chart" style="position: relative; height:40vh;">
                  <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
            </div>
          </div>
        </div>
       

        @endif
      </div>
      
    </section>
    <!-- /.content -->
  </div>

  <div class="modal fade static" id="modal-details">
  <div class="modal-dialog">
    <div class="modal-content">
      <div id="content"> </div>
    </div>
  </div>
</div>

  <!-- /.content-wrapper -->
<style type="text/css">
  .wf{
    color:white !important;
  }
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{url('/')}}/admin_css_js/css_and_js/admin/chart.js/Chart.js"></script>
<script>

var canvas = document.getElementById('barChart');
var data = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul" ,"Aug","Sep","Oct","Nov","Dec"],

    datasets: [
        {

            label: "Active Subscriber",
            backgroundColor: "#39e21aa1",
            borderColor: "#1d8c08",
            borderWidth: 2,
            hoverBackgroundColor: "#aa7af8",
            hoverBorderColor: "#8845f5",
            //data: [65, 59, 30, 81, 56, 55, 40,80,100,200,80,30],
            data: [<?php echo implode(',',$data['sub_array'])?>],
        },
        {
            label: "Expire Subscriber",
            backgroundColor: "rgba(155,50,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 2,
            hoverBackgroundColor: "#f1957e",
            hoverBorderColor: "#b94629",
            //data: [25, 39, 10, 65, 45, 35, 20,60,50,60,70,10],
            data: [<?php echo implode(',',$data['exp_array'])?>],
        }
    ]
};
var option = {
animation: {
        duration:5000
},
x: {
      gridLines: {
          offsetGridLines: true
      }

  },
scales: {
    yAxes: [{
        ticks: {
                min: 0,
                stepSize:1,
                max:<?php echo  $data['total_subscriber_count']?>,
            }
    }]
}
};

var myBarChart = Chart.Bar(canvas,{
  data:data,
  options:option
});

/**************************************************************************/
  function viewDetails(kitchen_id) 
  { 
    var kit_id = kitchen_id;
    //alert(status);
    $.ajax({
      url: "{{url('/admin')}}/kitchen_details",
      type: 'post',
      data: {kitchen_id:kit_id},
      success: function (data) 
      {
        $('#content').html(data);
      }
    });
  }


  function viewsubDetails(subscriber_id) 
  { 
     var id  = subscriber_id ;
       //alert(id);
      $.ajax({
          url: "{{url('/admin')}}/subscriber_details",
          type: 'post',
          data: {sid :subscriber_id },
          success: function (data) 
          {
            $('#content').html(data);
          }
      });
  }

  




  /***********************************************************************/
   $(document).ready(function () {
        $('#datatb').DataTable({

            "processing"    : true,
            "serverSide"    : true,
           /* "scrollY"       : "200px",
            "scrollCollapse": true,
            "paging"        : false,*/
            "ajax":{
                     "url": "{{url('/admin')}}/getSubscriberDatadash",
                     "dataType": "json",
                     "type": "POST",
                     "data":{ _token: "{{csrf_token()}}"}
                   },
            
            "columns": [
                { data: "name",},
             /*   { data: "email",},*/
                { data: "mobile",},       
                { data: "expire_date",},
                { data: "action",}
            
            ]



        });
    });
 </script> 
 
@endsection