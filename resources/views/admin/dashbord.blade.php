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
        Dashboard   <!-- Login-city : <?php echo Session::get('login_city_name'); ?> -->
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
                  <h4><strong>@if(!empty($data['total_subscriber_count'])){{$data['total_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p>Total Subscriber</p>
                </div>
                <div class="icon">
                  <i class="fa fa-cutlery"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">Total Subscriber </a> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-orange">
                <div class="inner">
                 <h4><strong>@if(!empty($data['new_subscriber_count'])){{$data['new_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p>New Subscription</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-plus"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col --> 
            <!-- ./col -->
            <div class="col-md-4">
              <!-- small box -->
              <div class="small-box bg-gradient-custom-indigo">
                <div class="inner">
                 <h4><strong>@if(!empty($data['expire_subscriber_count'])){{$data['expire_subscriber_count']}}@else 0 @endif</strong></h4>
                  <p>Expire Subscription</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user-times"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
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
                  <p>Nutrionist</p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
              </div>
            </div>
            <!-- ./col -->
            <div class="col-md-6">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h4><strong>@if(!empty($data['opermanager_count'])){{$data['opermanager_count']}}@else 0 @endif</strong></h4>
                  <p>Operation Manager</p>
                </div>
                <div class="icon">
                 <i class="fa fa-file"></i>
                </div>
                <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
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
                <div class="chart">
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

          


        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #ddd !important;">
                <h3 class="box-title">Nutritionist</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><b><i class="fa fa-plus"></i></b>
                  </button>
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="list-group list-lg-group list-group-flush">
                  <div class="list-group-item list-group-item-action">
                    <div class="media mt-0">
                      <img class="avatar-lg rounded-circle mr-3 my-auto" src="{{url('/')}}/admin_css_js/css_and_js/admin/dist/img/avatar.png" alt="Image description">
                      <div class="media-body">
                        <div class="d-flex align-items-center">
                          <div class="mt-0"> 
                            <h5 class="mb-1 tx-15">Samantha Melon</h5> 
                            <p class="mb-0 tx-13 text-muted">User ID: #1234 </p>
                          </div>
                          <span class="ml-auto wd-45p fs-16 mt-2"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="media mt-0">
                      <img class="avatar-lg rounded-circle mr-3 my-auto" src="{{url('/')}}/admin_css_js/css_and_js/admin/dist/img/avatar.png" alt="Image description">
                      <div class="media-body">
                        <div class="d-flex align-items-center">
                          <div class="mt-0"> 
                            <h5 class="mb-1 tx-15">Samantha Melon</h5> 
                            <p class="mb-0 tx-13 text-muted">User ID: #1234 </p>
                          </div>
                          <span class="ml-auto wd-45p fs-16 mt-2"></span>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="list-group-item list-group-item-action">
                    <div class="media mt-0">
                      <img class="avatar-lg rounded-circle mr-3 my-auto" src="{{url('/')}}/admin_css_js/css_and_js/admin/dist/img/avatar.png" alt="Image description">
                      <div class="media-body">
                        <div class="d-flex align-items-center">
                          <div class="mt-0"> 
                            <h5 class="mb-1 tx-15">Samantha Melon</h5> 
                            <p class="mb-0 tx-13 text-muted">User ID: #1234 </p>
                          </div>
                          <span class="ml-auto wd-45p fs-16 mt-2"></span>
                        </div>
                      </div>
                    </div>
                  </div>


                </div>
              </div>
             </div> 
          </div>

          <div class="col-md-6">
            <div class="box box-info ">
              <div class="box-header with-border" style="background-color: #ddd !important;">
                <h3 class="box-title">Sales Activity</h3>
                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><b><i class="fa fa-plus"></i></b>
                  </button>
                  <!-- <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button> -->
                </div>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <div class="product-timeline card-body pt-2 mt-1"> 
                  <ul class="timeline-1 mb-0"> 
                    <li class="mt-0"> 
                      <i class="fa fa-cart-plus bg-primary-gradient text-white product-icon"></i> 
                      <span class="font-weight-semibold mb-4 tx-14 ">Total Products</span> 
                      <a href="#" class="float-right tx-11 text-muted">3 days ago</a> 
                      <p class="mb-0 text-muted tx-12">1.3k New Products</p>
                    </li> <li class="mt-0"> 
                      <i class="fa fa-balance-scale bg-danger-gradient text-white product-icon"></i> 
                      <span class="font-weight-semibold mb-4 tx-14 ">Total Sales</span> 
                      <a href="#" class="float-right tx-11 text-muted">35 mins ago</a> 
                      <p class="mb-0 text-muted tx-12">1k New Sales</p>
                    </li> 
                    <li class="mt-0"> 
                      <i class="fa fa-random bg-success-gradient text-white product-icon"></i> 
                      <span class="font-weight-semibold mb-4 tx-14 ">Toatal Revenue</span> 
                      <a href="#" class="float-right tx-11 text-muted">50 mins ago</a> 
                      <p class="mb-0 text-muted tx-12">23.5K New Revenue</p>
                    </li> 
                      <li class="mt-0"> 
                        <i class="fa fa-users bg-warning-gradient text-white product-icon"></i> 
                        <span class="font-weight-semibold mb-4 tx-14 ">Toatal Profit</span> 
                        <a href="#" class="float-right tx-11 text-muted">1 hour ago</a>
                         <p class="mb-0 text-muted tx-12">3k New profit</p>
                        </li> 
                        <li class="mt-0"> 
                          <i class="fa fa-street-view bg-purple-gradient text-white product-icon"></i> 
                          <span class="font-weight-semibold mb-4 tx-14 ">Customer Visits</span> 
                          <a href="#" class="float-right tx-11 text-muted">1 day ago</a> 
                          <p class="mb-0 text-muted tx-12">15% increased</p>
                        </li> 
                      </ul> 
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="{{url('/')}}/admin_css_js/css_and_js/admin/chart.js/Chart.js"></script>


<script>

var canvas = document.getElementById('barChart');
var data = {
    labels: ["January", "February", "March", "April", "May", "June", "July" ,"August","September","October","November","December"],
    datasets: [
        {
            label: "Active Subscriber",
            backgroundColor: "#39e21aa1",
            borderColor: "#1d8c08",
            borderWidth: 2,
            hoverBackgroundColor: "#aa7af8",
            hoverBorderColor: "#8845f5",
            data: [65, 59, 30, 81, 56, 55, 40,80,100,200,80,30],
        },
        {
            label: "Expire Subscriber",
            backgroundColor: "rgba(155,50,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 2,
            hoverBackgroundColor: "#f1957e",
            hoverBorderColor: "#b94629",
            data: [25, 39, 10, 65, 45, 35, 20,60,50,60,70,10],
        }
    ]
};
var option = {
animation: {
        duration:5000
}

};


var myBarChart = Chart.Bar(canvas,{
  data:data,
  options:option
});

        /*$(function () {

            var areaChartData = {
               labels: ["January", "February", "March", "April", "May", "June", "July" ,"August","September","October","November","December"],
      datasets: [
                     {
            label: "Active Subscriber",
            backgroundColor: "#39e21aa1",
            borderColor: "#1d8c08",
            borderWidth: 2,
            hoverBackgroundColor: "#aa7af8",
            hoverBorderColor: "#8845f5",
            data: [65, 59, 30, 81, 56, 55, 40,80,100,200,80,30],
        },
        {
            label: "Expire Subscriber",
            backgroundColor: "rgba(155,50,132,0.2)",
            borderColor: "rgba(255,99,132,1)",
            borderWidth: 2,
            hoverBackgroundColor: "#f1957e",
            hoverBorderColor: "#b94629",
            data: [25, 39, 10, 65, 45, 35, 20,60,50,60,70,10],
        }
                ]
            }

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: 'rgba(0,0,0,.05)',
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true
            }
           
            var lineChartCanvas = $('#barChart').get(0).getContext('2d')
            var lineChart = new Chart(lineChartCanvas,{
                type: 'line',
                data: areaChartData,
                options: lineChartOptions
            })
            var lineChartOptions = areaChartOptions
            lineChartOptions.datasetFill = false
           // lineChart.Line(areaChartData, lineChartOptions)
         })*/


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
 </script> 
 
@endsection