@extends('admin.layout.master')
 
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
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
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
              <a href="{{url('/admin')}}/add_{{$url_slug}}" class="btn btn-primary btn-sm" style="float: right;">Add Menu Category</a>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Sr.No.</th>
                  <th>Name</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                
                  @foreach($data as $key=>$value)
                    <tr>
                      <td>{{$key+1}}</td>
                      <td>{{$value['name']}}</td>
                      <td>
                        <div class="btn-group">
                          <a href="{{url('/admin')}}/edit_{{$url_slug}}/{{base64_encode($value['id'])}}"  class="btn btn-primary"  title="Edit">
                            <i class="fa fa-pencil"></i>
                          </a>
                          <a href="{{url('/admin')}}/delete_{{$url_slug}}/{{base64_encode($value['id'])}}"   class="btn btn-default "  title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                            <i class="fa fa-trash "></i>
                          </a>
                        </div>
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