@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
       {{--  <small>advanced tables</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Manage {{ $title }}</a></li>
        {{-- <li class="active">{{ $page_name." ".$title }}</li> --}}
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header" style="display: none;">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <a href="{{url('/admin')}}/add_user" class="btn btn-primary btn-xs" style="float: right;">Add Vendor</a>
            </div>
            
            
            <!-- /.box-header -->
            <div class="box-body" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Full Name</th>
                  <th>Mobile No.</th>
                  <th>Service Date</th>
                  <th>Service Type</th>
                  <th>City</th>
                  <th>Area</th>
                  <th>Car No</th>
                  <th>Model</th>
                  <th>Created At</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>
                        {{$key+1}}
                      </td>
                      <td>
                        {{$value->name}}
                      </td>
                     
                      <td>
                        {{$value->mobile_no}}
                      </td>
                      <td>
                        {{$value->service_date}}
                      </td>
                      <td>
                        {{$value->service}}
                      </td>
                     
                      <td>
                        {{$value->city}}
                      </td>
                      <td>
                        {{$value->area}}
                      </td>
                     
                      <td>
                        {{$value->car_no}}
                      </td>
                      
                       <td>
                        {{$value->model}}
                      </td>
                       
                        <td>
                        {{$value->created_at}}
                      </td>  
    
                    </tr>
                  @endforeach
                </tbody>
              </table>
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
  <!-- /.content-wrapper -->
 
@endsection