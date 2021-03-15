@extends('admin.layout.master')
 
@section('content')
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}
              </h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_category">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
            <!-- /.box-header -->
            <!-- form start --> 
            <div class="box-body">
             @include('admin.layout._status_msg')
              <form action="{{ url('/admin')}}/update_{{$url_slug}}/{{$data['gst_id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-3">
                 
                      <div class="form-group">
                        <label for="module_name">State <span style="color:red;" >*</span></label>
                        <select name="state_id" id="state_id" class="form-control" required="true" ata-parsley-errors-container="#state_error" data-parsley-error-message="Please select state.">
                          <option value="">-Select Type-</option>
                          @foreach($state as $tvalue)
                          <option value="{{$tvalue->id}}"  <?php if ($tvalue->id == $data['state_id']) { echo"selected"; }?> > {{$tvalue->name}}</option>
                          @endforeach
                        </select><div id="#state_error" style="color:red;">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                   
                      <div class="form-group">
                        <label for="module_name">CGST <span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="cgst" name="cgst" placeholder="CGST" required="true" ta-parsley-errors-container="#cgst_error" data-parsley-error-message="Please enter cgst." value="{{ (!empty($data['cgst']))?$data['cgst']:0 }}">
                        <div id="#cgst_error" style="color:red;">
                      </div>
                    </div>
                  </div>
                  <div class="col-md-3">
                   
                      <div class="form-group">
                        <label for="module_name">SGST <span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="sgst" name="sgst" placeholder="SGST" required="true" ta-parsley-errors-container="#sgst_error" data-parsley-error-message="Please enter sgst." value="{{ (!empty($data['sgst']))?$data['sgst']:0 }}">
                        <div id="#sgst_error" style="color:red;">
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3">
                    
                      <div class="form-group">
                        <label for="module_name">IGST <span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="igst" name="igst" placeholder="IGST" required="true"
                        ta-parsley-errors-container="#igst_error" data-parsley-error-message="Please enter igst." value="{{ (!empty($data['igst']))?$data['igst']:0 }}">
                        <div id="#igst_error" style="color:red;">
                      </div>
                    </div>
                  </div> 
                
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{url('/admin')}}/manage_{{$url_slug}}"  class="btn btn-default">Back</a>
              </div></div>
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