@extends('admin.layout.master')
@section('content')
<style type="text/css">
    .select2-container--default .select2-selection--multiple {
    background-color: white !important;
    border-radius: 0px !important;
    border: 1px solid #d2d6de !important;
    cursor: text;
  }
</style>
   <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
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
              <h3 class="box-title">
                {{ $page_name." ".$title }}
                {{-- <small>Preview</small> --}}
              </h3>
              <ol class="breadcrumb">
                <li><a href="{{url('/admin')}}/dashbord"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                <li><a href="{{url('/admin')}}/manage_{{$url_slug}}">Manage {{ $title }}</a></li>
                <li class="active">{{ $page_name." ".$title }}</li>
              </ol>
            </div>
            <div class="box-body">
            <!-- form start -->
            <form action="{{ url('/admin')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                <div class="col-md-8 col-lg-9">
                  <div class="row">
                    <div class="col-md-12">
                    <div class="col-sm-6 col-md-4">
                      <div class="form-group">
                        <label for="name">Type of story<span style="color:red;" >*</span></label>
                         <select class="form-control " id="story_id" name="story_id"required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please select story.">
                          <option value="">-Select story-</option>
                          @foreach($story as $cvalue)
                          <option value="{{$cvalue->story_id}}">{{$cvalue->story_name}}</option>
                          @endforeach
                         </select>
                        
                      </div> <div id="#name_error" style="color:red;"></div>
                    </div> 
                    <div class="col-sm-6 col-md-8">
                      <div class="form-group">
                        <label for="name">Publication <span style="color:red;" >*</span></label>
                        <input type="text" autocomplete="off" class="form-control" id="link_name" name="link_name" placeholder="Enter Publication " required="true" data-parsley-errors-container="#title_error" data-parsley-error-message="Please enter publication .">
                         <div id="#title_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="col-sm-6 col-md-8">
                       <div class="form-group">
                          <label for="name">Coverage <span style="color:red;" >*</span></label>
                            <input type="text" autocomplete="off" class="form-control" id="link" name="link" placeholder="Enter Coverage" required="true" data-parsley-errors-container="#Link_error" data-parsley-error-message="Please enter coverage.">
                           <div id="#Link_error" style="color:red;"></div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4">
                       <div class="form-group">
                          <label for="name">Coverage Date<span style="color:red;" >*</span></label>
                            <input type="text" autocomplete="off" class="form-control" id="cdate" name="cdate" placeholder="Enter Coverage Date" required="true" data-parsley-errors-container="#Link_error" data-parsley-error-message="Please enter coverage date.">
                           <div id="#Link_error" style="color:red;"></div>
                        </div>
                    </div>
                  </div>
                   <div class="col-md-12">
                    <div class="col-sm-6 col-md-12">
                       <div class="form-group">
                          <label for="name">Short Description </label>
                          <textarea class="form-control" resize="false" name="short_description" id="short_description" data-parsley-errors-container="#name_error"  data-parsley-error-message="Please enter the short description."  rows="3" style="resize: none;"> </textarea>
                        </div>
                    </div>
                  </div>
                </div>
                </div>
                <div class="col-md-4 col-lg-3">
                  <div class="">
                    <label for="name">Image <span style="color:red;" >*</span></label>
                    <div id="image-preview" class="mx-auto" style="background-size:cover;background-image:  url('admin_css_js/css_and_js/admin/dist/img/default-img.jpg'); ">
                      <label for="menu_image" id="image-label">
                        <i class="fa fa-camera" aria-hidden="true"></i>
                      </label>
                      <img id="blah" src="{{ url('/')}}/uploads/default-img.jpg"/>
                      <input type="file" class="user_image-file" id="image" name="image" placeholder="Select menu image" required="true" data-parsley-errors-container="#image_error" accept="image/x-png,image/gif,image/jpeg,image/png" data-parsley-error-message="Please upload image.">
                    </div>
                    <div id="image_error" style="color:red;"></div>
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
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script type="text/javascript">
   CKEDITOR.replace( 'what_makes_dish_special');
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#menu_image").change(function() {
   readURL(this);
  });

  // multiple fil upload 
  
  function addDurationRow()
  {
      var img_flag = $('#img_flag').val();
      img_flag = parseInt(img_flag)+parseInt(1); 
      $('#img_flag').val(img_flag);
       var tr = '<tr class="tr_row_duration' + img_flag + '"><td><input type="file" class="form-control"  id="img'+img_flag+'" name="img'+img_flag+'" ><span id="img_msg1" style="color:red;"></span></td><td style="text-align: right;vertical-align: middle;padding-right: 0;width: 61px;"><a href="javascript:void(0);" class="btn btn-danger btn-sm remove"  onclick="removedurationRow_ajax(' + img_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
        $('#img_body').append(tr);
  }


  function removedurationRow_ajax(div_id)
  {
      var img_flag = $('#img_flag').val();
      if(img_flag!=1)
      {
        $('.tr_row_duration'+div_id).remove();
        var img_flagv = parseInt(img_flag)-1;
        $('#img_flag').val(img_flagv);
      }
  }

  // Ingradiants 

  function addintRow()
  {
      var int_flag = $('#int_flag').val();
      int_flag = parseInt(int_flag)+parseInt(1); 
      $('#int_flag').val(int_flag);
       var tr = '<tr class="tr_row_int' + int_flag + '"><td><input type="text" class="form-control" id="int_title'+int_flag+'" name="int_title'+int_flag+'" placeholder="Enter Ingrediants Name" > <div id="#inttitle_error" style="color:red;"></div></td><td><input type="file" class="form-control"  id="int_img'+int_flag+'" name="int_img'+int_flag+'"><span id="int_img_msg'+int_flag+'" style="color:red;"></span></td><td style="text-align:right;padding-right: 0px;vertical-align: middle;"><a href="javascript:void(0);" class="btn btn-danger btn-sm remove"  onclick="removeintRow_ajax(' + int_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
        $('#int_body').append(tr);
  }

  function removeintRow_ajax(div_id)
  {
      var int_flag = $('#int_flag').val();
      if(int_flag!=1)
      {
        $('.tr_row_int'+div_id).remove();
        var int_flagv = parseInt(int_flag)-1;
        $('#int_flag').val(int_flagv);      
      }
  }

</script>
@endsection