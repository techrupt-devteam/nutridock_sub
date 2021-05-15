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
                  <div class="col-md-12">
                       <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Discount Percent To Refferee<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="dis_per_reffree" name="dis_per_reffree" placeholder="Discount Percent To Refferee" required="true" data-parsley-errors-container="#dis_per_reffree_er" data-parsley-error-message="Enter discount percent to refferee" autocomplete="off">
                           <div id="dis_per_reffree_er" style="color:red;"></div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Discount Percent To Affiliate<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="dis_per_afiliate" name="dis_per_afiliate" placeholder="Discount Percent To Affiliate" required="true" data-parsley-errors-container="#dis_per_affr" data-parsley-error-message="Enter discount percent to affiliate" autocomplete="off">
                           <div id="dis_per_affr" style="color:red;"></div>
                        </div>
                      </div>
                  </div>
                </div>
                  <div class="row">
                  <hr/>
                  <div class="col-md-12">
                    <h4>Layered Refferal Discount</h4>
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Discount Percent<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="l_dis_per" name="l_dis_per" placeholder="Discount Percent" required="true" data-parsley-errors-container="#namel_error" data-parsley-error-message="Enter the layered discount" autocomplete="off">
                           <div id="namel_error" style="color:red;"></div>
                        </div>
                      </div>
                  </div>

                  <div class="col-md-12">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Min Reffered<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="min_reffered" name="min_reffered" placeholder="Min Reffered" required="true" data-parsley-errors-container="#min_error" data-parsley-error-message="Enter the min reffered." autocomplete="off">
                           <div id="min_error" style="color:red;"></div>
                        </div>
                      </div>
                       <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Max Reffered<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="max_reffered" name="max_reffered" placeholder="Max Reffered" required="true" data-parsley-errors-container="#max_error" 
                          data-parsley-error-message="Enter the max reffered." 
                          autocomplete="off">
                           <div id="max_error" style="color:red;"></div>
                        </div>
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