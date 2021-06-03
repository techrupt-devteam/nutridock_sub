@extends('admin.layout.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
                {{--  <small>advanced tables</small> --}}
              </h3>
              <div class="alert alert-info col-md-12 mt-4 text-left" style="
                  margin-top: 13px;
                  ">
                  <strong><i class="glyphicon glyphicon-hand-right"></i> Note! Order Pending </strong>if order status is pending then <b> Bill No and Order No </b>  not generated. <i class="glyphicon glyphicon-upload"></i>
                  <br/>
                   <strong><i class="glyphicon glyphicon-hand-right"></i> Note! Red color </strong>background order means order has manually generated to posist.
                  </div>
                  
            </div>
            <!-- /.box-header -->
            <div class="box-body"><div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Order No</th>
                  <th>Bill No</th>
                  <th>Name</th>
                  <th>Menu Title</th>
                  <th>Meal Type</th>
                  <th>Status</th>
                  <th class="text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                
                  @foreach($data as $key=>$value)
                   @if($value->order_resend =="n")
                   <?php $style="background-color: #ffff !important;"?>
                   @else
                    <?php $style="background-color: #e80f0f1c !important;"?>
                   @endif
                    <tr style="<?php echo $style; ?>">
                      <td>{{date('d-m-Y',strtotime($value->bill_date))}}</td>
                      <td>@if(!empty($value->order_no)){{$value->order_no}}@else -  @endif</td>
                      <td>@if(!empty($value->bill_no)){{$value->bill_no}}@else  - @endif</td>
                      <td>{{$value->subscriber_name}}</td>
                      <td>{{$value->menu_title}}</td>
                      <td>{{$value->mealtype}}</td>
                      <td>@if($value->order_status=='y')<span style="color:green !important;"><b>Order Push <small>(processing)</small></b></span>@else<span style="color:red !important;"><b>Order Pending <small>(Failed)</small></b></span>@endif</td>
                      <td class="text-center">
                        @if($value->order_status=='y')<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-details" onclick="viewDetails(<?php echo $value->order_id;?>);"><i class="fa fa-info-circle"></i></button>@endif
                        @if(empty($value->order_no))
                        <button class="btn btn-danger btn-sm" onclick="resend_order(<?php echo $value->order_id;?>)">Push Order</button>
                        @endif
                      </td>
                    </tr>
                  @endforeach
                </tbody>
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
  <div class="modal fade static" id="modal-details">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div id="content"> </div>
    </div>
  </div>
</div>

  <!-- /.content-wrapper -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
  <link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>  

  <script type="text/javascript">
    function resend_order(id) 
    {  
      
      swal({
        title: "Push Order",
        text: "Are You sure to resend this order",
        icon: "warning",
          buttons: [
            'Cancel',
            'Yes, change it!'
          ],
         
        }).then(function(isConfirm) {
          if (isConfirm) 
          { 
             var o_id = id;
            //alert(status);
             $.ajax({
                  url: "{{url('/admin')}}/order_resend",
                  type: 'post',
                  data: {order_id:o_id},
                  success: function (data) 
                  {
                    //alert(data);
                    if(data =="success")
                    {
                      swal({ title: "Order Push",text: "Order has been resend to posist", icon: "success"});
                      window.location.href = "manage_order";
                    }
                    else
                    {
                      swal({ title: "Order Push Error",text: "You cannot Push Order as Order date is not matched with Today's date.", icon: "warning"});
                    }
                  }
              });
           
                
          } else {
               
            
            
          }
        });


     }


    function viewDetails(order_id) 
    { 

      var m_id = order_id;
      //alert(status);
       $.ajax({
            url: "{{url('/admin')}}/order_details",
            type: 'post',
            data: {order_id:m_id},
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }


  </script>
@endsection