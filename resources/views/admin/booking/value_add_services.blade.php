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
            <div class="box-header">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <a href="{{url('/admin')}}/add_value_add_services" class="btn btn-primary btn-xs" style="float: right;">Add Service</a>
            </div>
            
            <!-- <div class="box-header">
                  <div class="box-body">
                    <div class="form-group">
                       <a class="btn bg-navy btn-xs" href="{{url('/admin')}}/download_bookings" style="float: right;" >Download Excel</a>
                    </div>
                  </div>
              </div> -->
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Service Name</th>
                  <th>Service Type</th>
                  <th>Price</th>
                  <th>Description</th>
                  <th>Video Link</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>
                        {{$key+1}}
                      </td>
                      <td>
                        {{$value->service_type}}
                      </td>
                      <td>
                        {{$value->service_name}}
                      </td>
                      <td>
                        {{$value->price}}
                      </td>
                      <td>
                        {{$value->description}}
                      </td>
                      <td>
                        {{$value->video_link}}
                      </td>
                      <td>
                       <a href="{{url('/admin')}}/edit_value_add_services/{{$value->id}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{url('/admin')}}/view_value_add_services/{{$value->id}}" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                       <a href="{{url('/admin')}}/delete_value_add_services/{{$value->id}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a>
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