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
                        <label for="role_name">Select Role<span style="color:red;" >*</span></label>
                         <select name="role_id" id="role_id" class="form-control" required="true">
                         <option value="">-Select-</option>  
                           @foreach($role as $rvalue)
                             <option value="{{$rvalue->role_id}}">{{$rvalue->role_name}}</option>  
                           @endforeach
                         </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="role_name">Select Type<span style="color:red;" >*</span></label>
                         <select name="type_id" id="type_id" class="form-control type_id" required="true">
                         <option value="">-Select-</option>  
                           @foreach($type as $tvalue)
                             <option value="{{$tvalue->type_id}}">{{$tvalue->type_name}}</option>  
                           @endforeach
                         </select>
                      </div>
                    </div>
                  </div>
                </div>
                </div> 
                <div class="row">
                  <div class="col-md-12" id="menudiv">
                       
                  </div>
                </div>
              <div class="box-footer">
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  
  <script type="text/javascript">
  $("select.type_id").change(function() {
      var type_id = $(".type_id option:selected").val();
      $.ajax({
        type: "post",
        url: "{{url('/admin')}}/getmenu",
        data: {
          type_id: type_id
        }
      }).done(function(data) {
           var result = data.split('|');
           $("#menudiv").html(result[0]);
      });
    });
</script>
@endsection