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
        <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
        <li class="active">{{ $page_name." ".$title }}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
           @include('admin.layout._status_msg')
          <div class="box box-primary">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Specification Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="specification_title" name="specification_title" placeholder="Specification Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the specification name.">
                         <div id="name_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Specification Icon<span style="color:red;" >*</span></label>
                        <input type="file" class="form-control" id="icon_image" name="icon_image" placeholder="Specification Icon" required="true" data-parsley-errors-container="#icon_error" data-parsley-error-message="Please upload Specification Icon">
                         <div id="icon_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
              <div class="box-footer">
                  <div class="row">
                    <div class="col-md-12">
                      <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
                     <button type="submit" class="btn btn-primary pull-right">Submit</button>
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