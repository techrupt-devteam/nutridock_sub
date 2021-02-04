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
          <div class="box box-primary">
           <!--  <div class="box-header with-border">
              <h3 class="box-title">{{ $page_name." ".$title }}</h3>
            </div> -->
            <!-- /.box-header -->
            <!-- form start --> 
             @include('admin.layout._status_msg')
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['module_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">

                
                <div class="col-md-12">
                  <div class="col-md-3">
                  <div class="box-body">
                    <div class="form-group">
                      <label for="module_name">Module Type</label>
                      <select name="parent_id" id="parent_id" class="form-control"  onchange="getModuleUrl();">
                        <option value="">-Select Type-</option>
                      
                        @foreach($parent as $tvalue)
                        <option value="{{$tvalue->module_id}}" <?php if($tvalue->module_id==$data['parent_id']){ echo "Selected"; }?>> {{$tvalue->module_name}}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                 </div>
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="menu_name">Module Name<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="module_name" name="module_name" placeholder="Module Name" value="{{$data['module_name']}}" required="true">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3 module_url">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="module_name">Module Url</label>
                        <input type="text" class="form-control" id="module_url" name="module_url" placeholder="Module URL" value="{{$data['module_url']}}">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="module_name">Module Url Slug</label>
                        <input type="text" class="form-control" id="module_url_slug" name="module_url_slug" placeholder="Module URL Slug" value="{{$data['module_url_slug']}}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
              <!-- /.box-body -->
              <div class="box-footer">
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
                <button type="submit" class="btn btn-primary pull-right">Update</button>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
  <script type="text/javascript">
/*getModuleUrl();
    function getModuleUrl() {
        var parent_id = $('#parent_id').val();
         if(parent_id !=0 ) {
                $(".module_url").show();
                $("#module_url").attr("required","true");
            } else {
                $(".module_url").hide();
                $("#module_url").removeAttr("required");
                $(".parsley-required").hide();
            }
 


    }*/
  </script>
@endsection