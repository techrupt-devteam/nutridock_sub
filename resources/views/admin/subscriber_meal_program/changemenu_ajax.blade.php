
     <div class="modal-header">
        <h5 class="modal-title">Day {{$program_data->day}} Menu Chanage</h5>
        <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>-->
      </div>
      <div class="modal-body">
              <?php// dd($program_data); ?>
           @include('admin.layout._status_msg')
            <form action="{{ url('/admin')}}/store_change_menu" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data">
              {!! csrf_field() !!}
              <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                        <label class="d-block">Menu Catgory<span style="color:red;" >*</span></label>
                         <select name="menu_category" id="menu_category" class="form-control" required="true" data-parsley-errors-container="#category_error" data-parsley-error-message="Please select category.">
                           <option value="">-Select Category-</option>
                           @foreach($menu_category as $menu_cat_value)
                           <option value="{{$menu_cat_value->id}}" {{ ($program_data->menu_category_id == $menu_cat_value->id) ? 'selected' : ('') }}>{{$menu_cat_value->name}}</option>
                           @endforeach
                         </select>  
                         <div id="category_error" style="color:red;"></div>
                      </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group"> 
                      <?php 
                             $data       = explode(",",$program_data->specification_id); 
                      ?>
                      <label  class="d-block">Menu Specification<span style="color:red;">*</span></label>
                       <select name="menu_specifiation" id="menu_specifiation" class="form-control" required="true" data-parsley-errors-container="#menu_specifiation_error" data-parsley-error-message="Please select specification." multiple="multiple">
                         <option value="">-Select Menu Specification-</option>
                         @foreach($menu_specification as $specification_value)
                         <?php
                            $selected   = "";
                            if(in_array($specification_value['id'],$data))
                            {
                              $selected = "selected"; 
                            }
                         ?>

                         <option value="{{$specification_value['id']}}" {{$selected}}>{{$specification_value['specification_title']}}</option>
                         @endforeach
                       </select>  
                       <div id="menu_specifiation_error" style="color:red;"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                      <label class="d-block">Meal Type<span style="color:red;" >*</span></label>

                       <select name="meal_type" id="meal_type" class="form-control" required="true" data-parsley-errors-container="#meal_type_error" data-parsley-error-message="Please meal type." onchange="get_menu();">
                         <option value="">-Select Meal Type-</option>
                         @foreach($meal_type as $meal_type_value)
                         <option value="{{$meal_type_value->meal_type_id}}" {{ ($program_data->mealtype == $meal_type_value->meal_type_id)?"selected":''}}>{{$meal_type_value->meal_type_name}}</option>
                         @endforeach
                       </select> 
                       <div id="meal_type_error" style="color:red;"></div>
                    </div>
                </div>
                <div class="col-md-6">               
                    <div class="form-group">
                      <label class="d-block">Menu<span style="color:red;" >*</span></label>
                       <select name="menu_id" id="menu_id" class="form-control" required="true" data-parsley-errors-container="#menu_error" data-parsley-error-message="Please select category.">
                         <option value="">-Select Category-</option>
                        </select>  
                       <div id="menu_error" style="color:red;"></div>
                    </div>
                </div>

              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </form>
        </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>      
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/parsley.js"></script>
<script src="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/js/select2.full.min.js"></script>
<link rel="stylesheet" href="{{ url('/admin_css_js')}}/css_and_js/admin/select2/dist/css/select2.min.css">      
<style type="text/css">
.d-block{display:block}.w-100{width:100%!important}.select2-selection{width:100%!important}.select2{width:100%!important}.select2-container--default .select2-selection--multiple{background-color:#fff!important;cursor:text!important}.select2-container--default .select2-selection--multiple{background-color:#fff!important;border:1px solid #d2d6de!important;border-radius:0!important;cursor:text!important}.select2-container--default .select2-selection--single .select2-selection__arrow{height:34px!important;position:absolute!important;top:1px!important;right:1px!important;width:20px!important}
</style>
<script type="text/javascript">
$('#menu_specifiation').select2();
$('#menu_id').select2();
$('#menu_category').select2();
$('#meal_type').select2();

  function viewDetails(program_id) 
    { 

       var program_id = program_id;
     
       $.ajax({
            url: "{{url('/admin')}}/edit_subscriber_default_menu",
            type: 'post',
            data: { program_id:program_id },
            success: function (data) 
            {
              $('#content').html(data);
            }
        });
    }
  function get_menu()
  {
      var meal_type             = $('#meal_type').val();
      var menu_Category         = $('#menu_category').val();
      var selected_specifiation = [];

      $('#menu_specifiation :selected').each(function(){
         selected_specifiation[$(this).val()] = $(this).val();
      });
     
      $.ajax({
          url: "{{url('/admin')}}/get_menu_dropdown",
          type: 'post',
          data: { meal_type:meal_type,menu_Category:menu_Category,specification_array:selected_specifiation},
          success: function (data) 
          {
            alert(data);
            $('#menu_id').html(data);
          }
       });
  }

</script>
