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
        <li><a href="{{url('/')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{url('/')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
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
            <form action="{{url('/admin')}}/update_location/{{$data->id}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              @include('admin.layout._status_msg')
              {!! csrf_field() !!}
              
              <div class="box-body">
                <div class="form-group">
                  <label for="oldpassword">City<span style="color:red;" >*</span></label>
                  <select class="form-control" id="city" name="city" required="true">
                  <option value="">Select City</option>
                  <option value="Nagpur" @if($data->city=='Nagpur') selected="" @endif>Nagpur</option>
                  <option value="Wardha" @if($data->city=='Wardha') selected="" @endif>Wardha</option>
                  <option value="Nanded" @if($data->city=='Nanded') selected="" @endif>Nanded</option>
                  <option value="Dhule" @if($data->city=='Dhule') selected="" @endif>Dhule</option>
                  <option value="Nandurbar" @if($data->city=='Nandurbar') selected="" @endif>Nandurbar</option>
                  <option value="Nashik" @if($data->city=='Nashik') selected="" @endif>Nashik</option>
                  <option value="Hinganghat" @if($data->city=='Hinganghat') selected="" @endif>Hinganghat</option>
                </select>
                </div>
                <div class="form-group">
                  <label for="oldpassword">Area<span style="color:red;" >*</span></label>
                  <input type="text" class="form-control" id="area" name="area" placeholder="Area" required="true" value="{{$data->area}}">
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary pull-right">Submit</button>
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