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
            <div class="box-header" >
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <a href="{{url('/admin')}}/add_store" class="btn btn-primary btn-xs" style="float: right;">Add Store</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Store Name</th>
                  <th>Email</th>
                  <th>Mobile No.</th>
                  <th>Min Order Value</th>
                  <th>Delivery Fees</th>
                  <th>Status</th>
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
                        {{$value['store_name']}}
                      </td>
                      <td>
                        {{$value['email']}}
                      </td>
                      <td>
                        {{$value['mobile_no']}}
                      </td>
                      <td>
                        {{$value['min_order_value']}}
                      </td>
                      <td>
                        {{$value['delivery_fees']}}
                      </td>
                      <td>
                        @if($value['active']=='1')
                          <a href="{{url('/admin')}}/active_store/{{$value['id']}}" class="btn btn-success btn-xs">Active</a>
                        @else
                          <a href="{{url('/admin')}}/active_store/{{$value['id']}}" class="btn btn-danger btn-xs">Inactive</a>
                        @endif
                      </td>
                      <td>
                        <a href="{{url('/admin')}}/edit_store/{{$value['id']}}" title="Edit">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a href="{{url('/admin')}}/view_store/{{$value['id']}}" title="View">
                          <i class="fa fa-eye"></i>
                        </a>
                        {{-- <a href="{{url('/admin')}}/delete_{{$url_slug}}/{{$value['id']}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                          <i class="fa fa-trash"></i>
                        </a> --}}
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