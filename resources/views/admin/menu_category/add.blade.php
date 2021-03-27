@extends('admin.layout.master')
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        {{ $page_name." ".$title }}
        {{-- <small>Preview</small> --}}
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section> -->

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
           @include('admin.layout._status_msg')
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"> {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}</h3>
                <ol class="breadcrumb">
                  <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
                  <li class="active">{{ $page_name." ".$title }}</li>
                </ol> 
            </div>
            <div class="box-body">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-6 col-lg-4">
                    <div class="form-group">
                        <label for="name">Menu Category Name <span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Menu Category Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the category name." autocomplete="off">
                         <div id="name_error" style="color:red;"></div>
                      </div>
                  </div>
                </div>
              </div>  
              <div class="box-footer">
                  <div class="row">
                    <div class="col-md-12">

                      <button type="submit" class="btn btn-primary">Submit</button>
                      <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
                     

                    </div>
                  </div>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection