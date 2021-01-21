@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_commercial_booking">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              @include('admin.layout._status_msg')
            
          <div class="row">  
            <div class="col-md-12">  
              <div class="row">
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Full Name:</label><span>{{$data->name}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Email:</label><span>{{$data->email}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Mobile No.:</label><span>{{$data->mobile}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">City:</label><span>{{$data->city}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Address:</label><span>{{$data->address}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Car:</label><span>{{$data->car}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Variant:</label><span>{{$data->varient}}</span>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Color:</label><span>{{$data->color}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">On Road Cost:</label><span>{{$data->road_cost}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Any Special Request:</label><span>{{$data->special_request}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Do you Require Finance:</label><span>{{$data->finance}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Adhar Card:</label><span><a href="http://commercial.marutiseva.com/{{$data->adhar_card}}"> View</a></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Pan Card:</label><span><a href="http://commercial.marutiseva.com/{{$data->pan_card}}"> View</a></span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Booking Date:</label><span>{{$data->date}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Transation:</label><span>{{$data->transaction_id}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Paid Amount:</label><span>{{$data->amount}}</span>
                  </div>
                </div>
              </div>
            </div>
            
            
           </div>
              <div class="box-header with-border box-footer">
                
              </div>

            </form>
          </div>
          <!-- /.box -->
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>

@endsection