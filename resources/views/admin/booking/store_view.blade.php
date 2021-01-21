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
        <li><a href="{{url('/admin')}}/manage_store">Manage {{ $title }}s</a></li>
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
                      <label for="oldpassword">Store Name:</label> <span>{{$data->store_name}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Email:</label> <span>{{$data->email}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Mobile No.:</label> <span>{{$data->mobile_no}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Min Order Value:</label> <span>{{$data->min_order_value}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Delivery Fees:</label> <span>{{$data->delivery_fees}}</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Delivery Schedule:</label> <span>{{$data->delivery_schedule}}</span>
                  </div>
                </div>
                {{--  <div class="col-md-6">
                  <div class="box-body">
                      <label for="oldpassword">Password:</label><span>{{$data->password}}</span>
                  </div>
                </div> --}}
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