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
                        <label for="name">Category Name<span style="color:red;" >*</span></label>
                         <select class="form-control select2" id="category_id" name="category_id" placeholder="Specification Name" required="true" data-parsley-errors-container="#name_error" data-parsley-error-message="Please select category.">
                          <option value="">-Select Category-</option>
                          @foreach($category as $cvalue)
                          <option value="{{$cvalue->id}}">{{$cvalue->name}}</option>
                          @endforeach
                         </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Title<span style="color:red;" >*</span></label>
                        <input type="text" class="form-control" id="menu_title" name="menu_title" placeholder="Enter Menu Title" required="true" data-parsley-errors-container="#title_error" data-parsley-error-message="Please enter title.">
                         <div id="#title_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Menu Image <span style="color:red;" >*</span></label>
                        <input type="file" class="form-control" id="menu_image" name="menu_image" placeholder="Select menu image" required="true" data-parsley-errors-container="#image_error" data-parsley-error-message="Please upload image.">
                        <div id="image_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>  
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Specification<span style="color:red;" >*</span></label>
                        <select class="form-control select2 new-arrow-set" id="specification_id" name="specification_id[]" placeholder="Specification Name"  data-parsley-errors-container="#specificationdrp_error" data-parsley-error-message="Please select the specification name." required="true" multiple="multiple">
                          <option>-Select Specification-</option>
                          @foreach($specification as $svalue)
                          <option value="{{$svalue->id}}">{{$svalue->specification_title}}</option>
                          @endforeach

                        </select>
                        <div id="specificationdrp_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Short Description <span style="color:red;" >*</span></label>
                        <textarea class="form-control" name="menu_description" id="menu_description" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the short description." required="true"> </textarea>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <img id="blah" src="{{ url('/')}}/uploads/preview.png" alt="your image" width="100" height="100"/>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
               <div class="row">
                <div class="col-md-12">
                 <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Ingredients<span style="color:red;" >*</span></label>
                        <textarea class="form-control" name="ingredients_desc" id="ingredients_desc" data-parsley-errors-container="#name_error" data-parsley-error-message="Please enter the ingredients." required="true" style="margin: 0px -15px 0px 0px; height: 132px; width: 327px;"> </textarea>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Calories<span style="color:red;" >*</span></label>
                        <div class="input-group">
                        <div class="input-group-addon btn-default"><img id="blah" src="{{ url('/')}}/uploads/images/calories.png" alt="your image" width="20" height="20"/></div>
                        <input type="text" class="form-control" placeholder="Enter Calories" id="calories" name="calories" required="true" data-parsley-errors-container="#calories_error" data-parsley-error-message="Please enter calories."></div>
                       <div id="calories_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                    <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Proteins<span style="color:red;" >*</span></label>
                        <div class="input-group">
                          <div class="input-group-addon btn-default"> <img id="blah" src="{{ url('/')}}/uploads/images/protein.jpg" alt="your image" width="20" height="20"/>
                          </div>
                          <input type="text" class="form-control" placeholder="Enter Proteins" id="proteins" name="proteins" required="true" data-parsley-errors-container="#proteins_error" data-parsley-error-message="please enter Proteins.">
                        </div>
                        <div id="proteins_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Carbohydrates<span style="color:red;" >*</span></label>
                        <div class="input-group">
                          <div class="input-group-addon btn-default"><img id="blah" src="{{ url('/')}}/uploads/images/carbohydrates.png" alt="your image" width="20" height="20"/>
                          </div>
                          <input type="text" class="form-control" placeholder="Enter Carbohydrates" id="carbohydrates" name="carbohydrates" required="true" data-parsley-errors-container="#carbohydrates_error" data-parsley-error-message="Please enter carbohydrates." >
                        </div>
                        <div id="carbohydrates_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                   <div class="col-md-4">
                    <div class="box-body">
                      <div class="form-group">
                        <label for="name">Fats<span style="color:red;" >*</span></label>
                         <div class="input-group">
                          <div class="input-group-addon btn-default"><img id="blah" src="{{ url('/')}}/uploads/images/fat.png" alt="your image" width="20" height="20"/>
                          </div>
                          <input type="text" class="form-control" placeholder="Enter Fats" id="fats" name="fats" required="true" data-parsley-errors-container="#fats_error" data-parsley-error-message="Please enter fats.">
                        </div>
                        <div id="fats_error" style="color:red;"></div>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
              <hr/>
              
              <div class="row"> 
                <div class="col-md-6">
                  <div class="box-body">
                    <table class="table table-bordered" id="myTable">
                      <thead style="background-color: #00cc445c;">
                        <tr>
                          <th width="30%">Mutiple File Upload</th>
                          <th class="text-center"><a href="javascript:void(0);" class="btn btn-info addRow" onclick="addDurationRow()"><i class="fa fa-plus"></i></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody id="img_body">
                        <input type="hidden" id="img_flag" name="img_flag" value="1">
                          <tr class="tr_row_duration1">
                            <td>
                              <input type="file" class="form-control"  id="img1" name="img1" required="true" data-parsley-errors-container="#img" data-parsley-error-message="Please Upload Image">
                              <span id="img_msg1" style="color:red;"></span>
                            </td>
                             <td style="text-align: center;"  width="10%">
                               <a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removedurationRow_ajax(1)"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                  </div>                  
                </div>
                <div class="col-md-6">
                    <div class="box-body">
                      <table class="table table-bordered" id="myTable">
                      <thead style="background-color: #00cc445c;">
                        <tr>
                          <th width="30%">Ingrediants</th>
                          <th width="30%">Ingrediants Image</th>
                          <th class="text-center"><a href="javascript:void(0);" class="btn btn-info addRow" onclick="addintRow()"><i class="fa fa-plus"></i></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody id="int_body">
                        <input type="hidden" id="int_flag" name="int_flag" value="1">
                          <tr class="tr_row_int1">
                            <td>
                                <input type="text" class="form-control" id="int_title1" name="int_title1" placeholder="Enter Ingrediants Name" required="true" data-parsley-errors-container="#inttitle_error" data-parsley-error-message="Please enter title.">
                                <div id="#inttitle_error" style="color:red;"></div>
                            </td>
                            <td>
                              <input type="file" class="form-control"  id="int_img1" name="int_img1" required="true" data-parsley-errors-container="#int_img_msg1" data-parsley-error-message="Please upload image.">
                              <span id="int_img_msg1" style="color:red;"></span>
                            </td>
                             <td style="text-align: center;"  width="10%">
                               <a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removeintRow_ajax(1)"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                      </tbody>
                    </table>
                    </div>
                  </div>
              </div>


              <div class="row">
                <div class="col-md-12">
                    <div class="box-body">
                         <div class="form-group">
                       <label for="name">What Makes Dish Special</label>
                      <textarea name="what_makes_dish_special" id="what_makes_dish_special"></textarea>
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
       var tr = '<tr class="tr_row_duration' + img_flag + '"><td><input type="file" class="form-control"  id="img'+img_flag+'" name="img'+img_flag+'" required="true" data-parsley-errors-container="#img" data-parsley-error-message="Please upload image"><span id="img_msg1" style="color:red;"></span></td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removedurationRow_ajax(' + img_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
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
       var tr = '<tr class="tr_row_int' + int_flag + '"><td><input type="text" class="form-control" id="int_title'+int_flag+'" name="int_title'+int_flag+'" placeholder="Enter Ingrediants Name" required="true" data-parsley-errors-container="#inttitle_error" data-parsley-error-message="Please enter title"> <div id="#inttitle_error" style="color:red;"></div></td><td><input type="file" class="form-control"  id="int_img'+int_flag+'" name="int_img'+int_flag+'" required="true" data-parsley-errors-container="#int_img_msg'+int_flag+'" data-parsley-error-message="Please upload image"><span id="int_img_msg'+int_flag+'" style="color:red;"></span></td><td style="text-align:center"><a href="javascript:void(0);" class="btn btn-danger remove"  onclick="removeintRow_ajax(' + int_flag + ')"><i class="fa fa-trash"></i></a></td></tr>';
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