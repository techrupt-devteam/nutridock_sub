@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> {{ $page_name." ".$title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Area</th>
                    <th>Feedback</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                @foreach($data as $key=>$value)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->mobile_no}}</td>
                    <td>{{$value->city_name}}</td>
                    <td>{{$value->area_name}}</td>
                    <td class="text-center">
                      <a href="javascript:void(0);"  class="btn btn-warning btn-sm"  title="view">
                        <i class="fa fa-eye"></i>
                      </a>
                    </td>
                    <td class="text-center">
                      <a href="javascript:"  class="btn btn-primary btn-sm"  title="Replay">
                        <i class="fa fa-"></i> Replay
                      </a>
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
  <!-- /.content-wrapper -->
 
@endsection