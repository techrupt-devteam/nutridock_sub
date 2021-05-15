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
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title"> {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}</h3>
                <ol class="breadcrumb">
                  <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                  <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
                  <li class="active">{{ $page_name." ".$title }}</li>
                </ol>

            </div>
            <!-- /.box-header -->
            <!-- form start --> 
            <div class="box-body">
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
             <div class="row">
                  <div class="col-md-12">
                     <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Discount Type<span style="color:red;" >*</span></label>
                          <!-- <input type="text" class="form-control" id="discount_type" name="discount_type" placeholder="Discount Percent" required="true" data-parsley-errors-container="#namel_error" data-parsley-error-message="Enter the layered discount" autocomplete="off" value="{{$data['discount_type']}}"> -->
                           <select  class="form-control" id="discount_type" name="discount_type" placeholder="Discount Percent" required="true" data-parsley-errors-container="#namel_error" data-parsley-error-message="Select Type" autocomplete="off">
                             <option value=''>-Select Type-</option>
                             <option value='Initial'<?php if($data['discount_type']=="Initial"){echo "selected";}?>>Initial</option>
                             <option value='Layered'<?php if($data['discount_type']=="Layered"){echo "selected";}?>>Layered</option>
                           </select>
                           <div id="namel_error" style="color:red;"></div>
                        </div>
                      </div>
                       <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Discount Percent To Refferee<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="discount_per_to_refree" name="discount_per_to_refree" placeholder="Discount Percent To Refferee" required="true" data-parsley-errors-container="#discount_per_to_refree_er" data-parsley-error-message="Enter discount percent to refferee" autocomplete="off" value="{{$data['discount_per_to_refree']}}">
                           <div id="discount_per_to_refree_er" style="color:red;"></div>
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Discount Percent To Affiliate<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="discount_per_to_affiliate" name="discount_per_to_affiliate" placeholder="Discount Percent To Affiliate" required="true" data-parsley-errors-container="#dis_per_affr" data-parsley-error-message="Enter discount percent to affiliate" autocomplete="off" value="{{$data['discount_per_to_affiliate']}}">
                           <div id="dis_per_affr" style="color:red;"></div>
                        </div>
                      </div>
                  </div>
                </div>
                  <div class="row">
                  <hr/>
                 

                  <div class="col-md-12">
                    <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Min<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="min" name="min" placeholder="Min Reffered" required="true" data-parsley-errors-container="#min_error" data-parsley-error-message="Enter the min reffered." autocomplete="off" value="{{$data['min']}}">
                           <div id="min_error" style="color:red;"></div>
                        </div>
                      </div>
                       <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="name">Max<span style="color:red;" >*</span></label>
                          <input type="text" class="form-control" id="max" name="max" placeholder="Max Reffered" required="true" data-parsley-errors-container="#max_error" 
                          data-parsley-error-message="Enter the max reffered." 
                          autocomplete="off" value="{{$data['max']}}">
                           <div id="max_error" style="color:red;"></div>
                        </div>
                      </div>
                  </div>
                </div>
              </div>  
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
              </div>
            </form>
          </div>
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